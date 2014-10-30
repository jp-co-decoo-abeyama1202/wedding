<?php

class UserController extends BaseController {

    public function getIndex()
    {
        return View::make('user/index');
    }
    
    public function getPassword()
    {
        $user = Auth::user();
        return View::make('user/password',compact('user'));
    }
    
    public function postPassword()
    {
        // バリデーションルール
        $rules = array(
            'before_password' => 'required',
            'new_password' => 'required|between:8,20',
            'confirm_password' => 'required',
        );
        
        // カスタムバリデーションメッセージ
        $messages = array(
            'before_password.required' => '現在使用中のパスワードを入力してください',
            'new_password.required' => '新しいパスワードを入力してください',
            'new_password.between' => '新しいパスワードは8～20文字で入力してください',
            'confirm_password.required' => '確認パスワードを入力してください',
        );
        
        $validator = Validator::make(Input::all(), $rules, $messages);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }
        if (!Hash::check(Input::get('before_password'),Auth::user()->password)) {
            return Redirect::back()->with('error','現在使用中のパスワードが一致しません');
        }
        if (Input::get('new_password') !== Input::get('confirm_password')) {
            return Redirect::back()->with('error','新しいパスワードと確認パスワードが一致しません');
        }
        try {
            DB::beginTransaction();
            $user = Auth::user();
            $user->password = Hash::make(Input::get('new_password'));
            $user->save();
            DB::commit();
            return Redirect::to('user/password')->with('success', 'パスワードを更新しました。');
        } catch (\Exception $ex) {
            \Log::error($ex->getMessage());
            DB::rollback();
            return Redirect::back()->with('error', 'パスワードの変更に失敗しました。');
        }
    }
}
