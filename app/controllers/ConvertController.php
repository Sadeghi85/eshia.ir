<?php

use Sadeghi85\Docx2Html\Docx2Html;

class ConvertController extends BaseController {

	
	public function index($teacher, $course)
	{
		
		
		return Response::view('convert', compact('teacher', 'course'));

	}
	
	private function _footnote($content)
	{
		$content = preg_replace('#</ref>#', "</ref>\r\n", $content);
		
		$content = preg_replace_callback(sprintf('#<ref> *%s *([\p{L} \p{M}]+) *%s *(%s|%s|%s) *(\d+) *([^<]*)</ref>#iu', base64_decode('2LPZiNix2Yc='), base64_decode('2Iw='), base64_decode('2KLbjNmH'), base64_decode('2KLZitmH'), base64_decode('2KLZitip')),
					function ($matches)
					{
						$surehList = Config::get('sureh.list');
						$surehString = array_key_exists(Helpers::persianizeString($matches[1]), $surehList) ? Helpers::persianizeString($matches[1]) : array_key_exists(preg_replace(sprintf('#^%s#iu', base64_decode('2KfZhA==')), '', Helpers::persianizeString($matches[1])), $surehList) ? trim(preg_replace(sprintf('#^%s#iu', base64_decode('2KfZhA==')), '', Helpers::persianizeString($matches[1]))) : '';
						
						if($surehString)
						{
							$sureh = $surehList[$surehString][1];
							$page = 0;
							foreach ($sureh as $k => $v)
							{
								if ($matches[3] >= $k)
									$page = $v;
							}
							$link = sprintf('http://lib.eshia.ir/17001/1/%s/%s', $page, $matches[3]);
							
							return sprintf('<ref>[%s %s %s%s %s %s %s]</ref>', $link, base64_decode('2LPZiNix2Yc='), $matches[1], base64_decode('2Iw='), $matches[2], $matches[3], $matches[4]);
						}
						else
						{
							return $matches[0];
						}
					},
				$content);
		
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
	
	public function convert()
	{
		$validator = Validator::make(Input::all(), array('doc' => 'required'));
	
		if ($validator->fails())
		{
			App::abort(404);
			
			// Ooops.. something went wrong
			//$messages = $validator->messages();
			
			//return Response::json(array('content' => $messages->first('doc')));
			//return Redirect::back()->withErrors($validator );
		}

		$doc = Input::file('doc');
		//$hash = sha1_file($doc->getRealPath());
		$hash = sha1(microtime(true).$doc->getClientOriginalName());
		
		try
		{
			$converter = new Docx2Html($doc->getRealPath());
		}
		catch (\Exception $e)
		{
			//return Response::json(array('content' => 'Error'));
			App::abort(404);
		}
		
		
		$content = $converter->getHtml();
		
		$content = $this->_footnote($content);
		
		foreach (Config::get('eshia') as $color => $class)
		{
			$content = preg_replace('#<span class="'.$color.'"#i', '<span class="'.$class.'"', $content);
		}
		
		if ( ! is_null(Input::get('download')))
		{
			$link = '<link href="eShia.css" rel="stylesheet">';
		}
		else
		{
			$link = '<link href="/assets/css/eShia.css" rel="stylesheet">';
		}
		
		$html = <<<EOT
<html><head>
{$link}
<meta charset="UTF-8">
</head>
<body>
{$content}
</body></html>
EOT;
		
		if ( ! is_null(Input::get('download')))
		{
			$filename = trim(preg_replace('/[^\x20-\x7e]*/', '', str_replace('.'.$doc->getClientOriginalExtension(), '', $doc->getClientOriginalName())));
			$filename = $filename ? $filename : md5(microtime(true));
			
			$filepath = storage_path().'/'.$filename.'.zip';
			$zip = new \ZipArchive();
			$res = $zip->open($filepath, ZipArchive::CREATE);
			
			if (version_compare(PHP_VERSION, '5.4.0') < 0) $zip->addEmptyDir($filename);
			$zip->addFromString($filename.'/eShia.css', file_get_contents(public_path().'/assets/css/eShia.css'));
			$zip->addFromString($filename.'/Default.htm', $html);
			$zip->close();
			
			
			App::finish(function($request, $response) use ($filepath)
			{
				unlink($filepath);
			});
			
			return Response::download($filepath);
			
		}
		else
		{
			return Response::json(array('content' => $html));
		}

	}
}
