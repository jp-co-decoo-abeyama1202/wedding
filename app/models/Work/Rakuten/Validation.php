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
class WorkRakutenValidation {
    
    /**
     * 
     * @param type $keys
     * @return array
     */
    public static function getAllValidation($keys=array(),$rejects=array()){
        $hour = array();
        $min  = array();
        for($i=0;$i<60;$i+=5){
            $min[] = sprintf('%02d',$i);
        }
        $hour = '8,9,10,11,12,13,14,15,16,17,18,19,20';
        $min = implode(",",$min);
        
        $v = array(
            'frm[fair_name]' => array('required','mb_max:40'),
            'frm[introduction]' => array('required','mb_max:200'),
            'frm[reception_cd]' => array('numeric','in:1,2,3,4,5'),
            'frm[photo_id]' => array('required','numeric'),
            'frm[same_event_time_flg]' => array('numeric','in:0'),
            'frm[same_event_time][event_time_from_hour]' => array('numeric','in:'.$hour,'required_with:foo:frm[same_event_time_flg]'),
            'frm[same_event_time][event_time_from_minute]' => array('numeric','in:'.$min,'required_with:foo:frm[same_event_time_flg]'),
            'frm[same_event_time][event_time_to_hour]' => array('numeric','in:'.$hour,'required_with:foo:frm[same_event_time_flg]'),
            'frm[same_event_time][event_time_to_minute]' => array('numeric','in:'.$min,'required_with:foo:frm[same_event_time_flg]'),
        );
        
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
        $rejects = array();
        if(!isset($data['frm[same_event_time_flg]'])) {
            $rejects = array(
                'frm[same_event_time][event_time_from_hour]',
                'frm[same_event_time][event_time_from_minute]',
                'frm[same_event_time][event_time_to_hour]',
                'frm[same_event_time][event_time_to_minute]',
            );
        }
        return Validator::make($data,self::getAllValidation(array(),$rejects));
    }
    
    public static function getFairUpdateValidation($data)
    {
        if(!isset($data['frm[same_event_time_flg]'])) {
            $rejects = array(
                'frm[same_event_time][event_time_from_hour]',
                'frm[same_event_time][event_time_from_minute]',
                'frm[same_event_time][event_time_to_hour]',
                'frm[same_event_time][event_time_to_minute]',
            );
        }
        return Validator::make($data,self::getAllValidation(array(),$rejects));
    }
}
