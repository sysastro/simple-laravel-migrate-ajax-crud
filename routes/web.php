<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/news', 'NewsController@index');
Route::get('/news/data','NewsController@data');
Route::post('/news/create','NewsController@create');
Route::get('/news/get/{uuid?}','NewsController@get');
Route::get('/news/delete/{uuid?}','NewsController@delete');

