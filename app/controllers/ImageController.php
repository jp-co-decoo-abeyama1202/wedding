<?php

class ImageController extends BaseController 
{
    /**
     * TOP画面
     */
    public function getIndex()
    {
        return View::make('image/index');
    }
    
    /**
     * SC画像管理画面
     * @return type
     */
    public function getList()
    {
        $images = Image::ofSearch()->get();
        return View::make('image/list',compact('images'));
    }
    
    /**
     * 詳細画面
     * @param int $id
     */
    public function getDetail($id)
    {
        $image = Image::findOrFailed($id);
        return Veiw::make('image/detail',compact('image'));
    }
    
    /**
     * アップロード画面
     */
    public function getUpload()
    {
        return View::make('image/upload');
    }
    
    /**
     * アップロード処理
     */
    public function postUpload()
    {   
        // バリデーションルール
        $rules = $attrNames = array();
        for($i=1;$i<=10;$i++) {
            $rules['image_'.$i] = 'image';
            $attrNames['image_'.$i] = 'アップロード画像'.sprintf('%02d',$i);
        }
        $inputs['image_category_id'] = 'required:in:' . implode(',',array_keys(ImageCategory::getList()));
        $attrNames['image_category_id'] = '画像カテゴリ';
        $validator = Validator::make($inputs,$rules);
        $validator->setAttributeNames($attrNames);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }
        $image = null;
        for($i=1;$i<=10;++$i) {
            $input = Input::file('image_'.$i);
            if(!is_null($input)) {
                $params = array(
                    'mime_type' => $input->getMimeType(),
                    'image_category_id' => 0,
                    'caption' => '',
                );
                $image = Image::create($params);
                //画像の保存
                $input->move(Config::get('application.sc.img_path'),$image->getFileName());
            }
        }
        if(!$image) {
            return Redirect::back()->with('error', 'アップロードに失敗しました。');
        } else {
            return Redirect::to('image/list')->with('success','アップロードに成功しました。');
        }
    }
    
    /**
     * 編集画面
     */
    public function getEdit($id)
    {
        $image = Image::findOrFail($id);
        return View::make('image/edit',compact('image'));
    }
    
    /**
     * 編集完了処理
     */
    public function postEdit()
    {
        $image = Image::findOrFail(Input::get("id"));
        $validator = Image::getValidator(Input::all());
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }
        try {
            DB::beginTransaction();
            $inputs = Input::only('title','image_category_id','caption','zexy_photo_kbn','mynavi_photo_show_flg','mynavi_inspiration_search_flg','mynavi_category_id','upload_zexy','upload_mynavi','upload_rakuten','rakuten_genre_id');
            $tags = Input::get('mynavi_tag_id') ? Input::get('mynavi_tag_id') : array();
            $cnt = 1;
            foreach($tags as $tag) {
                if(!array_key_exists($tag,WorkMynaviImage::$imageTagList)) {
                    return Redirect::back()->withInput()->with('error','選択されたウエディングフォト診断キーワードが正しくありません。');
                }
                $inputs['mynavi_tag_id_'.$cnt] = $tag;
                $cnt++;
            }
            if(Input::hasFile('image')) {
                $inputs['mime_type'] = Input::file('image')->getMimeType();
            }
            $inputs['is_edit'] = Image::EDITED;
            $inputs['is_upload'] = Image::NOT_UPLOAD;
            $image->fill($inputs);
            $image->save();
            //画像の保存
            if(Input::hasFile('image')) {
                Input::file('image')->move(Config::get('application.sc.img_path'),$image->getFileName());
            }
            DB::commit();
            return Redirect::back()->with('success','画像情報を更新しました。');
        } catch (\Exception $ex) {
            \Log::error($ex->getMessage());
            DB::rollback();
            return Redirect::back()->with('error', '画像情報の更新に失敗しました。');
        }
    }
    
    /**
     * 画像ダウンロード画面
     */
    public function getDownload()
    {
        return View::make('image/download');
    }
    
    /**
     * 画像ダウンロード処理登録
     * @return type
     */
    public function postDownload()
    {
        $inputs = Input::only('download_zexy','download_mynavi','download_rakuten');
        // バリデーションルール
        $rules = array(
            'download_zexy' => 'in:0,1',
            'download_mynavi' => 'in:0,1',
            'download_rakuten' => 'in:0,1',
        );
        $attrNames = array(
            'download_zexy' => 'ゼクシィ',
            'download_mynavi' => 'マイナビ',
            'download_rakuten' => '楽天'
        );
        $validator = Validator::make($inputs,$rules);
        $validator->setAttributeNames($attrNames);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }
        try {
            DB::beginTransaction();
            if($inputs['download_zexy'] == Fair::FLG_ON && ImageUpload::checkZexy()) {
                Queue::push('QueueImageDownload',array('id'=>SiteZexy::SITE_LOGIN_ID));
                foreach(ImageUpload::getZexys() as $upload) {
                    $upload->state = ImageUpload::STATE_RUN;
                    $upload->save();
                }
            }
            if($inputs['download_mynavi'] == Fair::FLG_ON && ImageUpload::checkMynavi()) {
                Queue::push('QueueImageDownload',array('id'=>SiteMynavi::SITE_LOGIN_ID));
                $upload = ImageUpload::getMynavi();
                $upload->state = ImageUpload::STATE_RUN;
                $upload->save();
            }
            if($inputs['download_rakuten'] == Fair::FLG_ON && ImageUpload::checkRakuten()) {
                Queue::push('QueueImageDownload',array('id'=>SiteRakuten::SITE_LOGIN_ID));
                $upload = ImageUpload::getRakuten();
                $upload->state = ImageUpload::STATE_RUN;
                $upload->save();
            }
            DB::commit();
            return Redirect::back()->with('success','ダウンロード処理を登録しました。');
        } catch (\Exception $ex) {
            \Log::error($ex->getMessage());
            DB::rollback();
            return Redirect::back()->with('error', '画像のダウンロード処理登録に失敗しました。');
        }
    }
    
    /**
     * ダウンロード画像紐付
     * @return type
     */
    public function getLinking()
    {
        $zexyImages = WorkZexyImage::all();
        $mynaviImages = WorkMynaviImage::all();
        return View::make('image/linking',compact('zexyImages','mynaviImages'));
    }
    
    /**
     * 紐付先選択
     * @param type $siteId
     * @param type $id
     * @return type
     */
    public function getLinker($siteId,$id)
    {
        $image = $checkId = null;
        switch($siteId) {
            case SiteZexy::SITE_LOGIN_ID:
                $image = WorkZexyImage::findOrFail($id);
                $checkId = 'zexy_id';
                break;
            case SiteMynavi::SITE_LOGIN_ID:
                $image = WorkMynaviImage::findOrFail($id);
                $checkId = 'mynavi_id';
                break;
            case SiteRakuten::SITE_LOGIN_ID:
                $image = WorkRakutenImage::findOrFail($id);
                $checkId = 'rakuten_id';
                break;
        }
        if(!$image) {
            return Redirect::to('/');
        }
        $images = Image::ofSearch()->get();
        return View::make('image/linker',compact('image','images','siteId','checkId','search'));
    }
    
    /**
     * 画像の紐付処理
     * @return type
     */
    public function postLinked()
    {
        $inputs = Input::only('image_id','work_image_id','site_id');
        $rules = array(
            'image_id' => 'required|numeric',
            'work_image_id' => 'required|numeric',
            'site_id' => 'required|in:'.implode(',',array(SiteZexy::SITE_LOGIN_ID,SiteMynavi::SITE_LOGIN_ID,SiteRakuten::SITE_LOGIN_ID)),
        );
        $validator = Validator::make($inputs,$rules);
        if ($validator->fails()) {
            return Redirect::back()->with('error','画像の紐付に失敗しました');
        }
        try {
            $image = Image::findOrFail(Input::get('image_id'));
            if($image->fairs()->whereState(Fair::STATE_UPLOAD_NOW)->count()) {
                return Redirect::back()->with('error','選択された画像は出稿中のフェアに使われています');
            }
            $class = $work = $checkId = null;
            $addParams = array();
            $siteId = Input::get('site_id');
            $workId = Input::get('work_image_id');
            switch($siteId) {
                case SiteZexy::SITE_LOGIN_ID:
                    $work = WorkZexyImage::findOrFail($workId);
                    $class = new WorkZexyImage();
                    $checkId = 'zexy_id';
                    $addParams = array(
                        'title' => array('photo_title',false),
                        'caption' => array('photo_caption',false),
                        'zexy_photo_kbn' => array('photo_kbn',true),
                    );
                    break;
                case SiteMynavi::SITE_LOGIN_ID:
                    $work = WorkMynaviImage::findOrFail($workId);
                    $class = new WorkMynaviImage();
                    $checkId = 'mynavi_id';
                    $addParams = array(
                        'title' => array('name',false),
                        'caption' => array('title',false),
                        'mynavi_photo_show_flg' => array('photo_show_flg',true),
                        'mynavi_inspiration_search_flg' => array('inspiration_search_flg',true),
                        'mynavi_category_id' => array('image_category_id',true),
                        'mynavi_tag_id_1' => array('tag_id_1',true),
                        'mynavi_tag_id_2' => array('tag_id_2',true),
                        'mynavi_tag_id_3' => array('tag_id_3',true),
                    );
                    break;
                case SiteRakuten::SITE_LOGIN_ID:
                    $work = WorkRakutenImage::findOrFail($workId);
                    $class = new WorkRakutenImage();
                    $checkId = 'rakuten_id';
                    break;
            }
            if(!$work) {
                return Redirect::back()->with('error','画像の紐付に失敗しました');
            }
            DB::beginTransaction();
            $message = '画像の紐付が完了しました';
            if($work->image_id) {
                //既に紐付されている画像がある場合。
                if($work->image_id == $image->id) {
                    //同じ画像への再紐付は解除扱い
                    $work->image_id = null;
                    $work->save();
                    $image->$checkId = null;
                    foreach($addParams as $key => $params) {
                        if($params[1]) {
                            $image->$key = null;
                        }
                    }
                    $image->save();
                    $message = '画像の紐付を解除しました';
                    DB::commit();
                    return Redirect::to('image/linker/'.$siteId.'/'.$work->id)->with('success',$message);
                } else {
                    //現在紐付されている画像から紐付解除
                    $before = Image::findOrFail($work->image_id);
                    $before->$checkId = null;
                    foreach($addParams as $key => $params) {
                        if($params[1]) {
                            $before->$key = null;
                        }
                    }
                    $before->save();
                }
            }
            $work->image_id = $image->id;
            $work->save();
            if($image->$checkId) {
                //既にWork画像が紐付済み
                $before = null;
                switch($siteId) {
                    case SiteZexy::SITE_LOGIN_ID:
                        $before = WorkZexyImage::find($image->$checkId);
                        break;
                    case SiteMynavi::SITE_LOGIN_ID:
                        $before = WorkMynaviImage::find($image->$checkId);
                        break;
                    case SiteRakuten::SITE_LOGIN_ID:
                        $before = WorkRakutenImage::find($image->$checkId);
                        break;
                }
                if($before) {
                    //現在のWork画像の紐付解除
                    $before->image_id = null;
                    $before->save();
                }
            }
            $image->$checkId = $work->id;
            foreach($addParams as $key => $params) {
                if($params[1]) {
                    // 上書き
                    error_log($params[0]);
                    $image->$key = $work->$params[0];
                } else {
                    // 既存優先
                    $image->$key = $image->$key ? $image->$key : $work->$params[0];
                }
            }
            $image->save();
            DB::commit();
            return Redirect::to('image/linker/'.$siteId.'/'.$work->id)->with('success',$message);
        } catch (Exception $ex) {
            \Log::error($ex->getMessage());
            DB::rollback();
            return Redirect::back()->with('error', '画像の紐付に失敗しました。');
        }
    }
    
    public function postChangeState()
    {
        try {
            $image = Image::findOrFail(Input::get('id'));
            if($image->state === Image::STATE_INVALID) {
                $image->state = Image::STATE_VALID;
            } else {
                $image->state = Image::STATE_INVALID;
            }
            DB::beginTransaction();
            $image->save();
            DB::commit();
            return Response::json(array('result'=>'success','state'=>$image->state,'is_edit'=>$image->is_edit,'is_upload'=>$image->is_upload));
        } catch (Exception $ex) {
            DB::rollback();
            return Response::json(array('result'=>'failed','message'=>'状態変更処理に失敗しました'));
        }
    }
    
    public function postChangeUpload()
    {
        try {
            $image = Image::findOrFail(Input::get('id'));
            if($image->is_upload == Image::UPLOAD_REGIST) {
                return Response::json(array('result'=>'failed','message'=>'既に同期登録済みです'));
            }
            $check = false;
            if($image->upload_zexy == Image::UPLOADED) {
                $check = true;
                $image->upload_zexy = Image::UPLOAD_REGIST;
            }
            if($image->upload_mynavi == Image::UPLOADED) {
                $check = true;
                $image->upload_mynavi = Image::UPLOAD_REGIST;
            }
            if($image->upload_rakuten == Image::UPLOADED) {
                $check = true;
                $image->upload_rakuten = Image::UPLOAD_REGIST;
            }
            if(!$check) {
                return Response::json(array('result'=>'failed','message'=>'同期を行うサイトが設定されていません'));
            }
            DB::beginTransaction();
            $image->is_upload = Image::UPLOAD_REGIST;
            $image->save();
            DB::commit();
            return Response::json(array('result'=>'success','state'=>$image->state,'is_edit'=>$image->is_edit,'is_upload'=>$image->is_upload));
        } catch (Exception $ex) {
            DB::rollback();
            return Response::json(array('result'=>'failed','message'=>'同期登録処理に失敗しました'));
        }
    }
    
    public function getCategory()
    {
        $categorys = ImageCategory::all();
        return View::make('image/category',compact('categorys'));
    }
    
    public function postCategory()
    {
        $id = Input::get('id');
        $inputs = Input::only('name');
        $rules = array(
            'name' => 'required|mb_max:100',
        );
        $attrNames = array(
            'name' => 'カテゴリ名',
        );
        $validation = Validator::make($inputs,$rules);
        $validation->setAttributeNames($attrNames);
        try {
            $query = ImageCategory::whereName($inputs['name']);
            if($id) {
                $query = $query->where('id','<>',$id);
            }
            if($query->count()) {
                return Redirect::back()->with('error', '同じ画像カテゴリ名が存在します');
            }
            DB::beginTransaction();
            if($id) {
                $category = ImageCategory::findOrFail($id);
                $category->fill($inputs);
                $category->save();
            } else {
                ImageCategory::create($inputs);
            }
            DB::commit();
            return Redirect::back()->with('success','画像カテゴリを編集しました');
        } catch (Exception $ex) {
            \Log::error($ex);
            DB::rollback();
            return Redirect::back()->with('error', '画像カテゴリの編集に失敗しました');
        }
    }
    
    public function postCategoryDelete($id)
    {
        try {
            DB::beginTransaction();
            $category = ImageCategory::findOrFail($id);
            $category->delete();
            DB::commit();
            return Response::json(array('result'=>'success','message'=>'画像カテゴリの削除に成功しました'));
        } catch (Exception $ex) {
            \Log::error($ex);
            DB::rollback();
            return Response::json(array('result'=>'failed','message'=>'画像カテゴリの削除に失敗しました'));
        }
    }
}
