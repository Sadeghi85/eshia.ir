<?php

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
}
