<?php
/**
 * フェア情報クラス
 * @author admin-97
 */
class Fair extends Eloquent 
{
    const FLG_ON = 1;
    const FLG_OFF = 0;
    
    const TOUR_FLAG = 1;
    const PACK_FLAG = 2;
    
    public static $hList = array(
        0  => '00',
        1  => '01',
        2  => '02',
        3  => '03',
        4  => '04',
        5  => '05',
        6  => '06',
        7  => '07',
        8  => '08',
        9  => '09',
        10 => '10',
        11 => '11',
        12 => '12',
        13 => '13',
        14 => '14',
        15 => '15',
        16 => '16',
        17 => '17',
        18 => '18',
        19 => '19',
        20 => '20',
        21 => '21',
        22 => '22',
        23 => '23',
    );
    
    public static $mList = array(
        0  => '00',
        5  => '05',
        10 => '10',
        15 => '15',
        20 => '20',
        25 => '25',
        30 => '30',
        35 => '35',
        40 => '40',
        45 => '45',
        50 => '50',
        55 => '55',
    );
    
    const STATE_DRAFT = 0;
    const STATE_WAIT = 1;
    const STATE_ADVERTISING = 2;
    const STATE_UPLOAD_NOW = 10;
    const STATE_DELETE = 20;
    public static $stateList = array(
        self::STATE_DRAFT => '下書き',
        self::STATE_WAIT => '本番反映待ち',
        self::STATE_ADVERTISING => '本番反映済み',
        self::STATE_UPLOAD_NOW => '本番反映中',
        self::STATE_DELETE => '削除',
    );
    
    const RESERVE_NONE = 0;
    const RESERVE_NET_ONLY = 1;
    const RESERVE_TEL_ONLY = 2;
    const RESERVE_NET_PRIORITY = 3;
    const RESERVE_TEL_PRIORITY = 4;
    
    public static $reserveList = array(
        self::RESERVE_NONE => '予約不要',
        self::RESERVE_NET_ONLY => 'ネット予約のみ',
        self::RESERVE_TEL_ONLY => '電話予約のみ',
        self::RESERVE_NET_PRIORITY => 'ネット予約優先',
        self::RESERVE_TEL_PRIORITY => '電話予約優先',
    );
    
    public static $reserveDayList = array(
        0 => '当日',
        1 => '前日',
        2 => '2日前',
        3 => '3日前',
        4 => '4日前',
        5 => '5日前',
    );
    public static $reserveTimeList = array(
        10 => '10:00',
        12 => '12:00',
        14 => '14:00',
        16 => '16:00',
        18 => '18:00',
        20 => '20:00',
        22 => '22:00',
    );
    const HOLL_PLACE = 1;
    const HOLL_OTHER = 2;
    public static $hollList = array(
        self::HOLL_PLACE => '会場',
        self::HOLL_OTHER => 'その他',
    );
    
    const TEL_SYUBETSU_NORMAL = 1;
    const TEL_SYUBETSU_NOPRICE = 2;
    const TEL_SYUBETSU_FAX = 3;
    const TEL_SYUBETSU_NONE = 0;
    public static $telSyubetsuList = array(
        self::TEL_SYUBETSU_NORMAL => 'TEL',
        self::TEL_SYUBETSU_NOPRICE => '無料TEL',
        self::TEL_SYUBETSU_FAX => 'FAX',
        self::TEL_SYUBETSU_NONE => '指定しない',
    );      
            
    protected $softDelete = true;
    
    public function formatting()
    {
        $this->gnavi = new FairGnavi();
        $this->mwed = new FairMwed();
        $this->mynavi = new FairMynavi();
        $this->park = new FairPark();
        $this->rakuten = new FairRakuten();
        $this->sugukon = new FairSugukon();
        $this->zexy = new FairZexy();
    }
    
    public function gnavi()
    {
        return $this->hasOne('FairGnavi');
    }
    
    public function mwed()
    {
        return $this->hasOne('FairMwed');
    }
    
    public function mynavi()
    {
        return $this->hasOne('FairMynavi');
    }
    
    public function park()
    {
        return $this->hasOne('FairPark');
    }
    
    public function rakuten()
    {
        return $this->hasOne('FairRakuten');
    }
    
    public function sugukon()
    {
        return $this->hasOne('FairSugukon');
    }
    
