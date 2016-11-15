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

/*

Route::get('/', function () {
    return view('welcome');
});

 */

Route::get('/', [ 'uses' => 'HomeController@index', 'as' => 'home', ]);

Route::get('/ajax/rate', [ 'uses' => 'AjaxController@rate', 'as' => 'ajax.rate', ]);

