<?php

return array(

	'data_path' => 'C:\\inetpub\\eShia\\DATA';
    'data_url' => 'http://127.0.0.1:9102';

	'documents' => array(
		'DefaultM.htm',
		'DefaultM.html',
		'default.htm',
		'default.html',
		'index.htm',
		'index.html',
	);

	'view_regex' => array(
		'/ar$|/ar/.*' => array('layout' => 'default-ar', 'error_404' => 'error_404-ar'),
		'.*/(alerazi|alheidary|arzooni|bashir_najafi|fazlollah|haery2|iravani|javaheri|khouee|makaremAr|moosavi|sanad)/.*' => array('layout' => 'default-ar', 'error_404' => 'error_404-ar'),
		'.*' => array('layout' => 'default', 'error_404' => 'error_404'),
	);
	
);