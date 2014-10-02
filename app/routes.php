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


Route::group(array('prefix' => 'admin'), function() {
   Route::get('/', array('uses' => 'AdminController@getIndex'));
   Route::get('infomation',array('uses' => 'AdminController@getInfomation'));
   
   Route::post('update/login/{id}',array('uses' => 'AdminController@postLogin'))->where('id','\d+');
});

Route::controller('/', 'BaseController');
Route::get('login/{id}','BaseController@getLogin')->where('id','\d+');
Route::get('fair/{id}','BaseController@getFair')->where('id','\d+');
Route::get('detail/{id}','BaseController@getDetail')->where('id','\d+');
Route::get('add/{id}','BaseController@getAdd')->where('id','\d+');
Route::get('update/{id}','BaseController@getUpdate')->where('id','\d+');
Route::get('stop/{id}','BaseController@getStop')->where('id','\d+');
Route::get('delete/{id}','BaseController@getDelete')->where('id','\d+');
//Route::controller('fair', 'FairController');