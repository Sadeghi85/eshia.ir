<?php

use Sadeghi85\Docx2Html\Docx2Html;

class ConvertController extends BaseController {
	
	protected $layout;
	
	public function __construct()
	{
		$this->layout = 'layouts.master';
    }
	
	public function index($feqh, $archive, $convert, $teacher = '', $course = '', $year = '')
	{
		
		$this->layout->content = View::make('convert', compact('feqh', 'archive', 'convert', 'teacher', 'course', 'year'));

	}
	
	public function word()
	{
		
		// Creating the new document...
		$phpWord = new \PhpOffice\PhpWord\PhpWord();

		/* Note: any element you append to a document must reside inside of a Section. */

		// Adding an empty Section to the document...
		$section = $phpWord->addSection();
		// Adding Text element to the Section having font styled by default...
		$section->addText(
			htmlspecialchars(
				'"Learn from yesterday, live for today, hope for tomorrow. '
					. 'The important thing is not to stop questioning." '
					. '(Albert Einstein)'
			)
		);
		
		// Saving the document as OOXML file...
		$filepath  = storage_path().'\cache\helloWorld.docx';
		$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
		$objWriter->save($filepath);
		
		App::finish(function($request, $response) use ($filepath)
		{
			unlink($filepath);
		});
			
		return Response::download($filepath);
		
	}
	
	public function convert($feqh, $archive, $convert, $teacher = '', $course = '', $year = '')
	{
		$validator = Validator::make(Input::all(), ['doc' => 'required']);
	
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
		//$hash = sha1(microtime(true).$doc->getClientOriginalName());
		
		try
		{
			$converter = new Docx2Html($doc->getRealPath());
		}
		catch (\Exception $e)
		{dd($e);
			//return Response::json(array('content' => 'Error'));
			App::abort(404);
		}
		
		$content = $converter->getHtml();
		
		$_utf8Content = @iconv('UTF-8', 'UTF-8//IGNORE', $content);
		If ( ! $_utf8Content)
		{
			Log::error(sprintf('Detected an incomplete multibyte character in string "%s".', base64_encode($content)));
			
			App::abort('404');
		}
		
		$content =  preg_replace('#\p{Cf}+#u', pack('H*', 'e2808c'),
						str_replace(pack('H*', 'c2a0'), ' ',
							str_replace(pack('H*', 'efbbbf'), '',
								str_replace(pack('H*', '00'), '',
									$_utf8Content
								)
							)
						)
					);
		
		$content = Helpers::insertSurehInFootnote($content);
		$content = Helpers::insertSomethingInFootnote($content);
		
		
		
		
		
		foreach (Config::get('eshia') as $color => $class)
		{
			$content = preg_replace(sprintf('#<span class="%s#i', preg_quote($color)), '<span class="'.$class, $content);
		}
		
		$link = '<link href="/styles/eShia.css" rel="stylesheet"><link href="/styles/Default.css" rel="stylesheet">';
		
		$header = '';
		$_date  = str_split($doc->getClientOriginalName(), 2);
		$_year  = $_date[0];
		$_month = $_date[1];
		$_day   = $_date[2];
		## $year differs from $_year
		if (View::exists(sprintf('convert/%s/%s/%s/header', $teacher, $course, $year)))
		{
			$header = View::make(sprintf('convert/%s/%s/%s/header', $teacher, $course, $year), ['year' => $_year, 'month' => $_month, 'day' => $_day]);
		}
		
		$html = <<<EOT
<html><head>
{$link}
<meta charset="UTF-8">
</head>
<body>
<div id="content">
<div class="text-page">
<div class="course-header">
{$header}
</div>
<div class="course-content">
{$content}
</div>
</div>
</div>
</body></html>
EOT;
		
		if ( ! is_null(Input::get('download')))
		{
			$html = str_ireplace('<link href="/', '<link href="', $html);
			
			$filename = trim(preg_replace('/[^\x20-\x7e]*/', '', str_replace('.'.$doc->getClientOriginalExtension(), '', $doc->getClientOriginalName())));
			$filename = $filename ? $filename : md5(microtime(true));
			
			$filepath = storage_path().'/cache/'.$filename.'.zip';
			$zip = new \ZipArchive();
			$res = $zip->open($filepath, ZipArchive::CREATE);
			
			if (version_compare(PHP_VERSION, '5.4.0') < 0)
			{
				$zip->addEmptyDir($filename);
				$zip->addEmptyDir($filename.'/Styles');
				$zip->addEmptyDir($filename.'/Styles/Fonts');
			}
			$zip->addFromString($filename.'/Styles/eShia.css', file_get_contents(Config::get('app_settings.data_path').'\\Styles\\eShia.css'));
			$zip->addFromString($filename.'/Styles/Default.css', file_get_contents(Config::get('app_settings.data_path').'\\Styles\\Default.css'));
			$zip->addFromString($filename.'/Styles/Fonts/eshiatrad.eot', file_get_contents(Config::get('app_settings.data_path').'\\Styles\\Fonts\\eshiatrad.eot'));
			$zip->addFromString($filename.'/Styles/Fonts/eshiatrad.ttf', file_get_contents(Config::get('app_settings.data_path').'\\Styles\\Fonts\\eshiatrad.ttf'));
			$zip->addFromString($filename.'/Default.htm', $html);
			$zip->close();
			
			
			App::finish(function($request, $response) use ($filepath)
			{
				unlink($filepath);
			});
			
			return Response::download($filepath);
			
		}
		
		return Response::json(array('content' => $html));

	}
}
