<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Park
 *
 * @author admin-97
 */
class FairPark extends FairSite 
{
    
    const FAIR_FLAG_WEDDING = 2;
    const FAIR_FLAG_BANQUET = 3;
    const FAIR_FLAG_SAMPLING = 6;
    const FAIR_FLAG_TRYON = 7;
    const FAIR_FLAG_COORDINATE = 8;
    const FAIR_FLAG_ITEM = 9;
    const FAIR_FLAG_QUES = 10;
    const FAIR_FLAG_ETC_1 = 1;
    const FAIR_FLAG_ETC_2 = 11;
    const FAIR_FLAG_ETC_3 = 12;
    
    public static $fairFlgList = array(
        self::FAIR_FLAG_WEDDING => '模擬挙式',
        self::FAIR_FLAG_BANQUET => '模擬披露宴',
        self::FAIR_FLAG_SAMPLING => '試食会',
        self::FAIR_FLAG_TRYON => '試着会',
        self::FAIR_FLAG_COORDINATE => '会場コーディネート展示',
        self::FAIR_FLAG_ITEM => '婚礼アイテム展示',
        self::FAIR_FLAG_QUES => '相談会',
        self::FAIR_FLAG_ETC_1 => 'その他1',
        self::FAIR_FLAG_ETC_2 => 'その他2',
        self::FAIR_FLAG_ETC_3 => 'その他3',
    );
    
    public function contents()
    {
        return $this->hasMany('FairParkContent');
    }
}
