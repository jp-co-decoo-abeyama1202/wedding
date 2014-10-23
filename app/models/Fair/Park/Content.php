<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Mynaviフェアコンテンツ個別
 * @author admin-97
 */
class FairParkContent extends Eloquent {
    //put your code here
    public function fairPark()
    {
        return $this->belongsTo('FairPark');
    }
}
