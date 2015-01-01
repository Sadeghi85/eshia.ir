<br />
	<p style="padding:10px;"><?php
		$ext = end(explode('.', end(explode('\\', $path))));
		if (in_array($ext, array('htm', 'html')))
		{
			echo 'عذرا، الصفحة لم يتم العثور';
		}
		else
		{
			echo 'عذرا، الملف لم يتم العثور';
		}
	?></p>
<br />
