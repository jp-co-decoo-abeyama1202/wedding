<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Sugukon
 *
 * @author admin-97
 */
class FairSugukon extends FairSite {
    const CONTENT_SAMPLING = 1;
    const CONTENT_TRYON = 2;
    const CONTENT_WEDDING = 3;
    const CONTENT_BANQUET = 4;
    const CONTENT_MATERNITY = 5;
    const CONTENT_WAKON = 6;
    
    public static $contentList = array(
        self::CONTENT_SAMPLING => '料理・デザートが試食できるフェア',
        self::CONTENT_TRYON => '衣装が試着できるフェア',
        self::CONTENT_WEDDING => '模擬挙式があるフェア',
        self::CONTENT_BANQUET => '模擬披露宴があるフェア',
        self::CONTENT_MATERNITY => 'マタニティ婚の相談ができるフェア',
        self::CONTENT_WAKON => '和婚体験ができるフェア',
    );
    
    const RESERVE_TIME_TYPE_MARK = 1;
    const RESERVE_TIME_TYPE_ANYTIME = 2;
    public static $reserveTimeTypeList = array(
        self::RESERVE_TIME_TYPE_MARK => '時間指定',
        self::RESERVE_TIME_TYPE_ANYTIME => '随時受付',
    );
    
    public static $reservePeriodLimitList = array(
        0 => '当日',
        1 => '1日前',
        2 => '2日前',
        3 => '3日前',
        4 => '4日前',
        5 => '5日前',
        6 => '6日前',
        7 => '7日前',
    );
}