    public function zexy()
    {
        return $this->hasOne('FairZexy');
    }
    /**
     * フェア開催日付
     * @return type
     */
    public function dates()
    {
        return $this->hasMeny('FairDate');
    }
    
    public function contents()
    {
        return $this->hasMany('FairContent');
    }
    
    
    // Convert
    public function convertGnavi()
    {
        $fair = new FairGnavi();
        $fair->fair_id = $this->id;
        $fair->fair_title = $this->fair_name;
        $fair->fair_time_start_h = $this->start_h;
        $fair->fair_time_start_m = $this->start_m;
        $fair->fair_time_end_h = $this->end_h;
        $fair->fair_time_end_m = $this->end_m;
        $fair->registration_flg = 1;//参加希望時間指定
        $fair->visible_end_day = 1;//表示終了日
        $fair->fair_img_alt = $this->image_description;
        $fair->fair_catch = "";
        $fair->fair_read = $this->description;
        $fair->icon_flg = $this->reserve === self::RESERVE_NONE ? self::FLG_OFF : self::FLG_ON;
        /*
        $fair->program_time_1_h
        $fair->program_time_1_m
        $fair->program_comment_1
        $fair->program_time_2_h
        $fair->program_time_2_m
        $fair->program_comment_2
        $fair->program_time_3_h
        $fair->program_time_3_m
        $fair->program_comment_3
        $fair->program_time_4_h
        $fair->program_time_4_m
        $fair->program_comment_4
        $fair->program_time_5_h
        $fair->program_time_5_m
        $fair->program_comment_5
         */
        $fair->fair_point = $fair->target;
        /*
        $fair->tour_flg
        $fair->i_wedding_flg
        $fair->i_reception_flg
        $fair->show_flg
        $fair->fitting_flg
        $fair->hair_flg
        $fair->food_flg
        $fair->tasting_flg
        $fair->fair_tasteing_flg
        $fair->pay_tasting_price
        $fair->option_tax
        $fair->option_round_tax
        $fair->item_flg
        $fair->counsel_flg
        */
        $fair->perk_flg = self::FLG_OFF;
        $fair->gnavi_limit_flg = self::FLG_OFF;
        $fair->just_one_ok_flg = self::FLG_OFF;
        $fair->estimate_bid_flg = self::FLG_OFF;
        $fair->freeword_search = $this->other_description;
        $fair->customer_count = 0;
        $fair->reserve_flg = $this->reserve === self::RESERVE_NONE ? self::FLG_OFF : self::FLG_ON;
        return $fair;
    }
    
    public function convertMwed()
    {
        $fair = new FairMwed();
        $fair->fair_id = $this->id;
        $fair->fair_name = $this->fair_name;
        $fair->st_hour = $this->start_h;
        $fair->st_min = $this->start_m;
        $fair->ed_hour = $this->end_h;
        $fair->ed_min = $this->end_m;
        /*
        $fair->type_ques 
        $fair->type_wedding
        $fair->type_banquet
        $fair->type_sampling
        $fair->type_coordinate
        $fair->type_item
        $fair->type_tryon
        $fair->type_etc
        $fair->disp_sub_flg
        
        $fair->etc1_txt
        $fair->etc2_txt
        */
        $fair->plan_txt = $this->description;
        $fair->priv_txt = "";
        $fair->reserve = self::RESERVE_NONE ? FairMwed::RESERVE_NONE : FairMwed::RESERVE_NEED;
        $fair->reserve_txt = $this->reserve_description;
        /*
        $fair->rate
        $fair->rate_txt
        */
        $fair->stpb_year = date('Y',$this->post_start);
        $fair->stpb_month = date('m',$this->post_start);
        $fair->stpb_day = date('d',$this->post_start);
        $fair->stpb_hour = date('h',$this->post_start);
        $fair->web_rsv = FairMwed::WEB_RSV_ALWAYS;
        return $fair;
    }
    
