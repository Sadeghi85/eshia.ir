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
		$mp4NotFound = false;
		$hlsNotFound = false;
		$hlsurl = '';
		$mp4Path = realpath($baseDir . str_replace('/', '\\', $req) . '.mp4');
		$hlsPath = realpath($baseDir . str_replace('/', '\\', $req) . '.m3u8');
		
		if(strpos($mp4Path, $baseDir) or strpos($hlsPath, $baseDir)) {
			die('Invalid path');
		}

		if (file_exists($mp4Path)) {
			$url = $baseURL . $req . '.mp4';
		} else {
			$mp4NotFound = true;
		}
		
		if (file_exists($hlsPath)) {
			$hlsurl = $baseURL . $req . '.m3u8';
		} else {
			$hlsNotFound = true;
		}
		
		if ($mp4NotFound and $hlsNotFound) {
			die('Audio not found');
		}
		
		return View::make('player', array('url' => $url, 'hlsurl' => $hlsurl));
	}
}