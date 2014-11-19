<?php
/**
 * 画像カテゴリ情報クラス
 * @author admin-97
 */
class ImageCategory extends Eloquent 
{
    protected $guarded = array('id');
    const CATEGORY_NONE = 0;
    public static function getList()
    {
        $ret = array();
        foreach(self::all() as $category) {
            $ret[$category->id] = $category->name;
        }
        return array(self::CATEGORY_NONE => '選択なし') + $ret;
    }
    
    public function images()
    {
        return $this->hasMany('Image');
    }
}
