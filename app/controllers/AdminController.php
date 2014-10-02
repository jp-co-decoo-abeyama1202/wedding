<?php

class AdminController extends BaseController {

    public function getIndex()
    {
        return View::make('admin/_index');
    }
    
    public function getInfomation()
    {
        $logins = SiteLogin::all();
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
}
