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
		$date = $year;
		// if (strlen($year) == 6) {
			// $date = sprintf('%s/%s/%s', $year[0].$year[1], $year[2].$year[3], $year[4].$year[5]);
		// }

		$this->layout->content = View::make('convert', compact('feqh', 'archive', 'convert', 'teacher', 'course', 'year', 'date'));

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
		{
			//return Response::json(array('content' => $e->getMessage()));
			App::abort(404);
		}
		
		$content = $converter->getHtml();
		
		foreach (Config::get('eshia') as $color => $class)
		{
			$content = preg_replace(sprintf('#<span class="%s#i', preg_quote(strtolower($color))), '<span class="'.$class, $content);
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

		$html_no_style = <<<EOT
<div class="text-page">
<div class="course-header">
{$header}
</div>
<div class="course-content">
{$content}
</div>
</div>
EOT;

		$html_subject = '';
		$html_subject_pattern = sprintf('#^.+?<span +class *= *["\']? *Titr *["\']?>%s</span>([^<]+).+$#isu', base64_decode('2YXZiNi22YjYuQ=='));
		if (preg_match($html_subject_pattern, $html_no_style)) {
			$html_subject = preg_replace($html_subject_pattern, '$1', $html_no_style);
			$html_subject = trim(trim($html_subject, ':'));
		}
		
		if ( ! is_null(Input::get('download_style')))
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
		else if ( ! is_null(Input::get('download_html')))
		{
			$filename = trim(preg_replace('/[^\x20-\x7e]*/', '', str_replace('.'.$doc->getClientOriginalExtension(), '', $doc->getClientOriginalName())));
			$filename = $filename ? $filename : md5(microtime(true));
			
			$filepath = storage_path().'/cache/'.$filename.'.zip';
			$zip = new \ZipArchive();
			$res = $zip->open($filepath, ZipArchive::CREATE);
			
			if (version_compare(PHP_VERSION, '5.4.0') < 0)
			{
				$zip->addEmptyDir($filename);
			}
			
			$zip->addFromString($filename.'/Subject.txt', $html_subject);
			$zip->addFromString($filename.'/Default.htm', $html_no_style);
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
