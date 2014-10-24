<?php
/**
 * Fairに紐付く日付データ
 *
 * @author admin-97
 */
class FairDate extends Eloquent {
    //put your code here
    public function fair()
    {
        return $this->belongsTo('Fair','fair_id');
    }
}
