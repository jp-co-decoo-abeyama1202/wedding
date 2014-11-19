<?php
/**
 * Fairに紐付くフェア内容
 *
 * @author admin-97
 */
class FairContent extends Eloquent {
    protected $guarded = array('id');
    
    const RESERVE_NONE = 0;
    const RESERVE_PRIORITY = 1;
    const RESERVE_REQUIRED = 2;
    public static $reserveList = array(
        self::RESERVE_NONE => '予約不要',
        self::RESERVE_PRIORITY => '予約優先',
        self::RESERVE_REQUIRED => '要予約',
    );
    
    const PRICE_FLG_ON = 1;
    const PRICE_FLG_OFF = 0;
    public static $priceFlagList = array(
        self::PRICE_FLG_OFF => '無料',
        self::PRICE_FLG_ON => '有料',
    );
    
    
    public function fair()
    {
        return $this->belongsTo('Fair','fair_id');
    }
}
