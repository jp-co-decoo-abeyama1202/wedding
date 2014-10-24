<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mynavi
 *
 * @author admin-97
 */
class FairMynavi extends FairSite 
{
    const ANSWER_DIV_DOUBLE = 1;
    const ANSWER_DIV_NET = 2;
    const ANSWER_DIV_TEL = 3;
    public static $answerDivList = array(
        self::ANSWER_DIV_DOUBLE => '両方',
        self::ANSWER_DIV_NET => 'ネット',
        self::ANSWER_DIV_TEL => '電話',
    );
    
    public static $answerLimitDivList = array(
        3 => '当日',
        2 => '前日',
        1 => '2日前',
        4 => '3日前',
        5 => '4日前',
        6 => '5日前',
    );
    /**
     * 総合ページで選択された予約受付日時をみんなの用データに変換
     * @param int $day
     * @return int
     * @throws InvalidArgumentException
     */
    public static function convertLimitDiv($day) 
    {
        $day = (int)$day;
        if($day > 5) {
            throw new InvalidArgumentException();
        }
        
        switch($day) {
            case 0:
                return 3;
            case 1:
                return 2;
            case 2:
                return 1;
            default:
                return $day+1;
        }
    }
    
    //put your code here
    public function contents()
    {
        return $this->hasMany('FairMynaviContent');
    }
}
