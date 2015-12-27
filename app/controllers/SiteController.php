<?php

use Sadeghi85\JDateTime\JDateTime;

class SiteController extends BaseController {

	protected $layout;
	
	public function __construct()
	{
		$this->layout = 'layouts.master';
    }
	
	private function _getDocument($basePath)
	{
		$defaultDocuments = Config::get('app_settings.default_documents');
		
		$docObject = new stdClass;
		$docObject->defaultDocument = '';
		$docObject->completePath    = '';
		
		# Static file
		if (is_file($completePath = $basePath)) {
			$docObject->defaultDocument = '';
			$docObject->completePath    = $completePath;
		}
		
		foreach ($defaultDocuments as $doc) {
			# $basePath already contains defaultDocument
			if (FALSE !== stripos($basePath, $doc)) {
				$docObject->defaultDocument = $doc;
				$docObject->completePath    = $basePath;
				break;
			}
			
			if (is_file($completePath = $basePath.$doc)) {
				$docObject->defaultDocument = $doc;
				$docObject->completePath    = $completePath;
				break;
			}

			if (is_file($completePath = $basePath.'\\'.$doc)) {
				$docObject->defaultDocument = $doc;
				$docObject->completePath    = $completePath;
				break;
			}
		}
		
		return $docObject;
	}
	
	private function _getContent($pagePath)
	{
		if (is_readable($pagePath))
		{
			$content = '';
			
			$_utf8Content = @iconv('UTF-8', 'UTF-8//IGNORE', file_get_contents($pagePath));
			If ( ! $_utf8Content)
			{
				Log::error(sprintf('Detected an incomplete multibyte character in file "%s".', $pagePath));
				
				App::abort('404');
			}
			
			$rawContent =  	preg_replace('#\p{Cf}+#u', pack('H*', 'e2808c'),
								str_replace([pack('H*', 'c2a0'), '&#160;'], ' ',
									str_replace([pack('H*', 'efbbbf'), '&#65279;'], ' ',
										str_replace(pack('H*', '00'), '',
											$_utf8Content
										)
									)
								)
							);
			
			if (preg_match('#((<body[^>]*>)(.*?)(</body>))#isu', $rawContent, $body)) {
				if (preg_match('#<head[^>]*>(.*?)</head>#isu', $rawContent, $head)) {
					if (preg_match_all('#(<style[^>]*>.*?</style>)#isu', $head[1], $styles)) {
						foreach ($styles[1] as $style) {
							$content .= $style;
						}
					}
					
					if (preg_match_all('#(<script[^>]*>.*?</script>)#isu', $head[1], $scripts)) {
						foreach ($scripts[1] as $script) {
							$content .= $script;
						}
					}
				}

				$content .= $body[1];

			} else {
				$content = $rawContent;
			}
			
			return $content;
		}
		else
		{
			App::abort(404);
		}
	}
	
	public function index($requestPath, $archive = '', $text = '', $teacher = '', $course = '', $year = '', $date = '', $hilight = '')
	{
		if (strtolower($requestPath) == 'feqh') {
			$feqh = $requestPath;
			$requestPath = sprintf('/%s/%s/%s/%s/%s/%s/%s', $feqh, $archive, $text, $teacher, $course, $year, $date);
		}
		
		$dataPath = preg_replace('#\\\\+$#', '', str_replace('/', '\\', Config::get('app_settings.data_path')));
		$localPath = trim(str_replace('/', '\\', $requestPath), '\\');
		
		$dataUrl = Config::get('app_settings.data_url');
		
		$docObject = $this->_getDocument($dataPath.'\\'.$localPath);
		
		# We've found a default page
		if ($docObject->defaultDocument) {
			$content = $this->_getContent($docObject->completePath);
			
			if ($hilight) {
				if ( ! (preg_match('#\/search\/(.+\/)?[^\/]+#', Request::server('HTTP_REFERER')) or preg_match('#[\=\!\"\*\/\(\)\[\]\~\<\>\^\$\:\|\@\-]#', $hilight))) {
					$hilight = preg_replace('#([\p{N}\p{L}][\p{N}\p{L}\p{M}]*)#iu', '=$1', $hilight);
				}
				
				$_content =  with(new \Sphinx\SphinxClient)->buildExcerpts(compact('content'), Config::get('app_settings.search_index_main_name', 'www_eshia_ir_main'), $hilight,
								array
								(
									'query_mode' => true,
									'limit' => 0,
									'chunk_separator' => '',
									'exact_phrase' => true,
									'html_strip_mode' => 'retain',
									'load_files' => false,
									'allow_empty' => false,
									'before_match' => '<span class="hilight">',
									'after_match' => '</span>'
								)
							);
				
				$content =  is_array($_content) ? (($_content = array_values($_content)[0]) != '' ? $_content : $content) : $content;
			}
			
			if ($teacher and $course and $year) {
				$this->layout->searchContentForm = View::make('search-content', compact('teacher', 'course', 'year'));
			}
			
			$this->layout->content = View::make('page', compact('content'));
			
			return;
		}
		# Either static file or 404
		else {
			$localPathSegments = explode('\\', $localPath);
			
			# Static file
			if ($docObject->completePath and FALSE !== strpos(end($localPathSegments), '.')) {
				return Redirect::to($dataUrl.'/'.$requestPath, 301, ['Cache-Control' => 'public,max-age=86400']);
			} else {
				App::abort(404);
			}
		}
	}
	
