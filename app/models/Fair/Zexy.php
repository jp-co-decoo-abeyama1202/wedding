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
    
    const YOYAKU_KBN_TEL_ONLY = 1;
    const YOYAKU_KBN_DOUBLE = 2;
    public static $yokakuKbnList = array(
        self::YOYAKU_KBN_DOUBLE => 'ネット&電話で受付',
        self::YOYAKU_KBN_TEL_ONLY => '電話で予約受付',
    );
    
    //put your code here
    public function contents()
    {
        return $this->hasMany('FairZexyContent');
    }
}
