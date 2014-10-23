<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Validation
 *
 * @author admin-97
 */
class WorkSugukonValidation {
    /**
     * Validationの内容全て
     * @param type $data
     * @return type
     */
    public static function getAllValidation($keys=array(),$rejects=array())
    {
        $hour = '8,9,10,11,12,13,14,15,16,17,18,19,20,21,22';
        $min = '0,10,20,30,40,50';
        
        $v = array(
            'title' => array('required','mb_max:40'),
            'description' => array('required','mb_max:300'),
            'content[1]' => array('numeric','in:1'),
            'content[2]' => array('numeric','in:2'),
            'content[3]' => array('numeric','in:3'),
            'content[4]' => array('numeric','in:4'),
            'content[5]' => array('numeric','in:5'),
            'caption' => array('required','mb_max:14'),
            'reserve_time_type' => array('required','in:1,2'),
            'time_needed[hour]' => array('required','in:0,1,2,3,4,5,6,7,'.$hour.',23'),
            'time_needed[minute]' => array('required','in:0,30'),
            'fee' => array('required','mb_max:27'),
            'reserve_period_limit' => array('required','in:0,1,2,3,4,5,6,7'),
            'parking_explain' => array('required','mb_max:27'),
            'is_recommend' => array('numeric','in:1'),
        );
        for($i=1;$i<6;++$i) {
            $v["reserve_time_fix[$i][hour]"] = array('numeric','in:'.$hour);
            $v["reserve_time_fix[$i][minute]"] = array('numeric','in:'.$min);
        }
        //随時受付タイプ
        $v["reserve_time_fix[begin][hour]"] = array('numeric','in:'.$hour);
        $v["reserve_time_fix[begin][minute]"] = array('numeric','in:0,30');
        $v["reserve_time_fix[end][hour]"] = array('numeric','in:'.$hour);
        $v["reserve_time_fix[end][minute]"] = array('numeric','in:0,30');
        
        foreach($rejects as $r) {
            if(isset($v[$r])) {
                unset($v[$r]);
            }
        }
        if(!$keys) {
            return $v;
        }
        $vali = array();
        foreach($keys as $key) {
            $vali[$key] = $v[$key];
        }
        return $vali;
    }
    
    public static function getFairInputValidation($data)
    {
        return Validator::make($data,self::getAllValidation());
    }
    
    public static function getFairUpdateValidation($data)
    {
        return Validator::make($data,self::getAllValidation());
    }
}
