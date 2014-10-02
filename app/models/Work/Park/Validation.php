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
class WorkParkValidation {
    /**
     * Validate内容全て
     * @param type $data
     * @return type
     */
    public static function getAllValidation($keys=array())
    {
        $hour = array();
        $min  = array();
        for($i=0;$i<60;++$i){
            if($i<24) {
                $hour[] = sprintf('%02d',$i);
            }
            $min[] = sprintf('%02d',$i);
        }
        $hour = implode(",",$hour);
        $min = implode(",",$min);
        
        $v = array(
                'start_hour' => array('required','in:'.$hour),
                'start_min' => array('required','in:'.$min),
                'end_hour' => array('required','in:'.$hour),
                'end_min' => array('required','in:'.$min),
                'name' => array('max:35'),
                'description' => array('max:115'),
                'award_flag' => array('numeric','in:1'),
                'award_note' => array('max:200'),
            );
        for($i=1;$i<12;++$i) {
            $v["fair_types[$i][check_flag]"] = array('numeric','in:'.$i);
            $v["fair_types[$i][id]"] = array('numeric','in:'.$i);
            $v["fair_types[$i][item][title]"] = array('in:'.SitePark::$_fair_titles[$i]);
            if(in_array($i,array(1,11,12))) {
                //その他パターン
                $v["fair_types[$i][item][name]"] = array('max:35');
            }
            $v["fair_types[$i][item][reservation_flag]"] = array('numeric','in:1');
            $v["fair_types[$i][item][people]"] = array('numeric');
            $v["fair_types[$i][item][tax_8_fee]"] = array('numeric');
            $v["fair_types[$i][item][start_hour1]"] = array('in:'.$hour);
            $v["fair_types[$i][item][start_min1]"] = array('in:'.$min);
            $v["fair_types[$i][item][start_hour2]"] = array('in:'.$hour);
            $v["fair_types[$i][item][start_min2]"] = array('in:'.$min);
            $v["fair_types[$i][item][start_hour3]"] = array('in:'.$hour);
            $v["fair_types[$i][item][start_min3]"] = array('in:'.$min);
            $v["fair_types[$i][item][note]"] = array('max:200');
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
