<?php

class SiteController extends BaseController {

	public function index($path)
	{
		$dataPath = preg_replace('#\\\\+$#', '', str_replace('/', '\\', Config::get('app_settings.data_path')));
		$dataUrl = Config::get('app_settings.data_url');
		
		
		
		
		return $path;
	}

}
