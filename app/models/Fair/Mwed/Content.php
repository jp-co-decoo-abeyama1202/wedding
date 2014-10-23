<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * FairXXX系Classの継承用クラス
 *
 * @author admin-97
 */
class FairMwedContent extends Eloquent {
    //put your code here
    public function fairMwed()
    {
        return $this->belongsTo('FairMwed');
    }
}
