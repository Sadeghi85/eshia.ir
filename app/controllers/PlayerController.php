<?php

class PlayerController extends BaseController {

	protected $layout;
	
	public function __construct()
	{
		//$this->layout = '';
    }
	
	public function showPage($req)
	{
		$req = str_replace('.wma', '', $req);
		$baseDir = Config::get('app_settings.data_path') . '\\';
		$baseURL = Config::get('app_settings.data_url') . '/';
		$url = '';
		$path = realpath($baseDir . str_replace('/', '\\', $req) . '.mp4');
		
		if(strpos($path, $baseDir)) {
			die('Invalid path');
		} else if (file_exists($path)) {
			$url = $baseURL . $req . '.mp4';
		} else {
			die('Audio not found');
		}
		
		return View::make('player', array('url' => $url));
	}
}