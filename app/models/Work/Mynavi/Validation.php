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
class WorkMynaviValidation {
    /**
     * Validationの内容全て
     * @param type $data
     * @return type
     */
    public static function getAllValidation($keys=array())
    {
        $hour  = array();
        $min5  = array();
        $min10 = array();
        for($i=0;$i<60;++$i){
            if($i<24) {
                $hour[] = $i;
            }
            if($i%5===0) {
                $min5[] = $i;
            }
            if($i%10===0) {
                $min10[] = $i;
            }
        }
        $hour = implode(",",$hour);
        $min5 = implode(",",$min5);
        $min10 = implode(",",$min10);
        
        $v = array(
            'title' => array('required','mb_max:100'),
            'text' => array('mb_max:500'),
            'imageId' => array('numeric'),
            'imageSrc' => array('mb_max:500'),
            'imageTitle' => array('mb_max:500'),
            'accessDataId' => array('numeric'),
            'accessLocation' => array('mb_max:200'),
            'accessLocationNote' => array('mb_max:500'),
            'accessEtc' => array('mb_max:100'),
            'answerDiv' => array('required','in:1,2,3'),
            'answerLimitNetDiv' => array('in:1,2,3,4,5,6,7,8,9,10,11'),
            'answerLimitTimeNet' => array('in:'.$hour),
            'answerLimitTelDiv' => array('in:1,2,3,4,5,6,7,8,9,10,11'),
            'answerLimitTimeTel' => array('in:'.$hour),
            'targetNote' => array('mb_max:100'),
            'etcNote' => array('mb_max:500'),
            'specialNote' => array('max:500'),
            'pluraFlg' => array('in:on'),
            'maxOpenTimeRow' => array('required','numeric','between:1,5'),
            'needHour' => array('numeric','in:'.$hour),
            'needMinute' => array('numeric','in:'.$min10),
            'detailUnselectFlg' => array('in:on'),
            'registTemplate' => array('in:on'),
            'fairTemplateName' => array('mb_max:100','required_with:registTemplate'),
        );
        //複数部の場合
        for($i=1;$i<=5;++$i) {
            $v['startHour'.$i] = array('numeric','in:'.$hour);
            $v['startMinute'.$i] = array('numeric','in:'.$min5);
            $v['endHour'.$i] = array('numeric','in:'.$hour);
            $v['endMinute'.$i] = array('numeric','in:'.$min5);
        }
        //フェア内容
        for($i=0;$i<8;++$i) {
            $v["fairDetailFormList[$i].fairDetailType"] = array('numeric','in:1,2,3,4,5,6,7,8,9,10');
            $v["fairDetailFormList[$i].etcNote"] = array('mb_max:100',"required_if:fairDetailFormList[$i].fairDetailType,10");
            $v["fairDetailFormList[$i].reserveDiv"] = array('numeric','in:1,2');
            $v["fairDetailFormList[$i].priceDiv"] = array('numeric','in:1,2');
            $v["fairDetailFormList[$i].price"] = array('numeric',"required_if:fairDetailFormList[$i].priceDiv,2");
            //複数部の場合
            for($t=1;$t<=5;++$t) {
                $v["fairDetailFormList[$i].startHour$t"] = array('numeric','in:'.$hour);
                $v["fairDetailFormList[$i].startMinute$t"] = array('numeric','in:'.$min5);
                $v["fairDetailFormList[$i].endHour$t"] = array('numeric','in:'.$hour);
                $v["fairDetailFormList[$i].endMinute$t"] = array('numeric','in:'.$min5);
            }
            $v["fairDetailFormList[$i].headline"] = array('mb_max:100');
            $v["fairDetailFormList[$i].complement"] = array('mb_max:500');
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
