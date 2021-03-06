<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::pattern('ar', '(?i)ar(?-i)');
Route::pattern('feqh', '(?i)feqh(?-i)');
Route::pattern('archive', '(?i)archive(?-i)');
Route::pattern('convert', '(?i)convert(?-i)');
Route::pattern('text', '(?i)text(?-i)');

// search2
Route::get('/search2', array('uses' => 'Search2Controller@showPage'));

// Player
Route::get('/player/{req}', array('uses' => 'PlayerController@showPage'))
->where('req', '.+');

// Monitoring
Route::get('/{ar}/{feqh}/monitoring', array('uses' => 'SiteController@showMonitoring'));
Route::get('/{feqh}/monitoring', array('uses' => 'SiteController@showMonitoring'));

// Search
Route::get('/{ar}/search/{teacher}/{lesson}/{year}/{query}', array('uses' => 'SearchController@showPage'))
->where('year', '\d{2}')->where('date', '\d{3}|\d{6}')->where('query', '.+');
Route::get('/search/{teacher}/{lesson}/{year}/{query}', array('uses' => 'SearchController@showPage'))
->where('year', '\d{2}')->where('date', '\d{3}|\d{6}')->where('query', '.+');

Route::get('/{ar}/search/{query}', array('uses' => 'SearchController@showPage'))
->where('query', '.+');
Route::get('/search/{query}', array('uses' => 'SearchController@showPage'))
->where('query', '.+');

// Advanced Search
Route::get('/advanced-search', array('uses' => 'SearchController@showAdvancedPage'));
Route::get('/{ar}/advanced-search', array('uses' => 'SearchController@showAdvancedPage'));

Route::post('/advanced-search', array('uses' => 'SearchController@processAdvancedPage'));
Route::post('/{ar}/advanced-search', array('uses' => 'SearchController@processAdvancedPage'));


// Ajax
Route::get('/search-data', array('uses' => 'SearchController@getSearchData'));
Route::get('/{ar}/search-data', array('uses' => 'SearchController@getSearchData'));


// Converter

Route::get('/{feqh}/{archive}/word', 'ConvertController@word');

Route::get('/{feqh}/{archive}/{convert}/{teacher}/{lesson}/{year}', 'ConvertController@index');
Route::get('/{feqh}/{archive}/{convert}/{ar}', 'ConvertController@index');
Route::get('/{feqh}/{archive}/{convert}/{fa}', 'ConvertController@index');
Route::post('/{feqh}/{archive}/{convert}/{teacher?}/{lesson?}/{year?}', array('as' => 'convert', 'uses' => 'ConvertController@convert'));
Route::post('/feqh/archive/convert2zip/{teacher?}/{lesson?}/{year?}', array('uses' => 'ConvertController@convert2zip'));

// Catch all

Route::get('/{feqh}/{archive}/{text}/{teacher}/{lesson}/{year}/{date}/{hilight?}', 'SiteController@index')
->where('year', '\d{2}')->where('date', '\d{3}|\d{6}')->where('hilight', '.*');

Route::get('{path}', 'SiteController@index')->where('path', '.*');
