<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * 楽天フェアコンテンツ個別
 * @author admin-97
 */
class FairRakutenContent extends Eloquent {
    //put your code here
    public function fairRakuten()
    {
        return $this->belongsTo('FairRakuten');
    }
}
