<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Zexyフェアコンテンツ個別
 * @author admin-97
 */
class FairZexyContent extends Eloquent 
{
    const FAIR_YOYAKU_SHUBETSU_CD_NONE = 1;
    const FAIR_YOYAKU_SHUBETSU_CD_PRIORITY = 2;
    const FAIR_YOYAKU_SHUBETSU_CD_REQUIRED = 3;
    public static $fairYoyakuShubetsuCdList = array(
        self::FAIR_YOYAKU_SHUBETSU_CD_NONE => '予約不要',
        self::FAIR_YOYAKU_SHUBETSU_CD_PRIORITY => '予約優先',
        self::FAIR_YOYAKU_SHUBETSU_CD_REQUIRED => '要予約',
    );
    
    const REAL_TIME_YOYAKU_UNIT_KBN_SINGLE = 1;
    const REAL_TIME_YOYAKU_UNIT_KBN_GROUP = 2;
    public static $realTimeYoyakuUnitKbn = array(
        self::REAL_TIME_YOYAKU_UNIT_KBN_SINGLE => '名',
        self::REAL_TIME_YOYAKU_UNIT_KBN_GROUP => '組',
    );
    
    const YURYO_FLG_FREE = 0;
    const YURYO_FLG_PAY = 1;
    public static $yuryoFlgList = array(
        self::YURYO_FLG_FREE => '無料',
        self::YURYO_FLG_PAY => '有料',
    );
    
    //put your code here
    public function fairZexy()
    {
        return $this->belongsTo('FairZexy');
    }
    
    public function details()
    {
        return $this->hasMany('FairZexyContentDetail');
    }
}
