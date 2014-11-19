<?php
Route::get('test/mynavi/image',function(){
    $site = new SiteMynavi();
    $site->uploadImage(1);
});
//TOP
Route::get('/', function(){
    if(!Auth::check()) {
        return Redirect::to('/login');
    }
    return View::make('index');
});
//ログイン
Route::get('/login', function(){
    if(Auth::check()) {
        return Redirect::to('/');
    } else {
        return View::make('login');
    }
});
Route::post('/login', array('before' => 'csrf', function(){
    $inputs = Input::only(array('email', 'password'));
    if ( Auth::attempt($inputs) ) {
        return Redirect::to('/');
    } else {
        return Redirect::back()
                ->withErrors(array('warning'=>'メールアドレスかパスワードが違います。'))
                ->withInput();
    }
}));
Route::get('/logout',function(){
    Auth::logout();
    return Redirect::to('/login');
});
/*
Route::get('/create-fair',function(){
    $fair = new FairGnavi();
    $fair->fair_name = 'テストフェア';
    $fair->start_h = 0;
    $fair->start_m = 0;
    $fair->end_h = 12;
    $fair->end_m = 30;
    $fair->description = 'テストフェアの説明文です';
    $fair->target = 'テストフェアの対象です';
    $fair->other_description = 'その他の説明です';
    $fair->image_description = '画像説明です';
    $fair->post_start = 0;
    $fair->post_end = 0;
    $fair->reserve = 1;
    $fair->reserve_description = '予約の補足説明です';
    $fair->holl_id = 1;
    $fair->address = '会場所在地';
    $fair->parking = '駐車場';
    $fair->tel1_1 = '000';
    $fair->tel1_2 = '0000';
    $fair->tel1_3 = '0000';
    $fair->tel1_syubetsu = 1;
    $fair->support_name = '会場担当窓口名';
    $fair->inquery_time = '問合せ受付時間';
    $fair->inquery_support_name = '問合せ担当者名';
    $fair->created_id = Auth::user()->id;
    $fair->updated_id = Auth::user()->id;
    $fair->save();
});
Route::get('/create-fairs',function(){
    $fair = Fair::findOrFail(1);
    $fairDate = new FairDate();
    $fairDate->fair_id = $fair->id;
    $fairDate->fair_date = date('Y-m-d');
    $fairDate->save();
});
*/
//フェア関係
Route::group(array('prefix' => 'fair'), function() {
   Route::get('/', array('uses' => 'FairController@getIndex'));
   Route::get('detail/{id}',array('uses' => 'FairController@getDetail'))->where('id','\d+');
   Route::get('new',array('uses'=>'FairController@getNew'));
   Route::get('edit/{id}',array('uses' => 'FairController@getEdit'))->where('id','\d+');
   Route::post('confirm',array('uses' => 'FairController@postConfirm'));
   Route::post('complete',array('uses' => 'FairController@postComplete'));
   Route::get('content/{id}',array('uses' => 'FairController@getContent'))->where('id','\d+');
   Route::get('list',array('uses'=>'FairController@getList'));
   //入力ページでのAPIっぽいやつら
   Route::post('page/validation/{page}',array('uses' => 'FairController@postPageValidation'))->where('page','\d+');
   Route::post('page/gnavi/freeword',array('uses' => 'FairController@postPageGnaviFreeword'));
   Route::post('page/last',array('uses' => 'FairController@postPageLast'));
});
//管理関係
Route::group(array('prefix' => 'admin'), function() {
   Route::get('/', array('uses' => 'AdminController@getIndex'));
   Route::get('infomation',array('uses' => 'AdminController@getInfomation'));   
   Route::post('update/login/{id}',array('uses' => 'AdminController@postLogin'))->where('id','\d+');
   Route::post('check/login/{id}',array('uses'=>'AdminController@postCheckLogin'))->where('id','\d+');
   Route::get('holl',array('uses'=>'AdminController@getHoll'));
   Route::post('holl',array('uses'=>'AdminController@postHoll'));
   Route::post('data/holl',array('uses'=>'AdminController@postHollData'));
});
//ログインユーザ関係
Route::group(array('prefix'=>'user'),function(){
    Route::get('/', array('uses' => 'UserController@getIndex'));
    Route::get('password', array('uses' => 'UserController@getPassword'));
    Route::post('password', array('uses' => 'UserController@postPassword'));
    Route::get('new',array('uses'=>'UserController@getNew'));
    Route::get('edit/{id}',array('uses'=>'UserController@getEdit'))->where('id','\d+');
    Route::post('edit',array('uses'=>'UserController@postEdit'));
    Route::get('list',array('uses'=>'UserController@getList'));
    Route::post('delete',array('uses'=>'UserController@postDelete'));
});

//画像関係
Route::group(array('prefix' => 'image'), function() {
    Route::get('/', array('uses' => 'ImageController@getIndex'));
    Route::get('list', array('uses' => 'ImageController@getList'));
    Route::post('list', array('uses' => 'ImageController@getList'));
    Route::get('detail/{id}', array('uses' => 'ImageController@getDetail'))->where('id','\d+');
    Route::get('upload', array('uses' => 'ImageController@getUpload'));
    Route::post('upload',array('uses' => 'ImageController@postUpload'));
    Route::get('edit/{id}',array('uses' => 'ImageController@getEdit'))->where('id','\d+');
    Route::post('edit',array('uses' => 'ImageController@postEdit'));
    Route::get('download',array('uses'=>'ImageController@getDownload'));
    Route::post('download',array('uses'=>'ImageController@postDownload'));
    //紐付
    Route::get('linking',array('uses'=>'ImageController@getLinking'));
    Route::get('linker/{site_id}/{id}',array('uses'=>'ImageController@getLinker'))->where('site_id','\d+')->where('id','\d+');
    Route::post('linker/{site_id}/{id}',array('uses'=>'ImageController@getLinker'))->where('site_id','\d+')->where('id','\d+');
    Route::post('linked',array('uses'=>'ImageController@postLinked'));
    //状態変更
    Route::post('change/state',array('uses' => 'ImageController@postChangeState'));
    Route::post('change/upload',array('uses' => 'ImageController@postChangeUpload'));
    //カテゴリ
    Route::get('category',array('uses'=>'ImageController@getCategory'));
    Route::post('category',array('uses'=>'ImageController@postCategory'));
    Route::post('category/delete/{id}',array('uses'=>'ImageController@postCategoryDelete'))->where('id','\d+');
    //モーダル
    Route::post('modal',function(){return View::make('image/_modal_body');});
});
//特典関係
Route::group(array('prefix'=>'special'),function(){
    Route::get('/', array('uses'=>'SpecialController@getIndex'));
    Route::get('list', array('uses'=>'SpecialController@getList'));
    Route::post('list', array('users'=>'SpecialController@postList'));
    Route::get('download', array('uses'=>'SpecialController@getDownload'));
    Route::post('download', array('uses'=>'SpecialController@postDownload'));
});
//Route::controller('fair', 'FairController');