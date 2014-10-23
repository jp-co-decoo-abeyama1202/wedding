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
class FairZexyContent extends Eloquent {
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
