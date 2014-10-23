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
class WorkMwedValidation {
    /**
     * Validationの内容全て
     * @param type $data
     * @return type
     */
    public static function getAllValidation($keys=array(),$rejects=array())
    {
        $min = array();
        for($i=0;$i<60;$i+=5) {
            $min[] = $i;
        }
        $min = implode(",",$min);
        $v = array(
            'fair_name' => array('required','mb_max:30'),
            'st_year' => array('required','numeric','between:0,9999'),
            'st_month' => array('required','numeric','between:1,12'),
            'st_day' => array('required','numeric','between:1,31'),
            'st_hour' => array('required','numeric','between:0,23'),
            'st_min' => array('required','numeric','in:'.$min),
            'ed_hour' => array('required','numeric','between:0,23'),
            'ed_min' => array('required','numeric','in:'.$min),
            'type_ques' => array('numeric','in:1'),
            'type_wedding' => array('numeric','in:1'),
            'type_banquet' => array('numeric','in:1'),
            'type_sampling' => array('numeric','in:1'),
            'type_coordinate' => array('numeric','in:1'),
            'type_item' => array('numeric','in:1'),
            'type_tryon' => array('numeric','in:1'),
            'type_etc' => array('numeric','in:1'),
            'disp_sub_flg' => array('numeric','in:1'),
            'etc1_txt' => array('mb_max:15'),
            'etc2_txt' => array('mb_max:15'),
            'plan_txt' => array('mb_max:300'),
            'priv_txt' => array('mb_max:50'),
            'reserve' => array('numeric','in:1,2,3'),
            'reserve_txt' => array('mb_max:20'),
            'rate' => array('numeric','in:0,1,2,3'),
            'rate_txt' => array('mb_max:20'),
            'stpb_year' => array('digits_between:0,4'),
            'stpb_month' => array('between:1,12'),
            'stpb_day' => array('between:1,31'),
            'stpb_hour' => array('between:0,23'),
            'web_rsv' => array('numeric','in:0,1,2,3,4,5,9'),
        );
        for($i=1;$i<16;++$i) {
            $v["dt_type$i"] = array('numeric','in:1,2,3,4,5,6,7,8,9');
            $v["dt_st_hour$i"] = array('numeric','between:0,23');
            $v["dt_st_min$i"] = array('numeric','in:'.$min);
            $v["dt_ed_hour$i"] = array('numeric','between:0,23');
            $v["dt_ed_min$i"] = array('numeric','in:'.$min);
        }
        
        foreach($rejects as $r) {
            if(isset($v[$r])) {
                unset($v[$r]);
            }
        }
        
        if(!$keys) {
            return $v;
        }
        
        $vali = array();
        
        if($keys) {
            foreach($keys as $key) {
                if(isset($v[$r])) {
                    $vali[$key] = $v[$key];
                }
            }
        }
        return $vali;
    }
    
    public static function getFairInputValidation($data)
    {
        $rejects = array(
            'st_year','st_month','st_day'
        );
        return Validator::make($data,self::getAllValidation(array(),$rejects));
    }
    
    public static function getFairUpdateValidation($data)
    {
        return Validator::make($data,self::getAllValidation());
    }
}
