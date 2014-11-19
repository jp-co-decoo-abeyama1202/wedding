<?php
/**
 * 画像情報クラス
 * @author admin-97
 */
class Image extends Eloquent 
{
    protected $softDelete = true;
    
    const STATE_VALID = 1;
    const STATE_INVALID = 0;
    
    public static $stateList = array(
        self::STATE_VALID => '有効',
        self::STATE_INVALID => '無効',
    );
    
    const EDITED = 1;
    const NOT_EDIT = 0;
    public static $isEditList = array(
        self::EDITED => '編集済み',
        self::NOT_EDIT => '未編集',
    );
    
    const UPLOAD_REGIST = 2;
    const UPLOADED = 1;
    const NOT_UPLOAD = 0;
    public static $isUploadList = array(
        self::UPLOADED => '同期済み',
        self::NOT_UPLOAD => '未同期',
        self::UPLOAD_REGIST => '同期登録中',
    );
    
    public static $isUploadBadge = array(
        self::UPLOADED => '同期する',
        self::NOT_UPLOAD => '同期しない',
        self::UPLOAD_REGIST => '同期する',
    );
    
    public static $attrNames = array(
        'image' => '画像',
        'title' => '管理名',
        'caption' => 'キャプション',
        'image_category_id' => '画像カテゴリ',
        'zexy_photo_kbn' => 'ゼクシィ：フォト区分',
        'mynavi_photo_show_flg' => 'マイナビ：フォトギャラリー表示',
        'mynavi_inspiration_search_flg' => 'マイナビ：ウェディングフォト診断',
        'mynavi_category_id' => 'マイナビ：カテゴリ',
        'mynavi_tag_id' => 'マイナビ：ウェディングフォト診断キーワード',
        'upload_zexy' => 'ゼクシィ：同期する/しない',
        'upload_mynavi' => 'マイナビ：同期する/しない',
        'upload_rakuten' => '楽天：同期する/しない',
        'rakuten_genre_id' => '楽天：ジャンル',
    );
    
    /**
     * createメソッド実行時に、入力を禁止するカラムの指定
     *
     * @var array
     */
     protected $guarded = array('id');

    
    public function getFileName()
    {
        $extension = '.jpg';
        switch($this->mime_type) {
            case 'image/jpeg':
                $extension = '.jpg';
                break;
            case 'image/png':
                $extension = '.png';
                break;
            case 'image/gif':
                $extension = '.gif';
                break;
        }
        return $this->id . $extension;
    }
    
    public function getFilePath($short=false)
    {
        $path = $short ? Config::get('application.sc.img_short_path') : Config::get('application.sc.img_path');
        $path.= substr($path,-1) === DIRECTORY_SEPARATOR ? '' : DIRECTORY_SEPARATOR;
        $path.= $this->getFileName();
        return $path;
    }
    
    public static function getValidator($inputs)
    {
        $rules = array(
            'title' => 'mb_max:30',
            'caption' => 'required|mb_max:14',
            'image_category_id' => 'numeric',
            'zexy_photo_kbn' => 'in:'.implode(',',array_keys(WorkZexyImage::$photoCategoryCdList)),
            'mynavi_photo_show_flg' => 'in:0,1',
            'mynavi_inspiration_search_flg' => 'in:0,1',
            'mynavi_category_id' => 'in:'.implode(',',array_keys(WorkMynaviImage::$imageCategoryList)),
            'upload_zexy' => 'required|in:'.implode(',',array(self::UPLOADED,self::NOT_UPLOAD)),
            'upload_mynavi' => 'required|in:'.implode(',',array(self::UPLOADED,self::NOT_UPLOAD)),
            'upload_rakuten' => 'required|in:'.implode(',',array(self::UPLOADED,self::NOT_UPLOAD)),
            'rakuten_genre_id' => 'in:'.implode(',',array_keys(WorkRakutenImage::$genreList)),
        );
        if(Input::hasFile('image')) {
            $rules['image'] = 'image';
        }
        $validation = Validator::make($inputs,$rules);
        $validation->setAttributeNames(self::$attrNames);
        return $validation;
    }
    
