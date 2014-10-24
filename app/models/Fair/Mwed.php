<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mwed
 *
 * @author admin-97
 */
class FairMwed extends FairSite 
{
    const RESERVE_NEED = 1;
    const RESERVE_PRIORITY = 2;
    const RESERVE_NONE = 3;
    public static $reserveList = array(
        self::RESERVE_NEED => '要予約',
        self::RESERVE_PRIORITY => '予約優先',
        self::RESERVE_NONE => '予約不要',
    );
    const RATE_FREE = 0;
    const RATE_PAY = 1;
    const RATE_PART_PAY = 2;
    const RATE_NONE = 3;
    public static $rateList = array(
        self::RATE_FREE => '無料',
        self::RATE_PAY => '有料',
        self::RATE_PART_PAY => '一部有料',
        self::RATE_NONE => '設定なし',
    );
    const WEB_RSV_ALWAYS = 0;
    const WEB_RSV_1 = 1;
    const WEB_RSV_2 = 2;
    const WEB_RSV_3 = 3;
    const WEB_RSV_4 = 4;
    const WEB_RSV_5 = 5;
    const WEB_RSV_STOP = 9;
    public static $webRsvList = array(
        self::WEB_RSV_ALWAYS => 'フェア開催日まで',
        self::WEB_RSV_1 => '開催1日前まで',
        self::WEB_RSV_2 => '開催2日前まで',
        self::WEB_RSV_3 => '開催3日前まで',
        self::WEB_RSV_4 => '開催4日前まで',
        self::WEB_RSV_5 => '開催5日前まで',
        self::WEB_RSV_STOP => '予約停止',
    );
    
    public function contents()
    {
        return $this->hasMany('FairMwedContent');
    }
}
