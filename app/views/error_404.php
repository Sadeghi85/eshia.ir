<br />
	<p style="padding:10px;"><?php
		$ext = end(explode('.', end(explode('\\', $path))));
		if (in_array($ext, array('htm', 'html')))
		{
			echo 'با عرض پوزش صفحه مورد نظر یافت نشد';
		}
		else
		{
			echo 'با عرض پوزش فایل مورد نظر یافت نشد';
		}
	?></p>
<br />
