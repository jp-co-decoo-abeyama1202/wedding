<?php
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
});
//管理関係
Route::group(array('prefix' => 'admin'), function() {
   Route::get('/', array('uses' => 'AdminController@getIndex'));
   Route::get('infomation',array('uses' => 'AdminController@getInfomation'));   
   Route::post('update/login/{id}',array('uses' => 'AdminController@postLogin'))->where('id','\d+');
   Route::get('create-user',function(){
        foreach(Site::$_site_names as $id => $name) {
            $login = SiteLogin::find($id);
            if(!$login) {
                $login = new SiteLogin();
                $login->id = $id;
                $login->login_id = '';
                $login->password = '';
                $login->update_password = '';
                $login->save();
            }
        }
        return Redirect::back();
   });
   Route::get('holl',array('uses'=>'AdminController@getHoll'));
   Route::post('holl',array('uses'=>'AdminController@postHoll'));
});
//ログインユーザ関係
Route::group(array('prefix'=>'user'),function(){
    Route::get('/', array('uses' => 'UserController@getIndex'));
    Route::get('password', array('uses' => 'UserController@getPassword'));
    Route::post('password', array('uses' => 'UserController@postPassword'));
});
//画像関係
Route::group(array('prefix' => 'image'), function() {
    Route::get('/', array('uses' => 'ImageController@getIndex'));
    Route::get('detail/{id}', array('uses' => 'ImageController@getDetail'))->where('id','\d+');
    Route::get('upload', array('uses' => 'ImageController@getUpload'));
    Route::post('upload',array('uses' => 'ImageController@postUplaod'));
    Route::get('edit/{id}',array('uses' => 'ImageController@postEdit'))->where('id','\d+');
    Route::post('confirm',array('uses' => 'ImageController@postConfirm'));
    Route::post('complete',array('uses' => 'ImageController@postComplete'));
});
Route::group(array('prefix'=>'special'),function(){
    Route::get('/', array('uses'=>'SpecialController@getIndex'));
});
//Route::controller('fair', 'FairController');