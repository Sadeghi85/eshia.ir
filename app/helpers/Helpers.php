<?php

class Helpers {

	private static $_exceptionErrorMessage = null;
	
	public static function getExceptionErrorMessage()
	{
		return self::$_exceptionErrorMessage;
	}
	
	public static function setExceptionErrorMessage($message)
	{
		self::$_exceptionErrorMessage = $message;
	}
	
	public static function redirect($path, $status = 302, $headers = array(), $secure = null)
	{
		$path = preg_replace('#\++|(%20)+| +#', '_', $path);
		$path = str_replace('"', '%22', $path);
		
		return Redirect::to($path, $status, $headers, $secure);
	}
	
	public static function to($path = null, $parameters = array(), $secure = null)
	{
		$path = preg_replace('#\++|(%20)+| +#', '_', $path);
		
		return url($path, $parameters, $secure);
	}
	
	public static function link_to($url, $title = null, $attributes = array(), $secure = null)
	{
		$url = preg_replace('#\++|(%20)+| +#', '_', $url);
		
		return link_to($url, $title, $attributes, $secure);
	}
	
}