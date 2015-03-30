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

Route::get('search/{teacher}/{course}/{year}', 'SearchController@index');


Route::get('convert/{teacher}/{course}', 'ConvertController@index');
Route::post('convert/{teacher}/{course}', array('as' => 'convert', 'uses' => 'ConvertController@convert'));

Route::get('{path}', 'SiteController@index')->where('path', '.*');