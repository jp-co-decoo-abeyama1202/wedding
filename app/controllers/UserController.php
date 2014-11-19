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
    
    public function getNew()    
    {
        $administrator = new Administrator();
        return View::make('user/edit',compact('administrator'));
    }
    
    public function postEdit()
    {
        $id = Input::get('id');
        $changePassword = Input::get('change_password') == Fair::FLG_ON;
        if($changePassword) {
            $inputs = Input::only('email','password','confirm','nickname','role');
        } else {
            if($id) {
                $inputs = Input::only('email','nickname','role');
            } else {
                return Redirect::back()->with('error', 'ログインユーザの追加に失敗しました。');
            }
        }
        $validator = Administrator::getValidator($inputs,$changePassword);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }
        try {
            //既に同じEmailで登録されていないか
            $query = Administrator::whereEmail($inputs['email']);
            if($id) {
                $query = $query->where('id','<>',$id);
            }
            if($query->count()) {
                return Redirect::back()->withInput()->with('error','登録済みのメールアドレスです');
            }
            //確認用パスワードと一致しているか
            if($changePassword && $inputs['password'] !== $inputs['confirm']) {
                return Redirect::back()->withInput()->with('error','パスワードが一致しません');
            }
            //登録・更新
            $params = Input::only('email','nickname','role');
            if($changePassword) {
                $params['password'] = Hash::make(Input::get('password'));
            }
            DB::beginTransaction();
            if($id) {
                $administrator = Administrator::withTrashed()->whereId($id)->first();
                if(!$administrator) {
                    DB::rollback();
                    return Redirect::back()->with('error', '指定されたログインユーザの取得に失敗しました。');
                }
                $administrator->fill($params);
                $administrator->save();
                $message = 'ログインユーザの情報を修正しました';
            } else {
                Administrator::create($params);
                $message = 'ログインユーザを新規登録しました';
            }
            DB::commit();
            return Redirect::to('user/list')->with('success',$message);
        } catch (\Exception $ex) {
            \Log::error($ex);
            DB::rollback();
            $method = $id ? '追加' : '登録';
            return Redirect::back()->with('error', 'ログインユーザの'.$method.'に失敗しました。');
        }
    }
    
    public function getEdit($id)
    {
        $administrator = Administrator::withTrashed()->whereId($id)->first();
        if(!$administrator) {
            return Redirect::back()->with('error', '指定されたログインユーザの取得に失敗しました。');
        }
        return View::make('user/edit',compact('administrator'));
    }
    
    public function getList()
    {
        $users = Administrator::withTrashed()->get();
        return View::make('user/list',compact('users'));
    }
    
    public function postDelete()
    {
        try {
            $user = Administrator::findOrFail(Input::get('id'));
            if($user->deleted_at) {
                return Response::json(array('result'=>'failed','message'=>'既に削除されているユーザです'));
            }
            DB::beginTransaction();
            $user->delete();
            DB::commit();
            return Response::json(array('result'=>'success','deleted_at'=>$user->deleted_at));
        } catch (Exception $ex) {
            \Log::error($ex->getMessage());
            DB::rollback();
            return Response::json(array('result'=>'failed','message'=>'ログインユーザの削除に失敗しました'));
        }
    }
}
