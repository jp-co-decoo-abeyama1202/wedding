<?php

class AdminController extends BaseController {

    public function getIndex()
    {
        return View::make('admin/index');
    }
    
    public function getInfomation()
    {
        $logins = SiteLogin::all();
        if(count($logins) !== count(Site::$_site_names)) {
            return Redirect::to('admin/create-user');
        }
        return View::make('admin/infomation',compact("logins"));
    }
    
    public function postLogin($id)
    {
        // バリデーションルール
        $rules = array(
            'login_id' => 'required',
            'password' => 'required'
        );
        
        // カスタムバリデーションメッセージ
        $messages = array(
            'login_id.required' => 'ログインIDを入力してください',
            'password.required' => 'パスワードを入力してください',
        );
        
        $validator = Validator::make(Input::all(), $rules, $messages);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }
        try {
            DB::beginTransaction();
            $login = SiteLogin::findOrFail($id);
            $login->login_id = Input::get('login_id');
            $login->password = Input::get('password');
            $login->save();
            DB::commit();
            return Redirect::to('admin/infomation')->with('success', 'ログイン情報を更新しました。');
            
        } catch (\Exception $ex) {
            \Log::error($ex->getMessage());
            DB::rollback();
            return Redirect::back()->with('error', 'ログイン情報の更新に失敗しました。');
        }
    }
    
    public function postCheckLogin($siteId)
    {
        try {
            $model = isset(Site::$_site_models[$siteId]) ? Site::$_site_models[$siteId] : null;
            if($model) {
                $name = Site::$_site_names[$siteId];
                $site = new $model();
                if($site->login()) {
                    return Response::json(array('result'=>'success','message'=>$name.'へのログインに成功しました','last_login_at'=>date('Y-m-d H:i:s',$site::getLogin()->last_login_at)));
                }
            }
            return Response::json(array('result'=>'failed','message'=>$name.'へのログインに失敗しました'));
        } catch(Exception $ex) {
            error_log($ex);
            return Response::json(array('result'=>'failed','message'=>'ログインに失敗しました'));
        }
        
    }
    
    public function getHoll()
    {
        $holl = Holl::all()->first();
        if(!$holl) {
            $holl = new Holl();
        }
        return View::make('admin/holl',compact('holl'));
    }
    
    public function postHoll()
    {
        $validator = Holl::getValidator(Input::all());
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }
        try {
            DB::beginTransaction();
            $holl = Holl::all()->first();
            if(!isset($holl->id)) {
                $holl = new Holl();
            }
            $inputs = Input::only('address','parking','address_note','tel1_1','tel1_2','tel1_3','tel1_syubetsu','tel1_tanto','tel2_1','tel2_2','tel2_3','tel2_syubetsu','tel2_tanto','inquery_time','inquery_support_name');
            $holl->fill($inputs);
            $holl->save();
            DB::commit();
            return Redirect::to('admin/holl')->with('success', '会場情報を更新しました。');
        } catch (\Exception $ex) {
            \Log::error($ex);
            DB::rollback();
            return Redirect::back()->with('error', '会場情報の更新に失敗しました。');
        }
    }
    
    public function postHollData()
    {
        $holl = Holl::select(array('address','parking','address_note','tel1_1','tel1_2','tel1_3','tel1_syubetsu','tel1_tanto','tel2_1','tel2_2','tel2_3','tel2_syubetsu','tel2_tanto','inquery_time','inquery_support_name'))->first();
        if(!$holl) {
            return Response::json(array('result'=>'failed','message'=>'会場情報が入力されていません。'));
        }
        return Response::json(array('result'=>'success','params'=>$holl->toArray()));
    }
}
