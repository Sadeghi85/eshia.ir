<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	if (stripos(Request::header('referer'), 'old.eshia.ir') !== false)
	{
		return Redirect::to(sprintf('http://old.eshia.ir/%s', Request::path()));
	}
});

App::before(function($request)
{
	$viewRegex = Config::get('app_settings.view_regex');
	
	foreach ($viewRegex as $regex => $settings)
	{
		if (preg_match(sprintf('#%s#iu', $regex), Request::url()))
		{
			switch ($settings['locale'])
			{
				case 'ar':
					App::setLocale('ar');
					Config::set('app.locale', 'ar');
					//Config::set('app_settings.settings', $settings);
				break 2;
				case 'en':
					App::setLocale('en');
					Config::set('app.locale', 'en');
					//Config::set('app_settings.settings', $settings);
				break 2;
				default:
					App::setLocale('fa');
					Config::set('app.locale', 'fa');
					//Config::set('app_settings.settings', $settings);
			}
		}
	}
	
});

App::after(function($request, $response)
{
    if(App::Environment() != 'local')
    {
        if($response instanceof Illuminate\Http\Response)
        {
            $output = $response->getOriginalContent();
            
			$output = str_replace("\r\n", '<crlf>', $output);
			$output = preg_replace('#[[:space:]]+#u', ' ', $output);
			$output = str_replace('<crlf>', "\r\n", $output);
			$output = preg_replace('#[\r\n]+\s*[\r\n]*#u', "\r\n", $output);
			
            $response->setContent($output);
        }
    }
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('login');
		}
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() !== Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});