    public function convertMynavi()
    {
        $fair = new FairMynavi();
        $fair->fair_id = $this->id;
        $fair->title = $this->fair_name;
        $fair->text = $this->description;
        $fair->image_title = $this->image_description;
        $fair->access_location = $this->address;
        $fair->access_location_note = $this->parking ? '駐車場：'.$this->parking : '';
        $fair->access_etc = "";
        if($this->reserve == self::RESERVE_NET_ONLY) {
            $fair->answer_div = FairMynavi::ANSWER_DIV_NET;
        } else if($this->reserve == self::RESERVE_TEL_ONLY) {
            $fair->answer_div = FairMynavi::ANSWER_DIV_TEL;
        } else {
            $fair->answer_div = FairMynavi::ANSWER_DIV_DOUBLE;
        }
        $fair->answer_limit_net_div = FairMynavi::convertLimitDiv($this->reserve_net_day);
        $fair->answer_limit_time_net = $this->reserve_net_time;
        $fair->answer_limit_tel_div = FairMynavi::convertLimitDiv($this->_reserve_tel_day);
        $fair->answer_limit_time_tel = $this->reserve_tel_time;
        $fair->target_note = $this->target;
        $fair->etc_note = $this->other_description;
        $fair->special_note = "";
        /*
        $fair->plura_flg 
        $fair->max_open_time_row
        $fair->start_hour1
        $fair->start_minute1
        $fair->end_hour1
        $fair->end_minute1
        $fair->start_hour2
        $fair->start_minute2
        $fair->end_hour2
        $fair->end_minute2
        $fair->start_hour3
        $fair->start_minute3
        $fair->end_hour3
        $fair->end_minute3
        $fair->start_hour4
        $fair->start_minute4
        $fair->end_hour4
        $fair->end_minute4
        $fair->start_hour5
        $fair->start_minute5
        $fair->end_hour5
        $fair->end_minute5
        $fair->need_hour
        $fair->need_minute
        $fair->detail_unselect_flg
        */
        return $fair;
    }
    
    public function convertPark()
    {
        $fair = new FairPark();
        $fair->fair_id = $this->id;
        /*
        $fair->any_time_flag
         */
        $fair->start_hour = $this->start_h;
        $fair->start_min = $this->start_m;
        $fair->end_hour = $this->end_h;
        $fair->end_min = $this->end_m;
        $fair->name = $this->fair_name;
        $fair->description = $this->description;
        /*
        $fair->fair_2_flag
        $fair->fair_3_flag
        $fair->fair_6_flag
        $fair->fair_7_flag
        $fair->fair_8_flag
        $fair->fair_9_flag
        $fair->fair_10_flag
        $fair->fair_1_flag
        $fair->fair_11_flag
        $fair->fair_12_flag
        $fair->award_flag
        $fair->award_note
        */
        return $fair;
    }
    
    public function convertRakuten()
    {
        $fair = new FairRakuten();
        $fair->fair_id = $this->id;
        $fair->fair_name = $this->fair_name;
        $fair->introduction = $this->description;
        $fair->reserve_online_flag = self::FLG_ON;
        $fair->reception_cd = FairRakuten::convertReceptionCd($this->reserve_net_day);
        if(in_array($this->reserve,array(self::RESERVE_TEL_ONLY,self::RESERVE_NET_PRIORITY,self::RESERVE_TEL_PRIORITY))) {
            $fair->reserve_phone_flag = self::FLG_ON;
        } else {
            $fair->reserve_phone_flag = self::FLG_OFF;
        }
        /*   
        $fair->same_event_time_flg
        $fair->same_event_from_hour
        $fair->same_event_from_minute
        $fair->same_event_to_hour
        $fair->same_event_to_minute
        */
        return $fair;
    }
    
    public function convertSugukon()
    {
        $fair = new FairSugukon();
        $fair->fair_id = $this->id;
        $fair->title = $this->fair_name;
        $fair->description = $this->description;
        /*
        $fair->content_1
        $fair->content_2
        $fair->content_3
        $fair->content_4
        $fair->content_5
        $fair->content_6
         * 
         */
        $fair->caption = $this->image_description;
        /*
        $fair->reserve_time_type
        $fair->reserve_time_1_hour
        $fair->reserve_time_1_minute
        $fair->reserve_time_2_hour
        $fair->reserve_time_2_minute
        $fair->reserve_time_3_hour
        $fair->reserve_time_3_minute
        $fair->reserve_time_4_hour
        $fair->reserve_time_4_minute
        $fair->reserve_time_5_hour
        $fair->reserve_time_5_minute
        $fair->reserve_time_begin_hour
        $fair->reserve_time_begin_minute
        $fair->reserve_time_end_hour
        $fair->reserve_time_end_minute
        */
        $needTime = ($this->end_h * 60 + $this->end_m) - ($this->start_h * 60 + $this->start_m);
        $needH = (int)$needTime / 60;
        $needM = $needTime - $needH*60;
        if($needM !== 0) {
            if($needM < 30) {
                $needM = 30;
            } else {
                $needM = 0;
                $needH++;
            }
        }
        $fair->time_needed_hour = $needH;
        $fair->time_needed_minute = $needM; 
        /*
        $fair->fee
         */
        $fair->reserve_period_limit = $this->reserve_net_day;
        $fair->parking_explain = $this->parking;
        $fair->is_recommend = self::FLG_OFF;
        return $fair;
    }
    
