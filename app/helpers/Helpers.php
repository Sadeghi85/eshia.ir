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
		
		$string = str_replace(pack('H*', 'efbbbf'), '', $string);
		$string = str_replace(pack('H*', '00'), '', $string);
		$string = str_replace(pack('H*', 'c2a0'), ' ', $string);
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
	
	public static function insertSurehInFootnote($content)
	{
		$content = preg_replace('#</ref>#', "</ref>\r\n", $content);
		
		$content = preg_replace_callback(
						sprintf
						(
							'#<ref>.*?(%s|%s|%s)\s*([\p{L} \p{M}]+)\s*%s\s*(%s|%s|%s|%s|%s|%s|%s|%s)\s*(\d+)([^<]*)</ref>#iu',
							# سوره
							base64_decode('2LPZiNix2Yc='),
							# سورة
							base64_decode('2LPZiNix2Kk='),
							# السورة
							base64_decode('2KfZhNiz2YjYsdip'),
							# ،
							base64_decode('2Iw='),
							# آیه
							base64_decode('2KLbjNmH'),
							# آيه
							base64_decode('2KLZitmH'),
							# آية
							base64_decode('2KLZitip'),
							# الآية
							base64_decode('2KfZhNii2YrYqQ=='),
							# ایه
							base64_decode('2KfbjNmH'),
							# ايه
							base64_decode('2KfZitmH'),
							# اية
							base64_decode('2KfZitip'),
							# الاية
							base64_decode('2KfZhNin2YrYqQ==')
						),
						function ($matches)
						{
							$persianizedSurehString =
								preg_replace
								(
									# ال
									sprintf('#^%s\s*#iu', base64_decode('2KfZhA==')),
									'',
									Helpers::persianizeString($matches[2])
								);
							
							$surehList   = Config::get('sureh.list');
							
							$surehString = 
								array_key_exists($persianizedSurehString, $surehList)
								?
									$persianizedSurehString
								:
									''
								;
							
							if ($surehString)
							{
								$sureh = $surehList[$surehString][1];
								$page = 0;
								foreach ($sureh as $k => $v)
								{
									if ($matches[4] >= $k)
									{
										$page = $v;
									}
								}
								$link = sprintf('http://lib.eshia.ir/17001/1/%s/%s', $page, $matches[4]);
								
								return
									sprintf
									(
										'<ref>[%s %s %s%s %s %s%s]</ref>',
										$link,
										$matches[1],
										$matches[2],
										base64_decode('2Iw='),
										$matches[3],
										$matches[4],
										$matches[5]
									);
							}
							else
							{
								return $matches[0];
							}
						},
						
						$content
					);
	
		return $content;
		
	}
	
	
	
	
	
	
	
	
	
	
	public static function insertSomethingInFootnote($content)
	{
	
	
		$outlink_counter = 0;
		$content = preg_replace_callback('#(?:^|>)[^<]*#i',
		//$content = preg_replace_callback('#<ref>([^\r\n]+?)</ref>#i',
				function ($matches) use (&$outlink_counter)
				{
					return preg_replace_callback('#(?<!\[)\[ *([^\[\]\r\n ]+) *([^\[\]\r\n]*) *\](?!\])#iu',
								function ($_outlink_matches) use (&$outlink_counter)
								{
									$outlink_counter++;
									
									$title = ($_outlink_matches[2] ? $_outlink_matches[2] : '['.$outlink_counter.']');
									
									return '<a href="'.$_outlink_matches[1].'" title="'.$title.'" name="outlink" target="_blank">'.$title.'</a><span class="outlink">&nbsp;&nbsp;&nbsp;&nbsp;</span>';
								},
							$matches[0]);
				},
			$content);

		$ref_matches = array();
		$footnotes = '';
		
		$content = preg_replace_callback('#<ref>([^\r\n]+?)</ref>#i',
						function ($matches) use (&$ref_matches)
						{
							static $c = 0;
							
							$ref_matches[] = $matches[1];
							$c++;
							
							return '<a href="#_ftn'.$c.'" name="_ftnref'.$c.'" title="'.strip_tags($matches[1]).'">['.$c.']</a>';
						},
					$content);
			
		if(isset($ref_matches[0]))
		{

			foreach($ref_matches as $k => $v )
			{
				$footnotes .= '<div><a href="#_ftnref'.($k+1).'" name="_ftn'.($k+1).'">['.($k+1).']</a> '.$v.'</div>'; 
			}

		}

		$content = '<div>'.$content . '</div><hr>' . $footnotes;
		
		$content = preg_replace_callback('#(?:^|>)[^<]*#i',
			function ($matches)
			{
				return str_replace(
						array('0','1','2','3','4','5','6','7','8','9'),
						array(pack('H*', 'd9a0'),pack('H*', 'd9a1'),pack('H*', 'd9a2'),pack('H*', 'd9a3'),pack('H*', 'd9a4'),pack('H*', 'd9a5'),pack('H*', 'd9a6'),pack('H*', 'd9a7'),pack('H*', 'd9a8'),pack('H*', 'd9a9')),
						$matches[0]
					);
			},
		$content);
		$content = preg_replace_callback('#(<script[^>]*>)([^<]*)(</script>)#i',
					function ($matches)
					{
						return sprintf('%s%s%s', $matches[1], 
							str_replace(
								array(pack('H*', 'd9a0'),pack('H*', 'd9a1'),pack('H*', 'd9a2'),pack('H*', 'd9a3'),pack('H*', 'd9a4'),pack('H*', 'd9a5'),pack('H*', 'd9a6'),pack('H*', 'd9a7'),pack('H*', 'd9a8'),pack('H*', 'd9a9')),
								array('0','1','2','3','4','5','6','7','8','9'),
								$matches[2]
							),
							$matches[3]);
					},
				$content);

		return $content;
		
	}
	
}