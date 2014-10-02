<?php
/**
 * @author admin-97
 */
class WorkZexyValidation 
{
    /**
     * フェア登録をする際のValidate内容
     * @param type $data
     * @return Validation
     */
    public static function getFairInputValidation($data,$type=1)
    {
        switch($type) {
            case 3:
                return self::getFairInputValidationEtc($data);
            case 2:
                return self::getFairInputValidationDetail($data);
            case 1:
            default:
                return self::getFairInputValidationDefault($data);
        }
    }
    
    public static function getAllValidation($keys=array())
    {
        $hour  = array();
        $min   = array();
        $min5  = array();
        for($i=0;$i<60;++$i){
            if($i<24) {
                $hour[] = $i;
            }
            if($i%5===0) {
                $min5[] = $i;
            }
            $min[] = $i;
        }
        $hour = implode(",",$hour);
        $min =  implode(",",$min);
        $min5 = implode(",",$min5);
        $v = array(
            'fairStartHour' => array('required','numeric','in:'.$hour),
            'fairStartMinute' => array('required','numeric','in:'.$min),
            'fairEndHour' => array('required','numeric','in:'.$hour),
            'fairEndMinute' => array('required','numeric','in:'.$min),
            'requiredMinute' => array('numeric','between:0,999'),
            'secretFlg' => array('required','numeric','in:0,1'),
            'headFairFlg' => array('numeric','in:1'),
            'fairNm' => array('required','mb_max:30'),
            'mainCatch' => array('required','mb_max:100'),
            'tourFlg' => array('numeric','in:1'),
            'packYoyakuFlg' => array('numeric','in:1'),
            'packYoyakuKbn' => array('in:02,03'),
            'packYoyakuRealTimeYoyakuUnitKbn' => array('in:01,02'),
            'packYoyakuUketsukeCnt' => array('numeric','between:1,99999'),
            'photoAlbumId' => array("numeric"),
            'fairPerkNaiyo' => array('mb_max:50'),
            'fairPerkPeriod' => array('mb_max:50'),
            'fairPerkRemarks' => array('mb_max:50'),
            'freeConfigQuestion' => array('mb_max:200'),
            'freeConfigAnswerMustFlg' => array('numeric',"in:1"),
            'holdHall' => array('numeric'),
            'inputAddress' => array('required','mb_max:100'),
            'parking' => array('mb_max:50'),
            'targetPerson' => array('mb_max:50'),
            'etc' => array('mb_max:100'),
            'tel11' => array('required','max:4'),
            'tel21' => array('required','max:11'),
            'tel31' => array('required','max:11'),
            'telShubetsuKbn1' => array('numeric','in:0,1'),
            'telTantoNm1' => array('max:100'),
            'tel12' => array('max:4'),
            'tel22' => array('max:11'),
            'tel32' => array('max:11'),
            'telShubetsuKbn2' => array('numeric','in:0,1,2'),
            'telTantoNm2' => array('mb_max:100'),
            'toiawase' => array('mb_max:50'),
            'tanto' => array('mb_max:50'),
            'yoyakuUketsukeHowKbn' => array('numeric','in:1,2'),
            'yoyakuUketsukePossibleNissuNet' => array('numeric','between:0,99'),
            'yoyakuUketsukeEndTimeNet' => array('numeric','in:10,12,14,16,18,20,22,24'),
            'yoyakuUketsukePossibleNissuTel' => array('numeric','between:0,99'),
            'requestChangeConfigKbn' => array('in:01,02'),
            'requestChangeRemFrameCnt' => array('numeric','between:0,99999'),
        );
        //複数部の場合
        for($i=0;$i<=4;++$i) {
            $v["tourRegistDtoList[$i].tourPart"] = array('numeric','between:1,5');
            $v["tourRegistDtoList[$i].tourStartHour"] = array('numeric','in:'.$hour);
            $v["tourRegistDtoList[$i].tourStartMinute"] = array('numeric','in:'.$min5);
            $v["tourRegistDtoList[$i].tourEndHour"] = array('numeric','in:'.$hour);
            $v["tourRegistDtoList[$i].tourEndMinute"] = array('numeric','in:'.$min5);
        }
        //フェア内容
        for($i=0;$i<=9;++$i) {
            $v["hallFairTkchRegistDtoList[$i].fairTkchCd"] = array('in:'.SiteZexy::$_fairCds[$i]);
            if($i>=8) {
                $v["hallFairTkchRegistDtoList[$i].fairTkchEtcNm"] = array('mb_max:200',"required_with:hallFairTkchRegistDtoList[$i].fairTkchCd");
            }
            $v["hallFairTkchRegistDtoList[$i].fairYoyakuShubetsuCd"] = array('in:01,02,03','required_without:packYoyakuFlg');
            $v["hallFairTkchRegistDtoList[$i].yuryoFlg"] = array('numeric','in:0,1',"required_with:hallFairTkchRegistDtoList[$i].fairTkchCd");
            $v["hallFairTkchRegistDtoList[$i].realTimeYoyakuUnitKbn"] = array('in:01,02');
            $v["hallFairTkchRegistDtoList[$i].entryNinzu"] = array('numeric','between:0,999');
            $v["hallFairTkchRegistDtoList[$i].entryCharge"] = array('numeric');
            $v["hallFairTkchRegistDtoList[$i].detail"] = array('mb_max:100');
            //開催時間
            for($t=0;$t<12;++$t) {
                $v["hallFairTkchRegistDtoList[$i].hallHoldTimeRegistDtoList[$t].startHour"] = array('numeric','in:'.$hour);
                $v["hallFairTkchRegistDtoList[$i].hallHoldTimeRegistDtoList[$t].startMinute"] = array('numeric','in:'.$min5);
                $v["hallFairTkchRegistDtoList[$i].hallHoldTimeRegistDtoList[$t].endHour"] = array('numeric','in:'.$hour);
                $v["hallFairTkchRegistDtoList[$i].hallHoldTimeRegistDtoList[$t].endMinute"] = array('numeric','in:'.$min5);
                $v["hallFairTkchRegistDtoList[$i].hallHoldTimeRegistDtoList[$t].title"] = array('mb_max:100');
                if(isset($data["hallFairTkchRegistDtoList[$i].fairYoyakuShubetsuCd"]) && $data["hallFairTkchRegistDtoList[$i].fairYoyakuShubetsuCd"] == '03') {
                    //要予約、予約優先の場合のみ
                    $v["hallFairTkchRegistDtoList[$i].hallHoldTimeRegistDtoList[$t].yoyakuCnt"] = array('numeric','between:0,99999');
                }
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
    
    
    /**
     * フェア入力画面でのValidate
     * @param type $data
     * @return Validator
     */
    private static function getFairInputValidationDefault($data)
    {    
        $v = array(
            'fairStartHour','fairStartMinute',
            'fairEndHour','fairEndMinute',
            'requiredMinute','secretFlg','headFairFlg','fairNm',
            'mainCatch','tourFlg',
            'packYoyakuFlg','packYoyakuKbn','packYoyakuRealTimeYoyakuUnitKbn','packYoyakuUketsukeCnt',
            'photoAlbumId',
        );
        //複数部の場合
        for($i=0;$i<=9;++$i) {
            if($i <= 4) {
                //複数部
                $v[]= "tourRegistDtoList[$i].tourPart";
                $v[]= "tourRegistDtoList[$i].tourStartHour";
                $v[]= "tourRegistDtoList[$i].tourStartMinute";
                $v[]= "tourRegistDtoList[$i].tourEndHour";
                $v[]= "tourRegistDtoList[$i].tourEndMinute";
            }
            $v[]= "hallFairTkchRegistDtoList[$i].fairTkchCd";
            if($i >= 8) {
                $v[]= "hallFairTkchRegistDtoList[$i].fairTkchEtcNm";
            }
            $v[]= "hallFairTkchRegistDtoList[$i].fairYoyakuShubetsuCd";
            $v[]= "hallFairTkchRegistDtoList[$i].yuryoFlg";
            $v[]= "hallFairTkchRegistDtoList[$i].realTimeYoyakuUnitKbn";
            $v[]= "hallFairTkchRegistDtoList[$i].entryNinzu";
            $v[]= "hallFairTkchRegistDtoList[$i].entryCharge";
            $v[]= "hallFairTkchRegistDtoList[$i].detail";
        }
        return Validator::make($data,self::getAllValidation($v));
    }
    
    /**
     * フェア詳細入力でのValidate
     * @param type $data
     * @return Validator
     */
    private static function getFairInputValidationDetail($data)
    {           
        $v = array(
            'packYoyakuRealTimeYoyakuUnitKbn','packYoyakuUketsukeCnt',
        );
        //フェア内容
        for($i=0;$i<=9;++$i) {
            if(isset($data["hallFairTkchRegistDtoList[$i].fairTkchCd"])) {
                $v[] = "hallFairTkchRegistDtoList[$i].fairTkchCd";
                if($i>=8) {
                    $v[] = "hallFairTkchRegistDtoList[$i].fairTkchEtcNm";
                }
                $v[] = "hallFairTkchRegistDtoList[$i].fairYoyakuShubetsuCd";
                $v[] = "hallFairTkchRegistDtoList[$i].yuryoFlg";
                $v[] = "hallFairTkchRegistDtoList[$i].realTimeYoyakuUnitKbn";
                $v[] = "hallFairTkchRegistDtoList[$i].entryNinzu";
                $v[] = "hallFairTkchRegistDtoList[$i].entryCharge";
                $v[] = "hallFairTkchRegistDtoList[$i].detail";
                //開催時間
                for($t=0;$t<12;++$t) {
                    $v[] = "hallFairTkchRegistDtoList[$i].hallHoldTimeRegistDtoList[$t].startHour";
                    $v[] = "hallFairTkchRegistDtoList[$i].hallHoldTimeRegistDtoList[$t].startMinute";
                    $v[] = "hallFairTkchRegistDtoList[$i].hallHoldTimeRegistDtoList[$t].endHour";
                    $v[] = "hallFairTkchRegistDtoList[$i].hallHoldTimeRegistDtoList[$t].endMinute";
                    $v[] = "hallFairTkchRegistDtoList[$i].hallHoldTimeRegistDtoList[$t].title";
                    if(isset($data["hallFairTkchRegistDtoList[$i].fairYoyakuShubetsuCd"]) && $data["hallFairTkchRegistDtoList[$i].fairYoyakuShubetsuCd"] == '03') {
                        //要予約の場合のみ
                        $v[] = "hallFairTkchRegistDtoList[$i].hallHoldTimeRegistDtoList[$t].yoyakuCnt";
                    }
                }
            }
        }
        
        return Validator::make($data,self::getAllValidation($v));
    }
    
    /**
     * フェアその他入力でのValidate
     * @param type $data
     * @return Validator
     */
    private static function getFairInputValidationEtc($data)
    {
        $v = array(
            'fairPerkNaiyo',
            'fairPerkPeriod',
            'fairPerkRemarks',
            'freeConfigQuestion',
            'freeConfigAnswerMustFlg',
            'holdHall',
            'inputAddress',
            'parking',
            'targetPerson',
            'etc',
            'tel11',
            'tel21',
            'tel31',
            'telShubetsuKbn1',
            'telTantoNm1',
            'tel12',
            'tel22',
            'tel32',
            'telShubetsuKbn2',
            'telTantoNm2',
            'toiawase',
            'tanto',
            'yoyakuUketsukeHowKbn',
            'yoyakuUketsukePossibleNissuNet',
            'yoyakuUketsukeEndTimeNet',
            'yoyakuUketsukePossibleNissuTel',
            'requestChangeConfigKbn',
            'requestChangeRemFrameCnt',
        );
        
        return Validator::make($data,self::getAllValidation($v));
    }
    
    /**
     * フェア更新をする際のValidate内容
     * 掲載予定だけはValidateなし
     * @param type $data
     * @return Validation
     */
    public static function getFairUpdateValidation($data,$type='fair_name')
    {
        switch($type) {
            case 'fair_name':
                return self::getFairUpdateValidationFairName($data);
            case 'yoyaku_config':
                return self::getFairUpdateValidationYoyakuConfig($data);
            case 'access_data':
                return self::getFairUpdateValidationAccessData($data);
            case 'fair_perk':
                return self::getFairUpdateValidationFairPerk($data);
            case 'free_question':
                return self::getFairUpdateValidationFreeQuestion($data);
            case 'request_change':
                return self::getFairUpdateValidationRequestChange($data);
            case 'fair_event_0':
                return self::getFairUpdateValidationFairEvent($data);
            case 'fair_event_1':
                return self::getFairUpdateValidationFairEventDetail($data);
            default:
                return null;
        }
    }
    
    /**
     * フェア更新：フェア名
     * @param type $data
     * @return type
     */
    private static function getFairUpdateValidationFairName($data)
    {
        $v = array(
            'secretFlg','headFairFlg','fairNm','mainCatch',
        );
        return Validator::make($data,self::getAllValidation($v));
    }
    
    /**
     * フェア更新：フェア内容
     * @param type $data
     * @return Validator
     */
    private static function getFairUpdateValidationEvent($data)
    {    
        $v = array(
            'fairStartHour','fairStartMinute',
            'fairEndHour','fairEndMinute',
            'requiredMinute',
            'tourFlg',
            'packYoyakuFlg','packYoyakuKbn','packYoyakuRealTimeYoyakuUnitKbn','packYoyakuUketsukeCnt',
        );
        for($i=0;$i<=9;++$i) {
            if($i <= 4) {
                //複数部
                $v[]= "tourRegistDtoList[$i].tourPart";
                $v[]= "tourRegistDtoList[$i].tourStartHour";
                $v[]= "tourRegistDtoList[$i].tourStartMinute";
                $v[]= "tourRegistDtoList[$i].tourEndHour";
                $v[]= "tourRegistDtoList[$i].tourEndMinute";
            }
            //フェア内容
            $v[]= "hallFairTkchRegistDtoList[$i].fairTkchCd";
            if($i >= 8) {
                $v[]= "hallFairTkchRegistDtoList[$i].fairTkchEtcNm";
            }
            $v[]= "hallFairTkchRegistDtoList[$i].fairYoyakuShubetsuCd";
            $v[]= "hallFairTkchRegistDtoList[$i].yuryoFlg";
            $v[]= "hallFairTkchRegistDtoList[$i].realTimeYoyakuUnitKbn";
            $v[]= "hallFairTkchRegistDtoList[$i].entryNinzu";
            $v[]= "hallFairTkchRegistDtoList[$i].entryCharge";
            $v[]= "hallFairTkchRegistDtoList[$i].detail";
        }
        return Validator::make($data,self::getAllValidation($v));
    }
    
    /**
     * フェア更新：フェア内容詳細
     * @param type $data
     * @return Validator
     */
    private static function getFairUpdateValidationFairEventDetail($data)
    {           
        $v = array(
            'packYoyakuRealTimeYoyakuUnitKbn','packYoyakuUketsukeCnt',
        );
        //フェア内容
        for($i=0;$i<=9;++$i) {
            if(isset($data["hallFairTkchRegistDtoList[$i].fairTkchCd"])) {
                $v[] = "hallFairTkchRegistDtoList[$i].fairTkchCd";
                if($i>=8) {
                    $v[] = "hallFairTkchRegistDtoList[$i].fairTkchEtcNm";
                }
                $v[] = "hallFairTkchRegistDtoList[$i].fairYoyakuShubetsuCd";
                $v[] = "hallFairTkchRegistDtoList[$i].yuryoFlg";
                $v[] = "hallFairTkchRegistDtoList[$i].realTimeYoyakuUnitKbn";
                $v[] = "hallFairTkchRegistDtoList[$i].entryNinzu";
                $v[] = "hallFairTkchRegistDtoList[$i].entryCharge";
                $v[] = "hallFairTkchRegistDtoList[$i].detail";
                //開催時間
                for($t=0;$t<12;++$t) {
                    $v[] = "hallFairTkchRegistDtoList[$i].hallHoldTimeRegistDtoList[$t].startHour";
                    $v[] = "hallFairTkchRegistDtoList[$i].hallHoldTimeRegistDtoList[$t].startMinute";
                    $v[] = "hallFairTkchRegistDtoList[$i].hallHoldTimeRegistDtoList[$t].endHour";
                    $v[] = "hallFairTkchRegistDtoList[$i].hallHoldTimeRegistDtoList[$t].endMinute";
                    $v[] = "hallFairTkchRegistDtoList[$i].hallHoldTimeRegistDtoList[$t].title";
                    if(isset($data["hallFairTkchRegistDtoList[$i].fairYoyakuShubetsuCd"]) && $data["hallFairTkchRegistDtoList[$i].fairYoyakuShubetsuCd"] == '03') {
                        //要予約の場合のみ
                        $v[] = "hallFairTkchRegistDtoList[$i].hallHoldTimeRegistDtoList[$t].yoyakuCnt";
                    }
                }
            }
        }
        
        return Validator::make($data,self::getAllValidation($v));
    }
    
    /**
     * フェア更新：アクセスデータ
     * @param type $data
     * @return type
     */
    private static function getFairUpdateValidationAccessData($data)
    {
        $v = array(
            'holdHall','inputAddress','parking','targetPerson','etc','tel11','tel21','tel31','telShubetsuKbn1','telTantoNm1','tel12','tel22','tel32','telShubetsuKbn2','telTantoNm2','toiawase','tanto'
        );
        return Validator::make($data,self::getAllValidation($v));
    }
    
    /**
     * フェア更新：特典
     * @param type $data
     * @return type
     */
    private static function getFairUpdateValidationFairPerk($data)
    {
        $v = array(
            'fairPerkNaiyo','fairPerkPeriod','fairPerkRemarks',
        );
        return Validator::make($data,self::getAllValidation($v));
    }
    
    /**
     * フェア更新：予約受付
     * @param type $data
     * @return type
     */
    private static function getFairUpdateValidationYoyakuConfig($data)
    {
        $v = array(
            'yoyakuUketsukeHowKbn','yoyakuUketsukePossibleNissuNet','yoyakuUketsukeEndTimeNet','yoyakuUketsukePossibleNissuTel'
        );
        return Validator::make($data,self::getAllValidation($v));
    }
    
    /**
     * フェア更新：質問設定
     * @param type $data
     */
    private static function getFairUpdateValidationFreeQuestion($data)
    {
        $v = array(
            'freeConfigQuestion','freeConfigAnswerMustFlg'
        );
        return Validator::make($data,self::getAllValidation($v));
    }
    
    /**
     * フェア更新：リクエスト切替
     * @param type $data
     * @return type
     */
    private static function getFairUpdateValidationRequestChange($data)
    {
        $v = array(
            'requestChangeConfigKbn','requestChangeRemFrameCnt',
        );
        return Validator::make($data,self::getAllValidation($v));
    }
}