    public function convertZexy()
    {
        $fair = new FairZexy();
        $fair->fair_id = $this->id;
        $fair->real_time_yoyaku_flg = self::FLG_OFF;
        $fair->fair_start_hour = $this->start_h;
        $fair->fair_start_minute = $this->start_m;
        $fair->fair_end_hour = $this->end_h; 
        $fair->fair_end_minute = $this->end_m;
        $fair->required_minute = ($this->end_h * 60 + $this->end_m) - ($this->start_h * 60 + $this->start_m);
        $fair->secret_flg = self::FLG_OFF;
        $fair->head_fair_flg = self::FLG_OFF;
        $fair->fair_nm = $this->fair_name;
        $fair->main_catch = $this->description;
        /*
        $fair->tour_flg
        $fair->tour_start_hour_1
        $fair->tour_start_minute_1
        $fair->tour_end_hour_1
        $fair->tour_end_minute_1
        $fair->tour_start_hour_2
        $fair->tour_start_minute_2
        $fair->tour_end_hour_2
        $fair->tour_end_minute_2
        $fair->tour_start_hour_3
        $fair->tour_start_minute_3
        $fair->tour_end_hour_3
        $fair->tour_end_minute_3
        $fair->tour_start_hour_4
        $fair->tour_start_minute_4
        $fair->tour_end_hour_4
        $fair->tour_end_minute_4
        $fair->tour_start_hour_5
        $fair->tour_start_minute_5
        $fair->tour_end_hour_5
        $fair->tour_end_minute_5
        $fair->pack_yoyaku_flg
        $fair->pack_yoyaku_kbn
        $fair->pack_yoyaku_unit_kbn
        $fair->pack_yoyaku_uketsuke_cnt
        $fair->fair_perk_naiyo
        $fair->fair_perk_period
        $fair->fair_perk_remarks
        $fair->free_config_question
        $fair->free_config_answer_must_flg
        */
        $fair->input_address = $this->address;
        $fair->parking = $this->parking;
        $fair->target_person = $this->target;
        $fair->etc = $this->other_description;
        $fair->tel_1_1 = $this->tel1_1;
        $fair->tel_2_1 = $this->tel1_2;
        $fair->tel_3_1 = $this->tel1_3;
        $fair->tel_shubetsu_kbn_1 = $this->tel1_syubetsu;
        $fair->tel_tanto_nm_1 = $this->tel1_tanto;
        $fair->tel_1_2 = $this->tel2_1;
        $fair->tel_2_2 = $this->tel2_2;
        $fair->tel_3_2 = $this->tel2_3;
        $fair->tel_shubetsu_kbn_2 = $this->tel2_syubetsu;
        $fair->tel_tanto_nm_2 = $this->tel2_tanto;
        $fair->toiawase = $this->inquery_time;
        $fair->tanto = $this->inquery_name;
        if($this->reserve === self::RESERVE_TEL_ONLY) {
            $fair->yoyaku_uketsuke_how_kbn = FairZexy::YOYAKU_KBN_TEL_ONLY;
        } else {
            $fair->yoyaku_uketsuke_how_kbn = FairZexy::YOYAKU_KBN_DOUBLE;
        }
        $fair->yoyaku_uketsuke_possible_nissu_net = $this->reserve_net_day;
        $fair->yoyaku_uketsuke_end_time_net = $this->reserve_net_time;
        $fair->yoyaku_uketsuke_possible_nissu_tel = $this->reserve_tel_day;
        $fair->request_change_config_kbn = $this->reserve_tel_time;
        $fair->request_change_rem_frame_cnt = 0;
        $fair->keisai_start_date = date('Y-m-d H:i:s',$this->post_start);
        $fair->keisai_end_date = date('Y-m-d H:i:s',$this->post_end);
        return $fair;
    }
}
