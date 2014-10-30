<?php
/**
 * @author admin-97
 */
class WorkMynaviImage extends Eloquent  
{
    const IMAGE_CATEGORY_WEDDING = 10;
    const IMAGE_CATEGORY_BANQUET = 11;
    const IMAGE_CATEGORY_FOOD = 12;
    const IMAGE_CATEGORY_GARDEN = 13;
    const IMAGE_CATEGORY_APPEARANCE = 14;
    const IMAGE_CATEGORY_COMMON = 15;
    const IMAGE_CATEGORY_ETC = 16;
    public static $imageCategoryList = array(
        self::IMAGE_CATEGORY_WEDDING => '挙式',
        self::IMAGE_CATEGORY_BANQUET => '披露宴',
        self::IMAGE_CATEGORY_FOOD => '料理・ケーキ',
        self::IMAGE_CATEGORY_GARDEN => '庭',
        self::IMAGE_CATEGORY_APPEARANCE => '外観',
        self::IMAGE_CATEGORY_COMMON => '付帯設備',
        self::IMAGE_CATEGORY_ETC => '小物・その他',
    );
    
    public function tags()
    {
        return $this->hasMany('WorkMynaviImageTag');
    }
}
