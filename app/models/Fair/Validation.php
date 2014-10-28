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
class FairValidation {
    
    public static function getAllValidation(){
        $min = array();
        for($i=0;$i<60;++$i) {
            $min[] = sprintf("%02d",$i);
        }
        $min = implode(",",$min);
        $v = array(
            'state' => array('required','numeric','in:'.implode(array_keys(Fair::$stateList))),
            'flg_gnavi' => array('required','numeric','in:0,1'),
            'flg_mwed' => array('required','numeric','in:0,1'),
            'flg_mynavi' => array('required','numeric','in:0,1'),
            'flg_park' => array('required','numeric','in:0,1'),
            'flg_rakuten' => array('required','numeric','in:0,1'),
            'flg_sugukon' => array('required','numeric','in:0,1'),
            'flg_zexy' => array('required','numeric','in:0,1'),
            'fair_name' => array('required','mb_max:30'),
            'start_h' => array('required','numeric','in:'.implode(array_keys(Fair::$hList))),
            'start_m' => array('required','numeric','in:'.implode(array_keys(Fair::$mList))),
            'description' => array('required','mb_max:100'),
            'target' => array('required','mb_max:50'),
            'other_description' => array('required','mb_max:100'),
            'tour_flg' => array('required','numeric','in:0,1'),
            'pack_flg' => array('required','numeric','in:0,1'),
            'image_id' => array('required','numeric'),
            'image_description' => array('required','mb_max:14'),
            'reserve' => array('required','numeric','in:'.implode(array_keys(Fair::$reserveList))),
            
            
            'fair_time_start_h' => array('numeric','between:0,23'),
            'fair_time_start_m' => array('in:00,05,10,15,20,25,30,35,40,45,50,55'),
            'fair_time_end_h' => array('numeric','between:0,23'),
            'fair_time_end_m' => array('in:00,05,10,15,20,25,30,35,40,45,50,55'),
            'registration_flg' => array('numeric'),
            'visible_end_day' => array('numeric','between:1,10'),
            'fair_img_alt' => array('mb_max:30'),
            'fair_catch' => array('mb_max:30'),
            'fair_read' => array('mb_max:250'),
            'icon_flg' => array('numeric','in:0,1'),
            'program_time_1_h' => array('numeric','between:0,23'),
            'program_time_1_m' => array('in:'.$min),
            'program_comment_1' => array('mb_max:40'),
            'program_time_2_h' => array('numeric','between:0,23'),
            'program_time_2_m' => array('in:'.$min),
            'program_comment_2' => array('mb_max:40'),
            'program_time_3_h' => array('numeric','between:0,23'),
            'program_time_3_m' => array('in:'.$min),
            'program_comment_3' => array('mb_max:40'),
            'program_time_4_h' => array('numeric','between:0,23'),
            'program_time_4_m' => array('in:'.$min),
            'program_comment_4' => array('mb_max:40'),
            'program_time_5_h' => array('numeric','between:0,23'),
            'program_time_5_m' => array('in:'.$min),
            'program_comment_5' => array('mb_max:40'),
            'fair_point' => array('mb_max:30'),
            'tour_flg' => array('numeric'),
            'i_wedding_flg' => array('numeric'),
            'i_reception_flg' => array('numeric'),
            'show_flg' => array('numeric'),
            'fitting_flg' => array('numeric'),
            'hair_flg' => array('numeric'),
            'food_flg' => array('numeric'),
            'tasting_flg' => array('numeric','required_with_all:fair_tasteing_flg'),
            'fair_tasteing_flg' => array('numeric','in:1,2'),
            'pay_tasting_price' => array('numeric','required_if:fair_tasteing_flg,2','required_without:tasting_flg,1'),
            'option_tax' => array('numeric','in:0,1','required_if:fair_tasteing_flg,2'),
            'option_round_tax' => array('numeric','in:0,1,2','required_if:fair_tasteing_flg,2'),
            'item_flg' => array('numeric'),
            'counsel_flg' => array('numeric'),
            'perk_flg' => array('numeric'),
            'gnavi_limit_flg' => array('numeric'),
            'just_one_ok_flg' =>array('numeric'),
            'estimate_bid_flg' => array('numeric'),
            'freeword_search' => array('mb_max:512'),
            'customer_count' => array('numeric','digits_between:1,3'),
            'reserve_flg' => array('numeric','in:0,1')
        );
        return $v;
    }
}
