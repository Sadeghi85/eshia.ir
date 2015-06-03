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
		$content = '';
		
		$rawContent =  	preg_replace('#\p{Cf}+#u', pack('H*', 'e2808c'),
							str_replace(pack('H*', 'c2a0'), ' ',
								str_replace(pack('H*', 'efbbbf'), '',
									str_replace(pack('H*', '00'), '',
										iconv('UTF-8', 'UTF-8//IGNORE',
											@file_get_contents($pagePath)
										)
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
	
	public function index($requestPath)
	{
		$dataPath = preg_replace('#\\\\+$#', '', str_replace('/', '\\', Config::get('app_settings.data_path')));
		$localPath = trim(str_replace('/', '\\', $requestPath), '\\');
		
		$dataUrl = Config::get('app_settings.data_url');
		
		$docObject = $this->_getDocument($dataPath.'\\'.$localPath);
		
		# We've found a default page
		if ($docObject->defaultDocument) {
			$searchForm = $teacher = $course = $year = '';
			
			// preg_match('#(?:ar/)?feqh/archive/(?:text/)?([^/]+)/([^/]+)/([^/]+)#i', Request::path(), $matches);
			
			// if (count($matches) == 4) {
				// $teacher = $matches[1];
				// $course = $matches[2];
				// $year = explode('_', $matches[3]);
				// $year = array_shift($year);
			
				// $searchForm = View::make('search-form', ['teacher' => $teacher, 'course' => $course, 'year' => $year]);
			// }
			
			$this->layout->content = View::make('page', ['content' => $this->_getContent($docObject->completePath), 'searchForm' => $searchForm]);
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
