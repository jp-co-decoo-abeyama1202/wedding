<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Gnavi
 *
 * @author admin-97
 */
class FairGnavi extends FairSite {
    public static $mList = array(
        0 => '00',
        1 => '01',
        2 => '02',
        3 => '03',
        4 => '04',
        5 => '05',
        6 => '06',
        7 => '07',
        8 => '08',
        9 => '09',
        10=> '10',
        11=> '11',
        12=> '12',
        13=> '13',
        14=> '14',
        15=> '15',
        16=> '16',
        17=> '17',
        18=> '18',
        19=> '19',
        20=> '20',
        21=> '21',
        22=> '22',
        23=> '23',
        24=> '24',
        25=> '25',
        26=> '26',
        27=> '27',
        28=> '28',
        29=> '29',
        30=> '30',
        31=> '31',
        32=> '32',
        33=> '33',
        34=> '34',
        35=> '35',
        36=> '36',
        37=> '37',
        38=> '38',
        39=> '39',
        40=> '40',
        41=> '41',
        42=> '42',
        43=> '43',
        44=> '44',
        45=> '45',
        46=> '46',
        47=> '47',
        48=> '48',
        49=> '49',
        50=> '50',
        51=> '51',
        52=> '52',
        53=> '53',
        54=> '54',
        55=> '55',
        56=> '56',
        57=> '57',
        58=> '58',
        59=> '59',
    );
    public static $fairTypeList = array(
        'tour_flg' => '会場見学',
        'i_wedding_flg' => '模擬挙式',
        'i_reception_flg' => '模擬披露宴',
        'show_flg' => 'ドレスショー見学',
        'fitting_flg' => '衣装試着',
        'hair_flg' => 'ヘアメイク体験',
        'food_flg' => '料理やケーキの展示',
        'tasting_flg' => '試食会',
        'item_flg' => 'アイテム展示',
        'counsel_flg' => '相談会',
        'perk_flg' => '特典あり',
        'gnavi_limit_flg' => 'ぐるなび限定',
        'just_one_ok_flg' => 'おひとり様参加OK',
        'estimate_bid_flg' => '見積書のご案内',
    );
    
    const FAIR_FLG_WEDDING = 1;
    const FAIR_FLG_BANQUET = 2;
    const FAIR_FLG_DRESS_SHOW = 3;
    const FAIR_FLG_TRYON = 4;
    const FAIR_FLG_HAIR = 5;
    const FAIR_FLG_FOOD = 6;
    const FAIR_FLG_SAMPLING = 7;
    const FAIR_FLG_ITEM = 8;
    const FAIR_FLG_QUES = 9;
    const FAIR_FLG_TOUR = 10;
    
    public static $fairFlgList = array(
        self::FAIR_FLG_WEDDING => '模擬挙式',
        self::FAIR_FLG_BANQUET => '模擬披露宴',
        self::FAIR_FLG_DRESS_SHOW => 'ドレスショー見学',
        self::FAIR_FLG_TRYON => '衣装試着',
        self::FAIR_FLG_HAIR => 'ヘアメイク体験',
        self::FAIR_FLG_FOOD => '料理やケーキの展示',
        self::FAIR_FLG_SAMPLING => '試食会',
        self::FAIR_FLG_ITEM => 'アイテム展示',
        self::FAIR_FLG_QUES => '相談会',
        self::FAIR_FLG_TOUR => '会場見学',
    );
    
    const FAIR_TASTEING_FLG_PAY = 1;
    const FAIR_TASTEING_FLG_NOPAY = 2;
    public static $fairTastingFlgList = array(
        self::FAIR_TASTEING_FLG_PAY => '無料',
        self::FAIR_TASTEING_FLG_NOPAY => '有料',
    );
    
    const OPTION_TAX_INCLUDED = 1;
    const OPTION_TAX_EXCLUDING = 0;
    public static $optionTaxList = array(
        self::OPTION_TAX_INCLUDED => '税込',
        self::OPTION_TAX_EXCLUDING => '税抜',
    );
    const OPTION_ROUND_TAX_OFF = 0;
    const OPTION_ROUND_TAX_DOWN = 1;
    const OPTION_ROUND_TAX_UP = 2;
    public static $optionRoundTaxList = array(
        self::OPTION_ROUND_TAX_OFF => '四捨五入',
        self::OPTION_ROUND_TAX_DOWN => '切り捨て',
        self::OPTION_ROUND_TAX_UP => '切り上げ',
    );
}
