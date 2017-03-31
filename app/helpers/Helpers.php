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
	
	public static function prepareSearchFilters(&$lessonArray, &$teacherArray, &$yearArray)
	{
		$name = App::getLocale() == 'fa' ? 'name' : 'arname';
		
		$xmlContent = file_get_contents(base_path() . '\\App_Data\\Lessons.xml');
		
		$xml = new DomDocument;
		
		try	{
			$xml->loadXML($xmlContent, LIBXML_NOBLANKS);
		}
		catch (\Exception $e) {
			Log::error('Error loading Lessons.xml. ( '. __FILE__ .' on line '. __LINE__ .' )');
			self::setExceptionErrorMessage(Lang::get('app.page_display_error'));
			
			App::abort(500);
		}
		
		$xpath = new DOMXpath($xml);
		
		if ($lessonArray)
		{
			$key = $lessonArray;
			
			if ($key['lesson'])
			{
				$xpathQuery = sprintf('//%s[(not(@%s) or @%s != \'%s\') and (@%s=\'%s\')]/%s[@%s=\'%s\']', 'group', 'hide', 'hide', '1', 'key', $key['group'], 'lesson', 'key', $key['lesson']);
			}
			else
			{
				$xpathQuery = sprintf('//%s[(not(@%s) or @%s != \'%s\') and (@%s=\'%s\')]/%s', 'group', 'hide', 'hide', '1', 'key', $key['group'], 'lesson');
			}
			
			$lessonNode = $xpath->query($xpathQuery, $xml);
			$lessonArray = [];
			
			foreach ($lessonNode as $lesson)
			{
				$lessonArray[] = self::getStringToUintHash($lesson->getAttribute('key'));
			}
		}
		
		if ($teacherArray)
		{
			$key = $teacherArray;
			
			if ($key['lesson'])
			{
				$xpathQuery = sprintf('//%s[(not(@%s) or @%s != \'%s\') and (@%s=\'%s\')]/%s[@%s=\'%s\']/%s[@%s=\'%s\']', 'group', 'hide', 'hide', '1', 'key', $key['group'], 'lesson', 'key', $key['lesson'], 'teacher', 'key', $key['teacher']);
			}
			else
			{
				$xpathQuery = sprintf('//%s[(not(@%s) or @%s != \'%s\') and (@%s=\'%s\')]/%s/%s[@%s=\'%s\']', 'group', 'hide', 'hide', '1', 'key', $key['group'], 'lesson', 'teacher', 'key', $key['teacher']);
			}
			
			$teacherNode = $xpath->query($xpathQuery, $xml);
			$teacherArray = [];
			
			foreach ($teacherNode as $teacher)
			{
				$teacherArray[] = self::getStringToUintHash($teacher->getAttribute('key'));
			}
		}
		
		if ($yearArray)
		{
			$key = $yearArray;
			
			if ($key['lesson'])
			{
				$xpathQuery = sprintf('//%s[(not(@%s) or @%s != \'%s\') and (@%s=\'%s\')]/%s[@%s=\'%s\']/%s[@%s=\'%s\']/%s[@%s=\'%s\']', 'group', 'hide', 'hide', '1', 'key', $key['group'], 'lesson', 'key', $key['lesson'], 'teacher', 'key', $key['teacher'], 'year', 'key', $key['year']);
			}
			else
			{
				$xpathQuery = sprintf('//%s[(not(@%s) or @%s != \'%s\') and (@%s=\'%s\')]/%s/%s[@%s=\'%s\']/%s[@%s=\'%s\']', 'group', 'hide', 'hide', '1', 'key', $key['group'], 'lesson', 'teacher', 'key', $key['teacher'], 'year', 'key', $key['year']);
			}
			
			$yearNode = $xpath->query($xpathQuery, $xml);
			$yearArray = [];
			
			foreach ($yearNode as $year)
			{
				$yearArray[] = self::getStringToUintHash($year->getAttribute('key'));
			}
		}
		
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