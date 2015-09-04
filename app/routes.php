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

//Route::get('search/{teacher}/{course}/{year}', 'SearchController@index');

Route::pattern('feqh', '(?i)feqh(?-i)');
Route::pattern('archive', '(?i)archive(?-i)');
Route::pattern('convert', '(?i)convert(?-i)');

Route::get('/{feqh}/{archive}/word', 'ConvertController@word');

Route::get('/{feqh}/{archive}/{convert}/{teacher}/{course}/{year}', 'ConvertController@index');
Route::get('/{feqh}/{archive}/{convert}/{ar}', 'ConvertController@index');
Route::get('/{feqh}/{archive}/{convert}/{fa}', 'ConvertController@index');
Route::post('/{feqh}/{archive}/{convert}/{teacher?}/{course?}/{year?}', array('as' => 'convert', 'uses' => 'ConvertController@convert'));

Route::get('{path}', 'SiteController@index')->where('path', '.*');