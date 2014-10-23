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

//フェア関係
Route::group(array('prefix' => 'fair'), function() {
   Route::get('/', array('uses' => 'FairController@getIndex'));
   Route::get('detail/{id}',array('uses' => 'FairController@getDetail'))->where('id','\d+');
   Route::get('new',array('uses'=>'FairController@getNew'));
   Route::post('edit',array('uses' => 'FairController@postEdit'));
   Route::post('confirm',array('uses' => 'FairController@postConfirm'));
   Route::post('complete',array('uses' => 'FairController@postComplete'));
});
//管理関係
Route::group(array('prefix' => 'admin'), function() {
   Route::get('/', array('uses' => 'AdminController@getIndex'));
   Route::get('infomation',array('uses' => 'AdminController@getInfomation'));   
   Route::post('update/login/{id}',array('uses' => 'AdminController@postLogin'))->where('id','\d+');
});
//画像関係
Route::group(array('prefix' => 'image'), function() {
    Route::get('/', array('uses' => 'ImageController@getIndex'));
    Route::get('detail/{id}', array('uses' => 'ImageController@getDetail'))->where('id','\d+');
    Route::get('upload', array('uses' => 'ImageController@getUpload'));
    Route::post('upload',array('uses' => 'ImageController@postUplaod'));
    Route::post('edit',array('uses' => 'ImageController@postEdit'));
    Route::post('confirm',array('uses' => 'ImageController@postConfirm'));
    Route::post('complete',array('uses' => 'ImageController@postComplete'));
});

Route::controller('/', 'BaseController');
Route::get('login/{id}','BaseController@getLogin')->where('id','\d+');
Route::get('fair/{id}','BaseController@getFair')->where('id','\d+');
Route::get('detail/{id}','BaseController@getDetail')->where('id','\d+');
Route::get('add/{id}','BaseController@getAdd')->where('id','\d+');
Route::get('update/{id}','BaseController@getUpdate')->where('id','\d+');
Route::get('stop/{id}','BaseController@getStop')->where('id','\d+');
Route::get('delete/{id}','BaseController@getDelete')->where('id','\d+');
Route::get('tokutenget','BaseController@getTokuten');
Route::get('tokutenupdate',array('uses' => 'BaseController@getUpdateTokuten'));
//Route::controller('fair', 'FairController');