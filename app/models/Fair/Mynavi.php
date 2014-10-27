<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mynavi
 *
 * @author admin-97
 */
class FairMynavi extends FairSite 
{
    const ANSWER_DIV_DOUBLE = 1;
    const ANSWER_DIV_NET = 2;
    const ANSWER_DIV_TEL = 3;
    public static $answerDivList = array(
        self::ANSWER_DIV_DOUBLE => 'ネット・電話両方で受付',
        self::ANSWER_DIV_NET => 'ネットのみ受付',
        self::ANSWER_DIV_TEL => '電話のみ受付',
    );
    
    public static $answerLimitDivList = array(
        3 => '当日',
        2 => '前日',
        1 => '2日前',
        4 => '3日前',
        5 => '4日前',
        6 => '5日前',
    );

    const FAIR_DETAIL_TYPE_WEDDING = 1;
    const FAIR_DETAIL_TYPE_BANQUET = 2;
    const FAIR_DETAIL_TYPE_SAMPLING_FREE = 3;
    const FAIR_DETAIL_TYPE_SAMPLING_PAY = 4;
    const FAIR_DETAIL_TYPE_TRYON = 5;
    const FAIR_DETAIL_TYPE_QUES = 6;
    const FAIR_DETAIL_TYPE_COORDINATE = 7;
    const FAIR_DETAIL_TYPE_ITEM = 8;
    const FAIR_DETAIL_TYPE_MATANITY = 9;
    const FAIR_DETAIL_TYPE_ETC = 10;
    public static $fairDetailTypeList = array(
        null => '--',
        self::FAIR_DETAIL_TYPE_WEDDING => '模擬挙式',
        self::FAIR_DETAIL_TYPE_BANQUET => '模擬披露宴',
        self::FAIR_DETAIL_TYPE_SAMPLING_FREE => '無料試食会',
        self::FAIR_DETAIL_TYPE_SAMPLING_PAY => '有料試食会',
        self::FAIR_DETAIL_TYPE_TRYON => '衣装試着',
        self::FAIR_DETAIL_TYPE_QUES => '相談会',
        self::FAIR_DETAIL_TYPE_COORDINATE => 'コーディネート見学',
        self::FAIR_DETAIL_TYPE_ITEM => '料理・婚礼アイテムなどの展示',
        self::FAIR_DETAIL_TYPE_MATANITY => 'マタニティ・お急ぎ婚向け相談',
        self::FAIR_DETAIL_TYPE_ETC => 'その他',
    );
    
    const FAIR_RESERVE_DIV_NEED = 1;
    const FAIR_RESERVE_DIV_NONE = 2;
    public static $fairReserveDivList = array(
        self::FAIR_RESERVE_DIV_NEED => '要予約',
        self::FAIR_RESERVE_DIV_NONE => '予約不要',
    );
    
    const FAIR_PRICE_DIV_FREE = 1;
    const FAIR_PRICE_DIV_PAY = 2;
    public static $fairPriceDivList = array(
        self::FAIR_PRICE_DIV_FREE => '無料',
        self::FAIR_PRICE_DIV_PAY => '有料',
    );
    
    public static $mList = array(
        0 => '00',
        10 => '10',
        20 => '20',
        30 => '30',
        40 => '40',
        50 => '50',
    );
    
    /**
     * 総合ページで選択された予約受付日時をみんなの用データに変換
     * @param int $day
     * @return int
     * @throws InvalidArgumentException
     */
    public static function convertLimitDiv($day) 
    {
        $day = (int)$day;
        if($day > 5) {
            throw new InvalidArgumentException();
        }
        
        switch($day) {
            case 0:
                return 3;
            case 1:
                return 2;
            case 2:
                return 1;
            default:
                return $day+1;
        }
    }
    
    //put your code here
    public function contents()
    {
        return $this->hasMany('FairMynaviContent');
    }
}
