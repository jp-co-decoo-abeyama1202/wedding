<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Zexy
 *
 * @author admin-97
 */
class FairZexy extends FairSite 
{
    protected $table = 'fair_zexys';
    
    const PACK_YOYAKU_KBN_PRIORITY = 2;
    const PACK_YOYAKU_KBN_REQUIRED = 3;
    public static $packYoyakuKbnList = array(
        self::PACK_YOYAKU_KBN_PRIORITY => '予約優先',
        self::PACK_YOYAKU_KBN_REQUIRED => '要予約',
    );
    
    const PACK_YOYAKU_UNIT_KBN_SINGLE = 1;
    const PACK_YOYAKU_UNIT_KBN_GROUP = 2;
    public static $packYoyakuUnitKbnList = array(
        self::PACK_YOYAKU_UNIT_KBN_SINGLE => '名',
        self::PACK_YOYAKU_UNIT_KBN_GROUP => '組',
    );
    
    const YOYAKU_KBN_TEL_ONLY = 1;
    const YOYAKU_KBN_DOUBLE = 2;
    public static $yokakuKbnList = array(
        self::YOYAKU_KBN_DOUBLE => 'ネット&電話で受付',
        self::YOYAKU_KBN_TEL_ONLY => '電話で予約受付',
    );
    
    const FAIR_TKCH_CD_QUES = 4;
    const FAIR_TKCH_CD_WEDDING = 5;
    const FAIR_TKCH_CD_BANQUET = 6;
    const FAIR_TKCH_CD_SAMPLING = 7;
    const FAIR_TKCH_CD_TRYON = 8;
    const FAIR_TKCH_CD_FASHIONSHOW = 9;
    const FAIR_TKCH_CD_COORDINATE = 10;
    const FAIR_TKCH_CD_ITEM = 11;
    const FAIR_TKCH_CD_ETC_1 = 12;
    const FAIR_TKCH_CD_ETC_2 = 13;
    
    public static $fairFlgList = array(
        self::FAIR_TKCH_CD_QUES => '相談会',
        self::FAIR_TKCH_CD_WEDDING => '模擬挙式',
        self::FAIR_TKCH_CD_BANQUET => '模擬披露宴',
        self::FAIR_TKCH_CD_SAMPLING => '試食会',
        self::FAIR_TKCH_CD_TRYON => '試着会',
        self::FAIR_TKCH_CD_FASHIONSHOW => 'ファッションショー',
        self::FAIR_TKCH_CD_COORDINATE => '会場コーディネート',
        self::FAIR_TKCH_CD_ITEM => '料理・引き出物などの展示',
        self::FAIR_TKCH_CD_ETC_1 => 'その他1',
        self::FAIR_TKCH_CD_ETC_2 => 'その他2',
    );
    
    const TEL_SHUBETSU_KBN_TEL = 0;
    const TEL_SHUBETSU_KBN_FREE = 1;
    const TEL_SHUBETSU_KBN_FAX = 2;
    public static $telShubetsuKbnList = array(
        self::TEL_SHUBETSU_KBN_TEL => 'TEL',
        self::TEL_SHUBETSU_KBN_FREE => '無料TEL',
        self::TEL_SHUBETSU_KBN_FAX => 'FAX',
    );
    
    const REQUEST_CHANGE_CONFIG_KBN_ON = 1;
    const REQUEST_CHANGE_CONFIG_KBN_OFF = 2;
    public static $requestChangeConfigKbnList = array(
        self::REQUEST_CHANGE_CONFIG_KBN_ON => 'リクエスト切替する',
        self::REQUEST_CHANGE_CONFIG_KBN_OFF => 'リクエスト切替しない',
    );
    
    
    //put your code here
    public function contents()
    {
        return $this->hasMany('FairZexyContent');
    }
}
