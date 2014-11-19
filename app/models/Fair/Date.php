<?php
/**
 * Fairに紐付く日付データ
 *
 * @author admin-97
 */
class FairDate extends Eloquent {
    
    const STATE_REGIST = 0;
    const STATE_REGISTED = 1;
    const STATE_DELETE = 2;
    const STATE_DELETED = 3;
    
    public static $stateList = array(
        self::STATE_REGIST => '同期待ち',
        self::STATE_REGISTED => '同期済み',
        self::STATE_DELETE => '削除待ち',
        self::STATE_DELETED => '削除済み',
    );
    
    public function fair()
    {
        return $this->belongsTo('Fair','fair_id');
    }
}
