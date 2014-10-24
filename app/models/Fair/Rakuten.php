<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Rakuten
 *
 * @author admin-97
 */
class FairRakuten extends FairSite 
{
    public static $receptionCdList = array(
        1 => '開催日前日まで',
        2 => '開催日2日前まで',
        3 => '開催日3日前まで',
        4 => '開催日4日前まで',
        5 => '開催日5日前まで',
    );
    public static function convertReceptionCd($day)
    {
        $day = (int)$day;
        if($day > 5) {
            throw new InvalidArgumentException();
        }
        switch($day) {
            case 0:
            case 1:
                return 1;
            default:
                return $day;
        }
    }
    
    //put your code here
    public function contents()
    {
        return $this->hasMany('FairRakutenContent');
    }
    
    public function tokutens()
    {
        return $this->hasMany('FairRakutenTokuten');
    }
    
}