    public function scopeOfSearch($query,$inputs=array())
    {
        $inputs = $inputs + Input::only('search_image_category_id','search_created_from_year','search_created_from_month','search_created_from_day','search_created_to_year','search_created_to_month','search_created_to_day','search_state','search_is_edit');
        if($inputs['search_image_category_id']) {
            $query = $query->whereImageCategoryId($inputs['search_image_category_id']);
        }
        if($inputs['search_created_from_year'] && $inputs['search_created_from_month'] && $inputs['search_created_from_day']) {
            $time = date('Y-m-d H:i:s',strtotime($inputs['search_created_from_year']."-".$inputs['search_created_from_month']."-".$inputs['search_created_from_day'].' 00:00:00'));
            $query = $query->where('created_at','>=',$time);
        }
        if($inputs['search_created_to_year'] && $inputs['search_created_to_month'] && $inputs['search_created_to_day']) {
            $time = date('Y-m-d H:i:s',strtotime($inputs['search_created_to_year']."-".$inputs['search_created_to_month']."-".$inputs['search_created_to_day'].' 23:59:59'));
            $query = $query->where('created_at','<=',$time);
        }
        if($inputs['search_state'] && is_array($inputs['search_state'])) {
            $query = $query->whereIn('state',$inputs['search_state']);
        }
        if($inputs['search_is_edit'] && is_array($inputs['search_is_edit'])) {
            $query = $query->whereIn('is_edit',$inputs['search_is_edit']);
        }
        return $query;
    }
    
    public function scopeOfModal($query,$inputs=array())
    {
        $inputs = $inputs + Input::only('search_image_category_id','search_created_from_year','search_created_from_month','search_created_from_day','search_created_to_year','search_created_to_month','search_created_to_day');
        if($inputs['search_image_category_id']) {
            $query = $query->whereImageCategoryId($inputs['search_image_category_id']);
        }
        if($inputs['search_created_from_year'] && $inputs['search_created_from_month'] && $inputs['search_created_from_day']) {
            $time = date('Y-m-d H:i:s',strtotime($inputs['search_created_from_year']."-".$inputs['search_created_from_month']."-".$inputs['search_created_from_day'].' 00:00:00'));
            $query = $query->where('created_at','>=',$time);
        }
        if($inputs['search_created_to_year'] && $inputs['search_created_to_month'] && $inputs['search_created_to_day']) {
            $time = date('Y-m-d H:i:s',strtotime($inputs['search_created_to_year']."-".$inputs['search_created_to_month']."-".$inputs['search_created_to_day'].' 23:59:59'));
            $query = $query->where('created_at','<=',$time);
        }
        $query = $query->whereIn('state',array(self::STATE_VALID));
        $query = $query->whereIn('is_edit',array(self::EDITED));
        return $query;
    }
    
    public function checkTag($tagId)
    {
        return $this->mynavi_tag_id_1 == $tagId || $this->mynavi_tag_id_2 == $tagId || $this->mynavi_tag_id_3 == $tagId;
    }
    
    public function fairs()
    {
        return $this->hasMany('Fair');
    }
    
    public function checkUpload()
    {
        $check = true;
        if($this->is_upload != self::UPLOAD_REGIST) {
            $check = false;
        }
        if($this->upload_zexy == self::UPLOAD_REGIST) {
            $check = false;
        }
        if($this->upload_mynavi == self::UPLOAD_REGIST) {
            $check = false;
        }
        if($this->upload_rakuten == self::UPLOAD_REGIST) {
            $check = false;
        }
        return $check;
    }
    
    public function category()
    {
        return $this->belongsTo('ImageCategory','image_category_id');
    }
}
