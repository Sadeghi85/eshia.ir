<?php

class SiteController extends BaseController {

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
		
		foreach ($defaultDocuments as $doc)
		{
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
	
	private function _getContent($rawContent)
	{
		# Convert every html to UTF-8 and do some cleaning
	
		$content = '';
		$tempContent = @iconv('UTF-8', 'UTF-8//IGNORE', $rawContent);

		if ($tempContent && mb_detect_encoding($rawContent, 'UTF-8', TRUE))
		{
			$rawContent = $tempContent;
		}
		else
		{
			$tempContent = @iconv('UTF-16', 'UTF-8//IGNORE', $rawContent);
			
			if ($tempContent)
			{
				$rawContent = $tempContent;
			}
			else
			{
				$rawContent = @iconv('CP1256', 'UTF-8//IGNORE', $rawContent);
			}
		}

		if (preg_match('#((<body[^<>]*>)(.*?)</body>)#is', $rawContent, $body))
		{
			if (preg_match('#<head[^<>]*>(.*?)</head>#is', $rawContent, $head))
			{
				if (preg_match_all('#(<style[^<>]*>.*?</style>)#is', $head[1], $styles))
				{
					foreach ($styles[1] as $style)
					{
						$content .= $style;
					}
				}
				
				if (preg_match_all('#(<script[^<>]*>.*?</script>)#is', $head[1], $scripts))
				{
					foreach ($scripts[1] as $script)
					{
						$content .= preg_replace('#src\s*=\s*([\'"])([^\'"]*)[\'"]#i', 'src=$1/$2$1', $script);
					}
				}
			}
			
			$content .= $body[1];

		}
		else
		{
			$content = $rawContent;
		}
		
		return $content;
	}
	
	public function index($requestPath)
	{
		$dataPath    = preg_replace('#\\\\+$#', '', str_replace('/', '\\', Config::get('app_settings.data_path')));
		$localPath = trim(str_replace('/', '\\', $requestPath), '\\');
		
		$dataUrl = Config::get('app_settings.data_url');
		
		$docObject = $this->_getDocument($dataPath.'\\'.$localPath);
		
		# We've found a default page
		if ($docObject->defaultDocument) {
			return Response::view('page', array('content' => $this->_getContent(file_get_contents($docObject->completePath))));
		}
		# Either static file or 404
		else {
			$localPathSegments = explode('\\', $localPath);
			
			# Static file
			if ($docObject->completePath and FALSE !== strpos(end($localPathSegments), '.')) {
				return Redirect::to($dataUrl.'/'.$requestPath, 301, array('Cache-Control' => 'public,max-age=86400'));
			} else {
				App::abort(404);
			}
		}
	}
}
