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
    
    public static $imageTagCategoryList = array(
        1 => array(
            'title' => '付帯設備/アイテム',
            'list' => array(
                array(
                    'title' => '設備',
                    'ids' => array(1,2,3,4,5,6,7,8),
                ),
                array(
                    'title' => 'アイテム',
                    'ids' => array(9,10,11),
                ),
            ),
        ),
        2 => array(
            'title' => '雰囲気',
            'list' => array(
                array(
                    'title' => 'スタイル',
                    'ids' => array(12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39),
                ),
                array(
                    'title' => 'サービス',
                    'ids' => array(40,41),
                ),
                array(
                    'title' => '景観',
                    'ids' => array(42,43,44),
                ),
            )
        )
    );
    public static $imageTagList = array(
        1 => 'チャペル',
        2 => '披露宴会場',
        3 => '神殿',
        4 => 'ガーデン',
        5 => '日本庭園',
        6 => 'バージンロード',
        7 => '大階段',
        8 => 'プール',
        9 => 'ウエディングアイテム',
        10 => '料理',
        11 => 'ケーキ',
        12 => '豪華な',
        13 => '上質な',
        14 => 'ロマンチック',
        15 => 'ナチュラル',
        16 => 'スタイリッシュ',
        17 => 'アットホーム',
        18 => 'オリジナリティのある',
        19 => 'シンプル',
        20 => 'カジュアル',
        21 => 'カラフル',
        22 => 'おごそか',
        23 => '幻想的',
        24 => 'ヨーロピアン',
        25 => 'オリエンタル',
        26 => 'クラシカル',
        27 => '清楚',
        28 => '大人カワイイ',
        29 => 'お姫様スタイル',
        30 => '温かみのある',
        31 => 'プライベート感',
        32 => '非日常的',
        33 => '緑を感じる',
        34 => 'リゾート感',
        35 => '開放感のある',
        36 => '和モダン',
        37 => '和の伝統',
        38 => 'ゲストと楽しむ',
        39 => 'ウッド調',
        40 => 'スタッフが自慢',
        41 => '料理にこだわり',
        42 => '海が見える',
        43 => '高層階からの眺め',
        44 => '夜景がきれい',
    );
    
    const PHOTO_SHOW_MAX = 30;
    const PHOTO_SHOW_CACHE_KEY = 'work_mynavi_image_photo_show';
    const INSPIRATION_SEARCH_MAX = 10;
    const INSPIRATION_SEARCH_CACHE_KEY = 'work_mynavi_inspiration_search';
    
    public static function scopePhotoShow($query)
    {
        return $query->select('id')->where('photo_show_flg',Fair::FLG_ON)->rememberForever(self::PHOTO_SHOW_CACHE_KEY);
    }
    
    public static function clearPhotoShow()
    {
        Cache::forget(self::PHOTO_SHOW_CACHE_KEY);
    }
    
    public static function scopeInspirationSearch($query)
    {
        return $query->select('id')->where('inspiration_search_flg',Fair::FLG_ON)->rememberForever(self::INSPIRATION_SEARCH_CACHE_KEY);
    }
    
    public static function clearInspirationSearch()
    {
        Cache::forget(self::INSPIRATION_SEARCH_CACHE_KEY);
    }
    
    public function getFileName()
    {
        return $this->id . "_sd.jpg";
    }
    
    public function getFilePath($short=false)
    {
        $path = $short ? Config::get('application.work.img_short_path') : Config::get('application.work.img_path');
        $path.= substr($path,-1) === DIRECTORY_SEPARATOR ? '' : DIRECTORY_SEPARATOR;
        $path.= 'mynavi/';
        $path.= $this->getFileName();
        return $path;
    }
}
