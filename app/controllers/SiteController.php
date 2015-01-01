<?php

class SiteController extends BaseController {

	
	public function index($path)
	{
		$dataPath = preg_replace('#\\\\+$#', '', str_replace('/', '\\', Config::get('app_settings.data_path')));
		$dataUrl = Config::get('app_settings.data_url');
		$defaultDocuments = Config::get('app_settings.default_documents');
		
		if (preg_match('#\.(?!html?)#', $path)) {
			return Redirect::to(sprintf('%s/%s', $dataUrl, $path), 301);
			
		}
		
		//$path = str_replace('/', '\\', preg_replace('#/[^\.]*\..*#', '', $path));
		
		
		foreach ($defaultDocuments as $doc) {
			if (preg_match('#\.(?=html?)#', $path)) {
				$file = sprintf('%s\\%s', $dataPath, $path);
			} else {
				$file = sprintf('%s\\%s\\%s', $dataPath, $path, $doc);
			}
			
			//print $file.'<br>';
			if (is_file($file)) {
				//dd($file);
				
				$fileContent = file_get_contents($file);
				$content = '';
				
				
				
				$temp = @iconv('UTF-8', 'UTF-8//IGNORE', $fileContent);

				if ($temp && mb_detect_encoding($fileContent, 'UTF-8', TRUE)) {
					$fileContent = $temp;
				} else {
					$temp = @iconv('UTF-16', 'UTF-8//IGNORE', $fileContent);
					
					if ($temp) {
						$fileContent = $temp;
					} else {
						$fileContent = @iconv('CP1256', 'UTF-8//IGNORE', $fileContent);
					}
				}

				if (preg_match('#((<body[^<>]*>)(.*?)</body>)#is', $fileContent, $body)) {
					if (preg_match('#<head[^<>]*>(.*?)</head>#is', $fileContent, $head)) {
						if (preg_match_all('#(<style[^<>]*>.*?</style>)#is', $head[1], $styles)) {
							foreach ($styles[1] as $style) {
								$content .= $style;
							}
						}
						
						if (preg_match_all('#(<script[^<>]*>.*?</script>)#is', $head[1], $scripts)) {
							foreach ($scripts[1] as $script) {
								$content .= $script;
							}
						}
					}
					
					$content .= $body[1];

				}
				else
				{
					$content .= $fileContent;
				}
				
				
				
				
				
				
				
				return View::make('page', compact('content'));
				

				
			}
			
		}
		
	}

}
