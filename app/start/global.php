<?php

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

ClassLoader::addDirectories(array(

	app_path().'/commands',
	app_path().'/controllers',
	app_path().'/models',
	app_path().'/database/seeds',
	
	app_path().'/helpers',
	app_path().'/libraries',

));

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a basic log file setup which creates a single file for logs.
|
*/

Log::useFiles(storage_path().'/logs/laravel.log');

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

App::fatal(function($exception)
{
	Log::error($exception);
	
	if ( ! Config::get('app.debug'))
	{
		$message = Helpers::getExceptionErrorMessage();
		
		return (Request::ajax() ? Response::make('', 500) : Response::view('error.error', compact('message'), 500));
	}
});

App::error(function(\Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException $exception)
{
	Log::error(Route::current());
    Log::error($exception);

    Response::make('', 405);
});

App::error(function(Exception $exception, $code)
{
	Log::error($exception);
	
	if ( ! Config::get('app.debug'))
	{
		$message = Helpers::getExceptionErrorMessage();
		
		switch ($code)
		{
			case 403:
				return (Request::ajax() ? Response::make('', 403) : Response::view('error.error', compact('message'), 403));
				
			case 405:
				return (Request::ajax() ? Response::make('', 405) : Response::view('error.error', compact('message'), 405));

			case 500:
				return (Request::ajax() ? Response::make('', 500) : Response::view('error.error', compact('message'), 500));
				
			case 503:
				return (Request::ajax() ? Response::make('', 503) : Response::view('error.error', compact('message'), 503));

			default:
				
				return (Request::ajax() ? Response::make('', 404) : Response::view('error.error', compact('message'), 404));
		}
	}
});

App::missing(function($exception)
{
    $message = Helpers::getExceptionErrorMessage();
    
	return (Request::ajax() ? Response::make('', 404) : Response::view('error.error', compact('message'), 404));
});

/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenance mode is in effect for the application.
|
*/

App::down(function()
{
	//return Response::make("Be right back!", 503);
	
	$message = Helpers::getExceptionErrorMessage();
    
	return (Request::ajax() ? Response::make('', 503) : Response::view('error.error', compact('message'), 503));
});

/*
|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
*/

require app_path().'/filters.php';

/*
|--------------------------------------------------------------------------
| Blade Extends
|--------------------------------------------------------------------------
|
*/
Blade::extend(function($value)
{
	return preg_replace('/@php((.|\s)*?)@endphp/', '<?php $1 ?>', $value);
});

Blade::extend(function($value)
{
	return preg_replace_callback('/@comment((.|\s)*?)@endcomment/',
              function ($matches) {
                    return '<?php /* ' . preg_replace('/@|\{/', '\\\\$0\\\\', $matches[1]) . ' */ ?>';
              },
              $value
			);
});

// Paginator page must be positive
Input::merge(array(Paginator::getPageName() => abs(Input::get(Paginator::getPageName(), 1))));

/*
|--------------------------
| View Composers
|--------------------------
*/

View::composer(Paginator::getViewName(), function($view)
{
	$queryString = array_except(Input::query(), array(Paginator::getPageName()));
	$view->paginator->appends($queryString);
});