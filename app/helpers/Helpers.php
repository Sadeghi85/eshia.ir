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
		//$path = preg_replace('#\++|(%20)+| +#', '_', $path);
		$path = preg_replace('#\++|(%20)+| +#', '%20', $path);
		$path = str_replace('"', '%22', $path);
		
		return Redirect::to($path, $status, $headers, $secure);
	}
	
	public static function to($path = null, $parameters = array(), $secure = null)
	{
		//$path = preg_replace('#\++|(%20)+| +#', '_', $path);
		$path = preg_replace('#\++|(%20)+| +#', '%20', $path);
		
		return url($path, $parameters, $secure);
	}
	
	public static function link_to($url, $title = null, $attributes = array(), $secure = null)
	{
		//$url = preg_replace('#\++|(%20)+| +#', '_', $url);
		$url = preg_replace('#\++|(%20)+| +#', '%20', $url);
		
		return link_to($url, $title, $attributes, $secure);
	}
	
	public static function persianizeString($string)
	{
		$_utf8String = @iconv('UTF-8', 'UTF-8//IGNORE', $string);
		If ( ! $_utf8String)
		{
			Log::error(sprintf('Detected an incomplete multibyte character in string "%s".', base64_encode($string)));
		}
		else
		{
			$string = $_utf8String;
		}
		
		$string = str_replace([pack('H*', 'efbbbf'), '&#65279;'], ' ', $string);
		$string = str_replace([pack('H*', 'c2a0'), '&#160;'], ' ', $string);
		$string = str_replace(pack('H*', '00'), '', $string);
		$string = str_replace(pack('H*', 'd980'), '', $string); # مـزمل
		$string = str_replace([pack('H*', 'd98a'), pack('H*', 'd989'), pack('H*', 'd8a6')], pack('H*', 'db8c'), $string); # ی
		$string = str_replace([pack('H*', 'd8a5'), pack('H*', 'd8a3'), pack('H*', 'd8a2')], pack('H*', 'd8a7'), $string); # ا
		$string = str_replace([pack('H*', 'd8a9'), pack('H*', 'db80')], pack('H*', 'd987'), $string); # ه
		$string = str_replace(pack('H*', 'd8a4'), pack('H*', 'd988'), $string); # و
		$string = str_replace(pack('H*', 'd983'), pack('H*', 'daa9'), $string); # ک
		
		$string = preg_replace('#[[:space:]]+#u', ' ', $string);
		$string = preg_replace('#\p{Cf}+#u', ' ', $string); # zwnj, etc.;
		$string = preg_replace('#\p{M}+#u', '', $string);
		
		return trim($string);
	}
	
	public static function getStringToUintHash($str)
	{
		return sprintf('%u', crc32($str));
	}
	
	public static function getPreferredTeachersArray()
	{
		$locale = App::getLocale();
		$teachers = Lang::get('teachers');
		
		$hashes = [];
		
		foreach ($teachers as $latinName => $teacher) {
			if (isset($teacher[$locale]) and $teacher[$locale] == 'true') {
				$hashes[] = self::getStringToUintHash(strtolower($latinName));
			}
			
		}
		
		return $hashes;
	}
	
	
	
}