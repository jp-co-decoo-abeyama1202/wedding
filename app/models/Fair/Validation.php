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
    
    public static $pageKeys = array(
        1 => array(
            'flg_gnavi',
            'flg_mwed',
            'flg_mynavi',
            'flg_park',
            'flg_rakuten',
            'flg_sugukon',
            'flg_zexy',
        ),
        2 => array(
            'fair_name',
            'description',
        ),
        3 => array(
            'content_id_1',
            'content_title_1',
            'content_shoyo_h_1',
            'content_shoyo_m_1',
            'content_description_1',
            'content_reserve_1',
            'content_price_flg_1',
            'content_price_1',
            'content_stock_1',
            'content_id_2',
            'content_title_2',
            'content_shoyo_h_2',
            'content_shoyo_m_2',
            'content_description_2',
            'content_reserve_2',
            'content_price_flg_2',
            'content_price_2',
            'content_stock_2',
            'content_id_3',
            'content_title_3',
            'content_shoyo_h_3',
            'content_shoyo_m_3',
            'content_description_3',
            'content_reserve_3',
            'content_price_flg_3',
            'content_price_3',
            'content_stock_3',
            'content_id_4',
            'content_title_4',
            'content_shoyo_h_4',
            'content_shoyo_m_4',
            'content_description_4',
            'content_reserve_4',
            'content_price_flg_4',
            'content_price_4',
            'content_stock_4',
            'content_id_5',
            'content_title_5',
            'content_shoyo_h_5',
            'content_shoyo_m_5',
            'content_description_5',
            'content_reserve_5',
            'content_price_flg_5',
            'content_price_5',
            'content_stock_5',
            'content_id_6',
            'content_title_6',
            'content_shoyo_h_6',
            'content_shoyo_m_6',
            'content_description_6',
            'content_reserve_6',
            'content_price_flg_6',
            'content_price_6',
            'content_stock_6',
            'content_id_7',
            'content_title_7',
            'content_shoyo_h_7',
            'content_shoyo_m_7',
            'content_description_7',
            'content_reserve_7',
            'content_price_flg_7',
            'content_price_7',
            'content_stock_7',
            'content_id_8',
            'content_title_8',
            'content_shoyo_h_8',
            'content_shoyo_m_8',
            'content_description_8',
            'content_reserve_8',
            'content_price_flg_8',
            'content_price_8',
            'content_stock_8',
            'shoyo_sum_h',
            'shoyo_sum_m',
            'tour_count',
            'tour_1_start_h',
            'tour_1_start_m',
            'tour_1_end_h',
            'tour_1_end_m',
            'tour_2_start_h',
            'tour_2_start_m',
            'tour_2_end_h',
            'tour_2_end_m',
            'tour_3_start_h',
            'tour_3_start_m',
            'tour_3_end_h',
            'tour_3_end_m',
            'tour_4_start_h',
            'tour_4_start_m',
            'tour_4_end_h',
            'tour_4_end_m',
            'tour_5_start_h',
            'tour_5_start_m',
            'tour_5_end_h',
            'tour_5_end_m',
        ),
        4 => array(
            'image_id_1',
            'image_id_2',
            'image_id_3',
            'image_id_4',
            'image_caption_4',
            'image_id_5',
            'image_id_6',
            'image_caption_6',
            'image_id_7',
        ),
        5 => array(
            'zexy_tokuten_flg',
            'zexy_tokuten_description',
            'zexy_tokuten_remarks',
            'zexy_tokuten_period',
            'mwed_tokuten_flg',
            'mwed_tokuten_description',
            'park_tokuten_flg',
            'park_tokuten_description',
            'rakuten_tokuten_flg',
            'mynavi_tokuten_flg',
            'mynavi_tokuten_description',
            'gnavi_tokuten_flg',
        ),
        6 => array(
            'zexy_real_time_yoyaku_flg',
            'zexy_request_change_config_kbn',
            'zexy_request_change_rem_frame_cnt',
            'reserve_net_day',
            'reserve_net_time',
            'reserve_tel',
            'reserve_tel_day',
            'reserve_tel_time',
            'reserve',
        ),
        7 => array(
            'holl_id',
            'address',
            'address_note',
            'parking',
            'tel1_1',
            'tel1_2',
            'tel1_3',
            'tel1_syubetsu',
            'tel1_tanto',
            'tel2_1',
            'tel2_2',
            'tel2_3',
            'tel2_syubetsu',
            'tel2_tanto',
            'inquery_time',
            'inquery_support_name',
        ),
        8 => array(
            'zexy_secret_flg',
            'zexy_head_fair_flg',
            'zexy_free_config_question',
            'zexy_free_config_answer_must_flg',
            'zexy_pack_flg',
            'zexy_pack_yoyaku_kbn',
            'zexy_pack_yoyaku_unit_kbn',
            'zexy_pack_yoyaku_uketsuke_cnt',
            'sugukon_is_recommend',
            'mynavi_target_note',
            'mynavi_etc_note',
            'gnavi_freeword_search',
            'gnavi_fair_catch',
            'gnavi_fair_point',
            'gnavi_gnavi_limit_flg',
            'gnavi_just_one_ok_flg',
            'gnavi_estimate_bid_flg',
            'gnavi_customer_count',
        )
    );
    
    public static $pageMessages = array(
        3 => array(
            'content_price_1.required_if' => ":otherに有料を指定した場合、:attributeは必須です。",
            'content_price_2.required_if' => ":otherに有料を指定した場合、:attributeは必須です。",
            'content_price_3.required_if' => ":otherに有料を指定した場合、:attributeは必須です。",
            'content_price_4.required_if' => ":otherに有料を指定した場合、:attributeは必須です。",
            'content_price_5.required_if' => ":otherに有料を指定した場合、:attributeは必須です。",
            'content_price_6.required_if' => ":otherに有料を指定した場合、:attributeは必須です。",
            'content_price_7.required_if' => ":otherに有料を指定した場合、:attributeは必須です。",
            'content_price_8.required_if' => ":otherに有料を指定した場合、:attributeは必須です。",
        ),
        4 => array(
            'image_id_4.required_if' => 'ぐるナビを選択した場合、:attributeは必須です。',
            'image_id_6.required_if' => 'すぐ婚を選択した場合、:attributeは必須です。',
        ),
        5 => array(
            'zexy_tokuten_description.required_if' => ":otherがONである場合、:attributeは必須です。",
            'zexy_tokuten_remarks.required_if' => ":otherがONである場合、:attributeは必須です。",
            'zexy_tokuten_period.required_if' => ":otherがONである場合、:attributeは必須です。",
            'mwed_tokuten_description.required_if' => ":otherがONである場合、:attributeは必須です。",
            'park_tokuten_description.required_if' => ":otherがONである場合、:attributeは必須です。",
            'mynavi_tokuten_description.required_if' => ":otherがONである場合、:attributeは必須です。",
        ),
        6 => array(
            'reserve_net.required_if' => ':otherがONの場合、:attributeはONである必要があります。',
            'reserve_tel.required_if' => ':otherがONの場合、:attributeはONである必要があります。',
        ),
    );
            
    public static $attrNames = array(
        'flg_gnavi' => '使用サイト選択：ぐるナビ',
        'flg_mwed' => '使用サイト選択：みんなの',
        'flg_mynavi' => '使用サイト選択：マイナビ',
        'flg_park' => '使用サイト選択：パーク',
        'flg_rakuten' => '使用サイト選択：楽天',
        'flg_sugukon' => '使用サイト選択：すぐ婚',
        'flg_zexy' => '使用サイト選択：ゼクシィ',
        'fair_name' => 'フェア名称',
        'description' => '全体説明文',
        'content_id_1' => 'フェア内容1：コンテンツ', 
        'content_title_1' => 'フェア内容1：タイトル', 
        'content_shoyo_h_1' => 'フェア内容1：所用時間', 
        'content_shoyo_m_1' => 'フェア内容1：所用時間', 
        'content_description_1' => 'フェア内容1：フェア内容説明文', 
        'content_reserve_1' => 'フェア内容1：予約有無', 
        'content_price_flg_1' => 'フェア内容1：有料/無料', 
        'content_price_1' => 'フェア内容1：料金', 
        'content_stock_1' => 'フェア内容1：個別フェア在庫数', 
        'content_id_2' => 'フェア内容2：コンテンツ', 
        'content_title_2' => 'フェア内容2：タイトル', 
        'content_shoyo_h_2' => 'フェア内容2：所用時間', 
        'content_shoyo_m_2' => 'フェア内容2：所用時間', 
        'content_description_2' => 'フェア内容2：フェア内容説明文', 
        'content_reserve_2' => 'フェア内容2：予約有無', 
        'content_price_flg_2' => 'フェア内容2：有料/無料', 
        'content_price_2' => 'フェア内容2：料金', 
        'content_stock_2' => 'フェア内容2：個別フェア在庫数', 
        'content_id_3' => 'フェア内容3：コンテンツ', 
        'content_title_3' => 'フェア内容3：タイトル', 
        'content_shoyo_h_3' => 'フェア内容3：所用時間', 
        'content_shoyo_m_3' => 'フェア内容3：所用時間', 
        'content_description_3' => 'フェア内容3：フェア内容説明文', 
        'content_reserve_3' => 'フェア内容3：予約有無', 
        'content_price_flg_3' => 'フェア内容3：有料/無料', 
        'content_price_3' => 'フェア内容3：料金', 
        'content_stock_3' => 'フェア内容3：個別フェア在庫数', 
        'content_id_4' => 'フェア内容4：コンテンツ', 
        'content_title_4' => 'フェア内容4：タイトル', 
        'content_shoyo_h_4' => 'フェア内容4：所用時間', 
        'content_shoyo_m_4' => 'フェア内容4：所用時間', 
        'content_description_4' => 'フェア内容4：フェア内容説明文', 
        'content_reserve_4' => 'フェア内容4：予約有無', 
        'content_price_flg_4' => 'フェア内容4：有料/無料', 
        'content_price_4' => 'フェア内容4：料金', 
        'content_stock_4' => 'フェア内容4：個別フェア在庫数', 
        'content_id_5' => 'フェア内容5：コンテンツ', 
        'content_title_5' => 'フェア内容5：タイトル', 
        'content_shoyo_h_5' => 'フェア内容5：所用時間', 
        'content_shoyo_m_5' => 'フェア内容5：所用時間', 
        'content_description_5' => 'フェア内容5：フェア内容説明文', 
        'content_reserve_5' => 'フェア内容5：予約有無', 
        'content_price_flg_5' => 'フェア内容5：有料/無料', 
        'content_price_5' => 'フェア内容5：料金', 
        'content_stock_5' => 'フェア内容5：個別フェア在庫数', 
        'content_id_6' => 'フェア内容6：コンテンツ', 
        'content_title_6' => 'フェア内容6：タイトル', 
        'content_shoyo_h_6' => 'フェア内容6：所用時間', 
        'content_shoyo_m_6' => 'フェア内容6：所用時間', 
        'content_description_6' => 'フェア内容6：フェア内容説明文', 
        'content_reserve_6' => 'フェア内容6：予約有無', 
        'content_price_flg_6' => 'フェア内容6：有料/無料', 
        'content_price_6' => 'フェア内容6：料金', 
        'content_stock_6' => 'フェア内容6：個別フェア在庫数', 
        'content_id_7' => 'フェア内容7：コンテンツ', 
        'content_title_7' => 'フェア内容7：タイトル', 
        'content_shoyo_h_7' => 'フェア内容7：所用時間', 
        'content_shoyo_m_7' => 'フェア内容7：所用時間', 
        'content_description_7' => 'フェア内容7：フェア内容説明文', 
        'content_reserve_7' => 'フェア内容7：予約有無', 
        'content_price_flg_7' => 'フェア内容7：有料/無料', 
        'content_price_7' => 'フェア内容7：料金', 
        'content_stock_7' => 'フェア内容7：個別フェア在庫数', 
        'content_id_8' => 'フェア内容8：コンテンツ', 
        'content_title_8' => 'フェア内容8：タイトル', 
        'content_shoyo_h_8' => 'フェア内容8：所用時間', 
        'content_shoyo_m_8' => 'フェア内容8：所用時間', 
        'content_description_8' => 'フェア内容8：フェア内容説明文', 
        'content_reserve_8' => 'フェア内容8：予約有無', 
        'content_price_flg_8' => 'フェア内容8：有料/無料', 
        'content_price_8' => 'フェア内容8：料金', 
        'content_stock_8' => 'フェア内容8：個別フェア在庫数', 
        'shoyo_sum_h' => '所用時間',
        'shoyo_sum_m' => '所用時間',
        'tour_count' => '部制選択',
        'tour_1_start_h' => '第1部：開始時間',
        'tour_1_start_m' => '第1部：開始時間',
        'tour_1_end_h' => '第1部：終了時間',
        'tour_1_end_m' => '第1部：終了時間',
        'tour_2_start_h' => '第2部：開始時間',
        'tour_2_start_m' => '第2部：開始時間',
        'tour_2_end_h' => '第2部：終了時間',
        'tour_2_end_m' => '第2部：終了時間',
        'tour_3_start_h' => '第3部：開始時間',
        'tour_3_start_m' => '第3部：開始時間',
        'tour_3_end_h' => '第3部：終了時間',
        'tour_3_end_m' => '第3部：終了時間',
        'tour_4_start_h' => '第4部：開始時間',
        'tour_4_start_m' => '第4部：開始時間',
        'tour_4_end_h' => '第4部：終了時間',
        'tour_4_end_m' => '第4部：終了時間',
        'tour_5_start_h' => '第5部：開始時間',
        'tour_5_start_m' => '第5部：開始時間',
        'tour_5_end_h' => '第5部：終了時間',
        'tour_5_end_m' => '第5部：終了時間',
        'image_id_1' => '画像：みんなの',
        'image_id_2' => '画像：ゼクシィ',
        'image_id_3' => '画像：パーク',
        'image_id_4' => '画像：ぐるナビ',
        'image_caption_4' => '画像説明：すぐ婚',
        'image_id_5' => '画像：楽天',
        'image_id_6' => '画像：すぐ婚',
        'image_caption_6' => '画像説明：すぐ婚',
        'image_id_7' => '画像：マイナビ',
        'zexy_tokuten_flg' => 'ゼクシィ特典：特典あり',
        'zexy_tokuten_description' => 'ゼクシィ特典：特典内容説明',
        'zexy_tokuten_remarks' => 'ゼクシィ特典：備考',
        'zexy_tokuten_period' => 'ゼクシィ特典：期間',
        'mwed_tokuten_flg' => 'みんなの特典：特典あり',
        'mwed_tokuten_description' => 'みんなの特典：特典内容説明',
        'park_tokuten_flg' => 'パーク特典：特典あり',
        'park_tokuten_description' => 'パーク特典：特典内容説明',
        'rakuten_tokuten_flg' => '楽天特典：特典あり',
        'mynavi_tokuten_flg' => 'マイナビ特典：特典あり',
        'mynavi_tokuten_description' => 'マイナビ特典：特典内容説明',
        'gnavi_tokuten_flg' => 'ぐるナビ特典：特典あり',
        'zexy_real_time_yoyaku_flg' => 'リアルタイム受付設定',
        'zexy_request_change_config_kbn' => '予約切替',
        'zexy_request_change_rem_frame_cnt' => '予約切替：切替枠数',
        'reserve_net' => 'オンライン受付：設定する',
        'reserve_net_day' => 'オンライン受付：掲載期間：～日まで',
        'reserve_net_time' => 'オンライン予約受付：掲載期間：～時まで',
        'reserve_tel' => '電話受付：設定する',
        'reserve_tel_day' => '電話受付：掲載期間：～日まで',
        'reserve_tel_time' => '電話受付：掲載期間：～時まで',
        'reserve' => '優先度',
        'holl_id' => '開催会場',
        'address' => '所在地',
        'address_note' => '所在地備考',
        'parking' => '駐車場',
        'tel1_1' => '電話番号1',
        'tel1_2' => '電話番号1',
        'tel1_3' => '電話番号1',
        'tel1_syubetsu' => '電話番号1：種別',
        'tel1_tanto' => '電話番号1：担当窓口',
        'tel2_1' => '電話番号2',
        'tel2_2' => '電話番号2',
        'tel2_3' => '電話番号2',
        'tel2_syubetsu' => '電話番号2：種別',
        'tel2_tanto' => '電話番号2：担当窓口',
        'inquery_time' => '問合せ：受付時間',
        'inquery_support_name' => '問合せ：担当者',
        'target_note' => '共通：対象者',
        'etc_note' => '共通：その他',
        'zexy_secret_flg' => 'ゼクシィ：フェアの分類設定',
        'zexy_head_fair_flg' => 'ゼクシィ：代表フェアにする',
        'zexy_free_config_question' => 'ゼクシィ：質問項目',
        'zexy_free_config_answer_must_flg' => 'ゼクシィ：質問必須回答にする',
        'zexy_pack_flg' => 'ゼクシィ：まとめて予約受付にする',
        'zexy_pack_yoyaku_kbn' => 'ゼクシィ：まとめて予約受付：予約区分',
        'zexy_pack_yoyaku_unit_kbn' => 'ゼクシィ：まとめて予約受付：単位',
        'zexy_pack_yoyaku_uketsuke_cnt' => 'ゼクシィ：まとめて予約受付：zebra予約受付',
        'sugukon_is_recommend' => 'すぐ婚：おススメフェアとして登録する',
        'gnavi_freeword_search' => 'ぐるナビ：検索キーワード設定',
        'gnavi_fair_catch' => 'ぐるナビ：キャッチコピー',
        'gnavi_fair_point' => 'ぐるナビ：ココに注目',
        'gnavi_gnavi_limit_flg' => 'ぐるナビ：ぐるナビ限定',
        'gnavi_just_one_ok_flg' => 'ぐるナビ：おひとり様参加OK',
        'gnavi_estimate_bid_flg' => 'ぐるナビ：見積書のご案内',
        'gnavi_customer_count' => 'ぐるナビ：定員',
    );
    
    public static function getAllRules(){
        $min = array();
        $min5 = array();
        for($i=0;$i<60;++$i) {
            $min[] = $i;
            if($i%5===0) {
                $min5[] = $i;
            }
        }
        $min = implode(',',$min);
        $min5 = implode(',',$min5);
        /* ページ1:初期選択 */
        $v1 = array(
            'flg_gnavi' => array('numeric','in:0,1'),
            'flg_mwed' => array('numeric','in:0,1'),
            'flg_mynavi' => array('numeric','in:0,1'),
            'flg_park' => array('numeric','in:0,1'),
            'flg_rakuten' => array('numeric','in:0,1'),
            'flg_sugukon' => array('numeric','in:0,1'),
            'flg_zexy' => array('numeric','in:0,1'),
        );
        /* ページ2:基本情報入力 */
        $v2 = array(
            'fair_name' => array('required','mb_max:30'),
            'description' => array('required','mb_max:500'),
        );
        /* ページ3:基本フェア構成作成 */
        $v3 = array(
            'shoyo_sum_h' => array('numeric','between:0,23'),
            'shoyo_sum_m' => array('numeric','in:'.$min5),
            'tour_count' => array('required','numeric','between:0,5'),
        );
        for($i=1;$i<=8;$i++) {
            if($i<=5) {
                $keys = array(
                    'h' => array(
                        'tour_'.$i.'_start_h',
                        'tour_'.$i.'_end_h'
                    ),
                    'm' => array(
                        'tour_'.$i.'_start_m',
                        'tour_'.$i.'_end_m'
                    )
                );
                foreach($keys['h'] as $key) {
                    $v3[$key] = array('numeric','between:0,23');
                    for($j=5;$j>=$i;$j--) {
                        $v3[$key][] = 'required_if:tour_count,'.$j;
                    }
                }
                foreach($keys['m'] as $key) {
                    $v3[$key] = array('numeric','in:'.$min5);
                    for($j=5;$j>=$i;$j--) {
                        $v3[$key][] = 'required_if:tour_count,'.$j;
                    }
                }
            }
            $v3['content_id_'.$i] = array('numeric');
            $v3['content_title_'.$i] = array('required_with:content_id_'.$i,'mb_max:30');
            $v3['content_shoyo_h_'.$i] = array('required_with:content_id_'.$i,'numeric','between:0,23');
            $v3['content_shoyo_m_'.$i] = array('required_with:content_id_'.$i,'numeric','in:'.$min5);
            $v3['content_description_'.$i] = array('required_with:content_id_'.$i,'mb_max:100');
            $v3['content_reserve_'.$i] = array('required_with:content_id_'.$i,'in:'.implode(',',array_keys(FairContent::$reserveList)));
            $v3['content_price_flg_'.$i] = array('required_with:content_id_'.$i,'in:'.implode(',',array_keys(FairContent::$priceFlagList)));
            $v3['content_price_'.$i] = array('required_if:content_price_flg_'.$i.','.FairContent::PRICE_FLG_ON,'mb_max:100');
            $v3['content_stock_'.$i] = array('numeric','between:0,999');
        }
        /* ページ4:画像選択 */
        $v4 = array(
            'image_id_1' => array('numeric'),
            'image_id_2' => array('numeric'),
            'image_id_3' => array('numeric'),
            'image_id_4' => array('required_if:flg_gnavi,1','numeric'),
            'image_caption_4' => array('mb_max:30'),
            'image_id_5' => array('numeric'),
            'image_id_6' => array('required_if:flg_sugukon,1','numeric'),
            'image_caption_6' => array('mb_max:14'),
            'image_id_7' => array('numeric'),
        );
        /* ページ5:特典入力 */
        $v5 = array(
            'zexy_tokuten_flg' => array('numeric','in:0,1'),
            'zexy_tokuten_description' => array('required_if:zexy_tokuten_flg,1','mb_max:50'),
            'zexy_tokuten_remarks' => array('required_if:zexy_tokuten_flg,1','mb_max:50'),
            'zexy_tokuten_period' => array('required_if:zexy_tokuten_flg,1','mb_max:50'),
            'mwed_tokuten_flg' => array('numeric','in:0,1'),
            'mwed_tokuten_description' => array('required_if:mwed_tokuten_flg,1','mb_max:50'),
            'park_tokuten_flg' => array('numeric','in:0,1'),
            'park_tokuten_description' => array('required_if:park_tokuten_flg,1','mb_max:200'),
            'rakuten_tokuten_flg' => array('numeric','in:0,1'),
            'mynavi_tokuten_flg' => array('numeric','in:0,1'),
            'mynavi_tokuten_description' => array('required_if:mynavi_tokuten_flg,1','mb_max:500'),
            'gnavi_tokuten_flg' => array('numeric','in:0,1'),
        );
        /* ページ6:掲載期間及び受付方法 */
        $v6 = array(
            'zexy_real_time_yoyaku_flg' => array('numeric','in:0,1'),
            'zexy_request_change_config_kbn' => array('numeric','in:'.implode(',',array_keys(FairZexy::$requestChangeConfigKbnList))),
            'zexy_request_change_rem_frame_cnt' => array('numeric','between:0,99999'),
            'reserve_net' => array('required_if:flg_mwed,1','required_if:flg_sugukon,1','numeric','in:1'),
            'reserve_net_day' => array('required_if:reserve_net,1','numeric','in:'.implode(',',array_keys(Fair::$reserveDayList))),
            'reserve_net_time' => array('required_if:reserve_net,1','numeric','in:'.implode(',',array_keys(Fair::$reserveTimeList))),
            'reserve_tel' => array('required_if:flg_zexy,1','required_if:flg_sugukon,1','numeric','in:1'),
            'reserve_tel_day' => array('required_if:reserve_net,1','numeric','in:'.implode(',',array_keys(Fair::$reserveDayList))),
            'reserve_tel_time' => array('required_if:reserve_net,1','numeric','in:'.implode(',',array_keys(Fair::$reserveTimeList))),
            'reserve' => array('required','numeric','in:'.implode(',',array_keys(Fair::$reserveList))),
        );
        /* ページ7:アクセスデータ */    
        $v7 = array(
            'holl_id' => array('in:'.implode(',',array(Fair::HOLL_PLACE,Fair::HOLL_OTHER))),
            'address' => array('required','mb_max:100'),
            'address_note' => array('mb_max:500'),
            'parking' => array('required','mb_max:50'),
            'tel1_1' => array('required','mb_max:4'),
            'tel1_2' => array('required','mb_max:4'),
            'tel1_3' => array('required','mb_max:4'),
            'tel1_syubetsu' => array('required','in:'.implode(',',array(Fair::TEL_SYUBETSU_NORMAL,Fair::TEL_SYUBETSU_NOPRICE))),
            'tel1_tanto' => array('required','mb_max:50'),
            'tel2_1' => array('required_with:tel2_2,tel2_3','mb_max:4'),
            'tel2_2' => array('required_with:tel2_1,tel2_2','mb_max:4'),
            'tel2_3' => array('required_with:tel2_1,tel2_2','mb_max:4'),
            'tel2_syubetsu' => array('required_with:tel2_1,tel2_2,tel2_3','in:'.implode(',',array(Fair::TEL_SYUBETSU_NORMAL,Fair::TEL_SYUBETSU_NOPRICE,Fair::TEL_SYUBETSU_FAX))),
            'tel2_tanto' => array('required_with:tel2_1,tel2_2,tel2_3','mb_max:50'),
            'inquery_time' => array('required','mb_max:50'),
            'inquery_support_name' => array('required','mb_max:50'),
        );
        /* ページ8:個別設定項目 */
        $v8 = array(
            'target_note' => array('mb_max:100'),
            'etc_note' => array('mb_max:100'),
            'zexy_secret_flg' => array('required','in:'.implode(',',array(Fair::FLG_OFF,Fair::FLG_ON))),
            'zexy_head_fair_flg' => array('in'.implode(',',array(Fair::FLG_OFF,Fair::FLG_ON))),
            'zexy_free_config_question' => array('required_if:zexy_free_config_answer_must_flg,1','mb_max:200'),
            'zexy_free_config_answer_must_flg' => array('in:0,1'),
            'zexy_pack_flg' => array('in:0,1'),
            'zexy_pack_yoyaku_kbn' => array('required_if:zexy_packs,1','in:'.implode(',',array_keys(FairZexy::$packYoyakuKbnList))),
            'zexy_pack_yoyaku_unit_kbn' => array('required_if:zexy_packs,1','in:'.implode(',',array_keys(FairZexy::$packYoyakuUnitKbnList))),
            'zexy_pack_yoyaku_uketsuke_cnt' => array('mb_max:5'),
            'sugukon_is_recommend' => array('in:0,1'),
            'gnavi_freeword_search' => array('mb_max:512'),
            'gnavi_fair_catch' => array('mb_max:50'),
            'gnavi_fair_point' => array('mb_max:30'),
            'gnavi_gnavi_limit_flg' => array('in:0,1'),
            'gnavi_just_one_ok_flg' => array('in:0,1'),
            'gnavi_estimate_bid_flg' => array('in:0,1'),
            'gnavi_customer_count' => array('numeric','between:0,999'),
        );
        $v = $v1 + $v2 + $v3 + $v4 + $v5 + $v6 + $v7 + $v8;
        return $v;
    }
    
    protected static function getPageRules($inputs,$page) {
        $allRules = self::getAllRules();
        $keys = isset(self::$pageKeys[$page]) ? self::$pageKeys[$page] : array();
        if(!$keys) {
            return array();
        }
        $rules = array_only($allRules,$keys);
        //入力内容による個別修正
        switch($page) {
            case 2:
                if(isset($inputs['flg_zexy'])&&$inputs['flg_zexy']==Fair::FLG_ON) {
                    $rules['description'] = array('required','mb_max:100');
                } else if(isset($inputs['flg_park'])&&$inputs['flg_park']==Fair::FLG_ON) {
                    $rules['description'] = array('required','mb_max:115');
                } else if(isset($inputs['flg_rakuten'])&&$inputs['flg_rakuten']==Fair::FLG_ON) {
                    $rules['description'] = array('required','mb_max:200');
                } else if(isset($inputs['flg_gnavi'])&&$inputs['flg_gnavi']==Fair::FLG_ON) {
                    $rules['description'] = array('required','mb_max:250');
                } else if(isset($inputs['flg_sugukon'])&&$inputs['flg_sugukon']==Fair::FLG_ON) {
                    $rules['description'] = array('required','mb_max:300');
                } else if(isset($inputs['flg_mwed'])&&$inputs['flg_mwed']==Fair::FLG_ON) {
                    $rules['description'] = array('required','mb_max:300');
                }
                break;
        }
        return $rules;
    }
    
    public static function pageValidation($page)
    {
        $keys = isset(self::$pageKeys[$page]) ? self::$pageKeys[$page] : array();
        if(!$keys) {
            return array(false,'予期せぬエラーが発生しました');
        }
        $inputs = Input::all();
        $rules = self::getPageRules($inputs,$page);
        if(!$rules) {
            return array(false,'予期せぬエラーが発生しました');
        }
        $messages = isset(self::$pageMessages[$page]) ? self::$pageMessages[$page] : array();
        if($messages) {
            $validator = Validator::make($inputs,$rules,$messages);
        } else {
            $validator = Validator::make($inputs,$rules);
        }
        //通常Validate
        $validator->setAttributeNames(self::$attrNames);
        if ($validator->fails()) {
            return array(false,json_decode($validator->messages(),true));
        }
        //入力内容による個別判定
        switch($page) {
            case 1:
                $check = false;
                foreach(Input::only($keys) as $key => $value) {
                    if(!is_null($value)) {
                        $check = true;
                        break;
                    }
                }
                if(!$check) {
                    return array(false,'使用サイトを一つ以上選択する必要があります。');
                }
                break;
            case 3:
                $messages = array();
                $count = Input::get('tour_count');
                $times = array();
                //部制の時間設定チェック
                for($i=1;$i<=$count;++$i) {
                    $start = Input::get('tour_'.$i.'_start_h') * 60 + Input::get('tour_'.$i.'_start_m');
                    $end = Input::get('tour_'.$i.'_end_h') * 60 + Input::get('tour_'.$i.'_end_m');
                    if($start >= $end) {
                        $messages[] = '第'.$i.'部の終了時間は開始時間より後である必要があります。';
                    }
                    $times[$i] = $end - $start;
                }
                $contents = array();
                $sumTime = 0;
                //フェア内容の合計時間チェック
                for($i=1;$i<=8;++$i) {
                    if(Input::get('content_id_'.$i)) {
                        $contents[] = $i;
                        $sumTime += Input::get('content_shoyo_h_'.$i) * 60 + Input::get('content_shoyo_m_'.$i);
                    }
                }
                if(!$contents) {
                    $messages[] = 'フェア内容は1件以上設定する必要があります。';
                } else {
                    $h = (int)($sumTime / 60);
                    $m = $sumTime - ($h*60);
                    if($h > 23) {
                        $messages[] = 'フェア内容の所要時間の合計が24時間未満である必要があります。';
                    }
                    if(Input::get('shoyo_sum_h')!=$h || Input::get('shoyo_sum_m')!=$m) {
                        $messages[] = 'フェア内容の所要時間の合計と自動計算の所要時間は一致している必要があります。';
                    }
                    foreach($times as $key => $time) {
                        if($sumTime != $time) {
                            $messages[] = '第'.$key.'部の設定時間は所要時間と一致している必要があります。';
                        }
                    }
                }
                if($messages) {
                    return array(false,array($messages));
                }
                break;
            case 6:
                $messages = array();
                //必須設定
                if(Input::get('flg_rakuten')==Fair::FLG_ON||Input::get('flg_mynavi')==Fair::FLG_ON||Input::get('flg_gnavi')==Fair::FLG_ON) {
                    if(!Input::get('reserve_net')&&!Input::get('reserve_tel')) {
                        $messages[] = 'オンライン受付か電話受付のどちらかを選択する必要があります。';
                    }
                }
                if($messages) {
                    return array(false,array($messages));
                }
                break;
        }
        return array(true,'');
    }
}