	public function showMonitoring()
	{
		$jDateTime = new JDateTime(false, true, 'Asia/Tehran');
		$today = $jDateTime->date("Ymd", time());
		
		$dbh = DB::connection('sqlsrv')->getPdo();
		$sql = "SELECT distinct [date],SUBSTRING(RIGHT('0'+CONVERT(varchar(9),[time]),9),1,6) as new_time,[operator],[folder],[path],[FileName],[FileExtension],[FileSize],[operation],[NewFileName] FROM [BaharSoundUtils].[dbo].[FileInputEvents]  where [date] = :date and [operation] in (:operation) and ([FileExtension] = 'wma' or [FileExtension] ='htm') order by date desc,new_time desc";
		$sth = $dbh->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
		$sth->execute([':date' => $today, ':operation' => '3']);
		$records = $sth->fetchAll(PDO::FETCH_OBJ);
		
		##$records = DB::connection('sqlsrv')->select('select top 10 * from [FileInputEvents] where date > ? order by date desc, time desc', array(13940806));
		//$records = 
			//FileInputEvent::distinct()
			##->select(['date','time','operator','folder','path','FileName','FileExtension','FileSize','operation'])
			//->select(DB::raw('date,SUBSTRING(RIGHT(\'0\'+CONVERT(varchar(9),time),9),1,6) as new_time,operator,folder,path,FileName,FileExtension,FileSize,operation'))
			
			# event #1: directory being created
			# event #2: file being created (also triggers #3)
			# event #3: file being changed
			# event #4: file or directory being deleted
			# event #5: 
			# event #6: file or directory being renamed
			// ->whereIn('operation', [3])
			// ->where(function($query)
			// {
				// $query->where('FileExtension', '=', 'wma')
				// ->orWhere('FileExtension', '=', 'htm');
			// })
			// ->orderBy('date', 'desc')
			// ->orderBy('new_time', 'desc')
			##->take(100)
			//->get();
		
		$results = [];
		
		foreach ($records as $key => $record) {
			$tmpString = $record->folder;
			
			if ( ! preg_match(sprintf('#^([\p{L}\p{M}\p{N}\p{Cf}[:space:]]+)-([\p{L}\p{M}\p{N}\p{Cf}[:space:]]+)-?((?:[\p{L}\p{M}\p{N}\p{Cf}]+)?)-?((?:[\p{N}]+)?)$#iu'), $tmpString, $matches)) {
				continue;
			}
			
			$results[$key]['teacher'] = $matches[1];
			$results[$key]['course'] = $matches[2];
			$results[$key]['type'] = $matches[3];
			$results[$key]['year'] = $matches[4];
			
			$results[$key]['extension'] = $record->FileExtension;
			if ($results[$key]['extension'] == 'wma') {
				$results[$key]['type'] = \Lang::get('app.voice');
			}
			elseif ($results[$key]['extension'] == 'htm') {
				$results[$key]['type'] = \Lang::get('app.text');
			}
			
			$tmpString = $record->date;
			$results[$key]['date'] = sprintf('%s/%s/%s', substr($tmpString, 0, 4), substr($tmpString, 4, 2), substr($tmpString, 6, 2));
			$tmpString = $record->new_time;
			$results[$key]['time'] = sprintf('%s:%s:%s', substr($tmpString, 0, 2), substr($tmpString, 2, 2), substr($tmpString, 4, 2));
			
			
			$results[$key]['file_size'] = number_format($record->FileSize);
			
			$results[$key]['file_name'] = '';
			if ($results[$key]['extension'] == 'htm') {
				$results[$key]['file_name'] = sprintf('%s', $record->path);
			} elseif ($results[$key]['extension'] == 'wma') {
				$results[$key]['file_name'] = sprintf('%s', $record->FileName);
			}
			
			
			$teacher = array_search($results[$key]['teacher'], \Lang::get('teachers'));
			if (false === $teacher) {
				foreach (\Lang::get('teachers') as $_key => $value) {
					if (false !== mb_strpos(\Helpers::persianizeString($value['name']), \Helpers::persianizeString($results[$key]['teacher']))) {
						$teacher = $_key;
						break;
					}
				}
			}
			
			$course = array_search($results[$key]['course'], \Lang::get('courses'));
			if (false === $course) {
				foreach (\Lang::get('courses') as $_key => $value) {
					if (false !== mb_strpos(\Helpers::persianizeString($value), \Helpers::persianizeString($results[$key]['course']))) {
						$course = $_key;
						break;
					}
				}
			}
			$year = $results[$key]['year'];
			$filename = $results[$key]['file_name'];
			
			$results[$key]['indexUrl'] = '';
			$results[$key]['fileUrl'] = '';
			if ($teacher and $course and $year) {
				if (@\Lang::get('teachers.'.$teacher)['ar'] == 'true') {
					$results[$key]['indexUrl'] = sprintf('http://eshia.ir/Ar/Feqh/Archive/%s/%s/%s_%s', $teacher, $course, $year, $year+1);
				}
				else {
					$results[$key]['indexUrl'] = sprintf('http://eshia.ir/Feqh/Archive/%s/%s/%s', $teacher, $course, $year);
				}
				
				if ($results[$key]['extension'] == 'wma') {
					$results[$key]['fileUrl'] = sprintf('http://eshia.ir/feqh/archive/voice/%s/%s/%s/%s.wma', $teacher, $course, $year, $filename);
				}
				else {
					$results[$key]['fileUrl'] = sprintf('http://eshia.ir/Feqh/Archive/text/%s/%s/%s/%s', $teacher, $course, $year, $filename);
				}
			}
		}
		
		$this->layout->content = View::make('monitoring', compact('results'));
		return;
	}
}
