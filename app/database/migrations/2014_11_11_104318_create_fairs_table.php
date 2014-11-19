<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFairsTable extends Migration {
        
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            // フェアテンプレート
            $schema = Schema::connection('migration');
            $schema->create('fairs', function(Blueprint $table)
            {
                $table->increments('id');
                $table->tinyInteger('state')->unsigned()->default(Fair::STATE_DRAFT);
                /* ページ1 */
                $table->tinyInteger('flg_gnavi')->unsigned()->default(Fair::FLG_OFF);
                $table->tinyInteger('flg_mwed')->unsigned()->default(Fair::FLG_OFF);
                $table->tinyInteger('flg_mynavi')->unsigned()->default(Fair::FLG_OFF);
                $table->tinyInteger('flg_park')->unsigned()->default(Fair::FLG_OFF);
                $table->tinyInteger('flg_rakuten')->unsigned()->default(Fair::FLG_OFF);
                $table->tinyInteger('flg_sugukon')->unsigned()->default(Fair::FLG_OFF);
                $table->tinyInteger('flg_zexy')->unsigned()->default(Fair::FLG_OFF);
                /* ページ2 */
                $table->string('fair_name', 30);
                $table->text('description');
                /* ページ3 */
                $table->tinyInteger('shoyo_sum_h')->unsigned();
                $table->tinyInteger('shoyo_sum_m')->unsigned();
                $table->tinyInteger('tour_count')->unsigned();
                for($i=1;$i<=5;$i++) {
                    $table->tinyInteger('tour_'.$i.'_start_h')->unsigned()->nullable();
                    $table->tinyInteger('tour_'.$i.'_start_m')->unsigned()->nullable();
                    $table->tinyInteger('tour_'.$i.'_end_h')->unsigned()->nullable();
                    $table->tinyInteger('tour_'.$i.'_end_m')->unsigned()->nullable();
                }/* ページ4 */
                foreach(Site::$_site_names as $key => $name) {
                    $table->integer('image_id_'.$key)->unsigned()->nullable();
                    if($key === SiteGnavi::SITE_LOGIN_ID) {
                        $table->string('image_caption_'.$key,30)->nullable();
                    }
                    if($key === SiteSugukon::SITE_LOGIN_ID) {
                        $table->string('image_caption_'.$key,14)->nullable();
                    }
                }
                /* ページ5 */
                $table->tinyInteger('zexy_tokuten_flg')->unsigned()->default(Fair::FLG_OFF);
                $table->text('zexy_tokuten_description')->nullable();
                $table->text('zexy_tokuten_remarks')->nullable();
                $table->text('zexy_tokuten_period')->nullable();
                $table->tinyInteger('mwed_tokuten_flg')->unsigned()->default(Fair::FLG_OFF);
                $table->text('mwed_tokuten_description')->nullable();
                $table->tinyInteger('park_tokuten_flg')->unsigned()->default(Fair::FLG_OFF);
                $table->text('park_tokuten_description')->nullable();
                $table->tinyInteger('rakuten_tokuten_flg')->unsigned()->default(Fair::FLG_OFF);
                $table->tinyInteger('mynavi_tokuten_flg')->unsigned()->default(Fair::FLG_OFF);
                $table->text('mynavi_tokuten_description')->nullable();
                $table->tinyInteger('gnavi_tokuten_flg')->unsigned()->default(Fair::FLG_OFF);
                /* ページ6 */
                $table->tinyInteger('zexy_real_time_yoyaku_flg')->unsigned()->default(Fair::FLG_OFF);
                $table->tinyInteger('zexy_request_change_config_kbn')->unsigned()->default(FairZexy::REQUEST_CHANGE_CONFIG_KBN_OFF);
                $table->integer('zexy_request_change_rem_frame_cnt')->unsigned()->nullable();
                $table->tinyInteger('reserve_net')->unsigned()->default(Fair::FLG_OFF);
                $table->tinyInteger('reserve_net_day')->unsigned()->nullable();
                $table->tinyInteger('reserve_net_time')->unsigned()->nullable();
                $table->tinyInteger('reserve_tel')->unsigned()->default(Fair::FLG_OFF);
                $table->tinyInteger('reserve_tel_day')->unsigned()->nullable();
                $table->tinyInteger('reserve_tel_time')->unsigned()->nullable();
                $table->tinyInteger('reserve')->unsigned()->default(Fair::RESERVE_NET_PRIORITY);
                /* ページ7 */
                $table->tinyInteger('holl_id')->unsigned()->default(Fair::HOLL_OTHER);
                $table->text('address')->nullable();
                $table->text('address_note')->nullable();
                $table->text('parking')->nullable();
                $table->string('tel1_1',4)->nullable();
                $table->string('tel1_2',4)->nullable();
                $table->string('tel1_3',4)->nullable();
                $table->tinyInteger('tel1_syubetsu')->unsigned()->nullable();
                $table->string('tel1_tanto',50)->nullable();
                $table->string('tel2_1',4)->nullable();
                $table->string('tel2_2',4)->nullable();
                $table->string('tel2_3',4)->nullable();
                $table->tinyInteger('tel2_syubetsu')->unsigned()->nullable();
                $table->string('tel2_tanto',50)->nullable();
                $table->string('inquery_time',50)->nullable();
                $table->string('inquery_support_name')->nullable();
                /* ページ8 */
                $table->string('target_note',100)->nullable();
                $table->text('etc_note')->nullable();
                $table->tinyInteger('zexy_secret_flg')->unsigned()->default(Fair::FLG_OFF);
                $table->tinyInteger('zexy_head_fair_flg')->unsigned()->default(Fair::FLG_OFF);
                $table->text('zexy_free_config_question')->nullable();
                $table->tinyInteger('zexy_free_config_answer_must_flg')->unsigned()->default(Fair::FLG_OFF);
                $table->tinyInteger('zexy_packs')->unsigned()->default(Fair::FLG_OFF);
                $table->tinyInteger('zexy_pack_yoyaku_kbn')->unsigned()->nullable()->default(FairZexy::PACK_YOYAKU_KBN_PRIORITY);
                $table->tinyInteger('zexy_pack_yoyaku_unit_kbn')->unsigned()->nullable()->default(FairZexy::PACK_YOYAKU_UNIT_KBN_SINGLE);
                $table->integer('zexy_pack_yoyaku_uketsuke_cnt')->unsigned()->nullable()->default(0);
                $table->tinyInteger('sugukon_is_recommend')->unsigned()->default(Fair::FLG_OFF);
                $table->string('gnavi_freeword_search',512)->nullable();
                $table->string('gnavi_fair_catch',50)->nullable();
                $table->string('gnavi_fair_point',30)->nullable();
                $table->tinyInteger('gnavi_gnavi_limit_flg')->unsigned()->default(Fair::FLG_OFF);
                $table->tinyInteger('gnavi_just_one_ok_flg')->unsigned()->default(Fair::FLG_OFF);
                $table->tinyInteger('gnavi_estimate_bid_flg')->unsigned()->default(Fair::FLG_OFF);
                $table->integer('gnavi_customer_count')->unsigned()->nullable();
                $table->timestamps();
                $table->softDeletes();
                
            });
            // フェア内容詳細
            $schema->create('fair_contents', function(Blueprint $table)
            {
                $table->increments('id');
                $table->integer('fair_id')->unsigned();
                $table->integer('content_id')->unsigned();
                $table->string('title',30);
                $table->tinyInteger('shoyo_h')->unsigned();
                $table->tinyInteger('shoyo_m')->unsigned();
                $table->text('description');
                $table->tinyInteger('reserve')->unsigned();
                $table->tinyInteger('price_flg')->unsigned();
                $table->string('price',100);
                $table->integer('stock')->unsigned();
                $table->timestamps();
                
                $table->foreign('fair_id')->references('id')->on('fairs');
            });
            
            $schema->create('fair_dates', function(Blueprint $table) {
                $table->increments('id');
                $table->tinyInteger('state')->unsigned()->default(FairDate::STATE_REGIST);
                $table->integer('fair_id')->unsigned();
                $table->date('fair_date');
                $table->integer('gnavi_id')->unsigned()->nullable();
                $table->integer('mwed_id')->unsigned()->nullable();
                $table->integer('mynavi_id')->unsigned()->nullable();
                $table->integer('park_id')->unsigned()->nullable();
                $table->integer('rakuten_id')->unsigned()->nullable();
                $table->integer('sugukon_id')->unsigned()->nullable();
                $table->integer('zexy_id')->unsigned()->nullable();
                $table->timestamps();
                $table->foreign('fair_id')->references('id')->on('fairs');
            });
            
            // ぐるナビ
            $schema->create('fair_gnavis', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('fair_id')->unsigned();
                $table->string('fair_title',35);
                $table->tinyInteger('fair_time_start_h')->unsigned();
                $table->tinyInteger('fair_time_start_m')->unsigned();
                $table->tinyInteger('fair_time_end_h')->unsigned();
                $table->tinyInteger('fair_time_end_m')->unsigned();
                $table->tinyInteger('registration_flg')->unsigned()->nullable();
                $table->tinyInteger('visible_end_day')->unsigned();
                $table->integer('image_id')->unsigned();
                $table->string('fair_img_alt',30)->nullable();
                $table->string('fair_catch',30)->nullable();
                $table->text('fair_read')->nullable();
                $table->tinyInteger('icon_flg')->unsigned();
                for($i=1;$i<=5;++$i) {
                    $table->tinyInteger('program_time_'.$i.'_h')->unsigned()->nullable();
                    $table->tinyInteger('program_time_'.$i.'_m')->unsigned()->nullable();
                    $table->string('program_comment_'.$i,40)->nullable();
                }
                $table->string('fair_point',40)->nullable();
                $table->tinyInteger('tour_flg')->unsigned();
                $table->tinyInteger('i_wedding_flg')->unsigned();
                $table->tinyInteger('i_reception_flg')->unsigned();
                $table->tinyInteger('show_flg')->unsigned();
                $table->tinyInteger('fitting_flg')->unsigned();
                $table->tinyInteger('hair_flg')->unsigned();
                $table->tinyInteger('food_flg')->unsigned();
                $table->tinyInteger('tasting_flg')->unsigned();
                $table->tinyInteger('fair_tasteing_flg')->unsigned();
                $table->integer('pay_tasting_price')->unsigned();
                $table->tinyInteger('option_tax')->unsigned();
                $table->tinyInteger('option_round_tax')->unsigned();
                $table->tinyInteger('item_flg')->unsigned();
                $table->tinyInteger('counsel_flg')->unsigned();
                $table->tinyInteger('perk_flg')->unsigned();
                $table->tinyInteger('gnavi_limit_flg')->unsigned();
                $table->tinyInteger('just_one_ok_flg')->unsigned();
                $table->tinyInteger('estimate_bid_flg')->unsigned();
                $table->text('freeword_search')->nullable();
                $table->integer('customer_count')->unsigned()->nullable();
                $table->tinyInteger('reserve_flg')->unsigned();
                $table->timestamps();
                
                $table->foreign('fair_id')->references('id')->on('fairs');
            });
            //みんなの
            $schema->create('fair_mweds', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('fair_id')->unsigned();
                $table->string('fair_name',30)->nullable();
                $table->integer('image_id')->unsigned();
                $table->tinyInteger('st_hour')->unsigned();
                $table->tinyInteger('st_minute')->unsigned();
                $table->tinyInteger('ed_hour')->unsigned();
                $table->tinyInteger('ed_minute')->unsigned();
                $table->tinyInteger('type_ques')->unsigned();
                $table->tinyInteger('type_wedding')->unsigned();
                $table->tinyInteger('type_banquet')->unsigned();
                $table->tinyInteger('type_sampling')->unsigned();
                $table->tinyInteger('type_coordinate')->unsigned();
                $table->tinyInteger('type_item')->unsigned();
                $table->tinyInteger('type_tryon')->unsigned();
                $table->tinyInteger('type_etc')->unsigned();
                $table->tinyInteger('disp_sub_flg')->unsigned();
                $table->string('etc1_txt',15)->nullable();
                $table->string('etc2_txt',15)->nullable();
                $table->text('plan_txt')->nullable();
                $table->string('priv_txt',50)->nullable();
                $table->tinyInteger('reserve')->unsigned();
                $table->string('reserve_txt',20)->nullable;
                $table->tinyInteger('rate')->unsigned();
                $table->string('rate_txt',20)->nullable();
                $table->tinyInteger('stpb_year')->unsigned()->nullable();
                $table->tinyInteger('stpb_month')->unsigned()->nullable();
                $table->tinyInteger('stpb_day')->unsigned()->nullable();
                $table->tinyInteger('stpb_hour')->unsigned()->nullable();
                $table->tinyInteger('web_rsv')->unsigned();
                $table->timestamps();
                
                $table->foreign('fair_id')->references('id')->on('fairs');
            });
            //みんなのフェア詳細
            $schema->create('fair_mwed_contents', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('fair_mwed_id')->unsigned();
                $table->tinyInteger('no')->unsigned();
                $table->tinyInteger('dt_type')->unsigned();
                $table->tinyInteger('dt_st_hour')->unsigned();
                $table->tinyInteger('dt_st_min')->unsigned();
                $table->tinyInteger('dt_ed_hour')->unsigned();
                $table->tinyInteger('dt_ed_min')->unsigned();
                $table->timestamps();
                
                $table->foreign('fair_mwed_id')->references('id')->on('fair_mweds');
                $table->unique(array('fair_mwed_id','no'));
            });
            //マイナビ
            $schema->create('fair_mynavis', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('fair_id')->unsigned();
                $table->string('title',100);
                $table->text('text')->nullable();
                $table->integer('image_id')->unsigned();
                $table->string('image_title',100)->nullable();
                $table->text('access_location');
                $table->text('access_location_etc')->nullable();
                $table->text('access_etc')->nullable();
                $table->tinyInteger('answer_div')->unsigned();
                $table->tinyInteger('answer_limit_net_div')->unsigned()->nullable();
                $table->tinyInteger('answer_limit_time_net')->unsigned()->nullable();
                $table->tinyInteger('answer_limit_tel_div')->unsigned()->nullable();
                $table->tinyInteger('answer_limit_time_tel')->unsigned()->nullable();
                $table->string('target_note',100)->nullable();
                $table->text('etc_note')->nullable();
                $table->text('special_note')->nullable();
                $table->tinyInteger('plura_flg')->unsigned()->nullable();
                $table->tinyInteger('max_open_time_row')->unsigned()->nullable();
                for($i=1;$i<=5;++$i) {
                    $table->tinyInteger('start_hour'.$i)->unsigned()->nullable();
                    $table->tinyInteger('start_minute'.$i)->unsigned()->nullable();
                    $table->tinyInteger('end_hour'.$i)->unsigned()->nullable();
                    $table->tinyInteger('end_minute'.$i)->unsigned()->nullable();
                }
                $table->tinyInteger('need_hour')->unsigned()->nullable();
                $table->tinyInteger('need_minute')->unsigned()->nullable();
                $table->tinyInteger('detail_unselect_flg')->unsigned()->nullable();
                $table->timestamps();
                
                $table->foreign('fair_id')->references('id')->on('fairs');
            });
            //マイナビフェア詳細
            $schema->create('fair_mynavi_contents', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('fair_mynavi_id')->unsigned();
                $table->tinyInteger('no')->unsigned();
                $table->tinyInteger('fair_detail_type')->unsigned();
                $table->string('fair_detail_etc_note',100)->nullable();
                $table->tinyInteger('fair_detail_reserve_div')->unsigned()->nullable();
                $table->tinyInteger('fair_detail_price_div')->unsigned()->nullable();
                $table->integer('fair_detail_price')->unsigned()->nullable();
                $table->tinyInteger('fair_detail_start_hour')->unsigned()->nullable();
                $table->tinyInteger('fair_detail_start_minute')->unsigned()->nullable();
                $table->tinyInteger('fair_detail_end_hour')->unsigned()->nullable();
                $table->tinyInteger('fair_detail_end_minute')->unsigned()->nullable();
                $table->string('fair_detail_headline',100)->nullable();
                $table->text('fair_detail_complement')->nullable();
                $table->timestamps();
                
                $table->foreign('fair_mynavi_id')->references('id')->on('fair_mynavis');
                $table->unique(array('fair_mynavi_id','no'));
            });
            //パーク
            $schema->create('fair_parks', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('fair_id')->unsigned();
                $table->tinyInteger('any_time_flag')->unsigned();
                $table->tinyInteger('start_hour')->unsigned();
                $table->tinyInteger('start_min')->unsigned();
                $table->tinyInteger('end_hour')->unsigned();
                $table->tinyInteger('end_min')->unsigned();
                $table->string('name',35);
                $table->text('description')->nullable();
                $table->integer('image_id')->unsigned();
                $table->tinyInteger('fair_2_flag')->unsigned();
                $table->tinyInteger('fair_3_flag')->unsigned();
                $table->tinyInteger('fair_6_flag')->unsigned();
                $table->tinyInteger('fair_7_flag')->unsigned();
                $table->tinyInteger('fair_8_flag')->unsigned();
                $table->tinyInteger('fair_9_flag')->unsigned();
                $table->tinyInteger('fair_10_flag')->unsigned();
                $table->tinyInteger('fair_1_flag')->unsigned();
                $table->tinyInteger('fair_11_flag')->unsigned();
                $table->tinyInteger('fair_12_flag')->unsigned();
                $table->tinyInteger('award_flag')->unsigned();
                $table->text('award_note')->nullable();
                $table->timestamps();
                
                $table->foreign('fair_id')->references('id')->on('fairs');
            });
            //パークフェア詳細
            $schema->create('fair_park_contents', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('fair_park_id')->unsigned();
                $table->tinyInteger('fair_type')->unsigned();
                $table->string('name',30)->nullable();
                $table->tinyInteger('reservation_flag')->unsigned()->nullable();
                $table->integer('people')->unsigned()->nullable();
                $table->integer('price')->unsigned()->nullable();
                for($i=1;$i<=3;++$i) {
                    $table->tinyInteger('start_hour_'.$i)->unsigned()->nullable();
                    $table->tinyInteger('start_min_'.$i)->unsigned()->nullable();
                }
                $table->text('note')->nullable();
                $table->timestamps();
                
                $table->foreign('fair_park_id')->references('id')->on('fair_parks');
                $table->unique(array('fair_park_id','fair_type'));
            });
            //楽天
            $schema->create('fair_rakutens', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('fair_id')->unsigned();
                $table->string('fair_name',40);
                $table->text('introduction')->nullable();
                $table->integer('image_id')->unsigned();
                $table->tinyInteger('reserve_online_flag')->unsigned()->nullable();
                $table->tinyInteger('reception_cd')->unsigned()->nullable();
                $table->tinyInteger('reserve_phone_flag')->unsigned()->nullable();
                $table->tinyInteger('same_event_time_flg')->unsigned()->nullable();
                $table->tinyInteger('same_event_from_hour')->unsigned()->nullable();
                $table->tinyInteger('same_event_from_minute')->unsigned()->nullable();
                $table->tinyInteger('same_event_to_hour')->unsigned()->nullable();
                $table->tinyInteger('same_event_to_minute')->unsigned()->nullable();
                $table->timestamps();
                
                $table->foreign('fair_id')->references('id')->on('fairs');
            });
            //楽天フェア詳細
            $schema->create('fair_rakuten_contents', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('fair_rakuten_id')->unsigned();
                $table->tinyInteger('no')->unsigned();
                $table->integer('kbn_2')->unsigned();
                $table->string('kbn_3',100)->nullable();
                $table->string('kbn_4',100)->nullable();
                $table->integer('event_time_need')->unsigned()->nullable();
                $table->integer('event_price')->unsigned()->nullable();
                $table->text('event_detail')->nullable();
                $table->tinyInteger('event_time_from_hour')->unsigned()->nullable();
                $table->tinyInteger('event_time_from_minute')->unsigned()->nullable();
                $table->tinyInteger('event_time_to_hour')->unsigned()->nullable();
                $table->tinyInteger('event_time_to_minute')->unsigned()->nullable();
                $table->timestamps();
                
                $table->foreign('fair_rakuten_id')->references('id')->on('fair_rakutens');
                $table->unique(array('fair_rakuten_id','no'));
            });
            //すぐ婚
            $schema->create('fair_sugukons', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('fair_id')->unsigned();
                $table->string('title',40);
                $table->text('description');
                for($i=1;$i<=6;++$i) {
                    $table->tinyInteger('content_'.$i)->unsigned()->nullable();
                }
                $table->integer('image_id')->unsigned();
                $table->string('caption',40);
                $table->tinyInteger('reserve_time_type')->unsigned();
                for($i=1;$i<=5;++$i) {
                    $table->tinyInteger('reserve_time_'.$i.'_hour')->unsigned()->nullable();
                    $table->tinyInteger('reserve_time_'.$i.'_minute')->unsigned()->nullable();
                }
                $table->tinyInteger('reserve_time_begin_hour')->unsigned()->nullable();
                $table->tinyInteger('reserve_time_begin_minute')->unsigned()->nullable();
                $table->tinyInteger('reserve_time_end_hour')->unsigned()->nullable();
                $table->tinyInteger('reserve_time_end_minute')->unsigned()->nullable();
                $table->tinyInteger('time_needed_hour')->unsigned();
                $table->tinyInteger('time_needed_minute')->unsigned();
                $table->integer('fee')->unsigned();
                $table->tinyInteger('reserve_period_limit')->unsigned();
                $table->string('parking_explain',27);
                $table->tinyInteger('is_recommend');
                $table->timestamps();
                
                $table->foreign('fair_id')->references('id')->on('fairs');
            });
            //ゼクシィ
            $schema->create('fair_zexys', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('fair_id')->unsigned();
                $table->tinyInteger('real_time_yoyaku_flg')->unsigned()->nullable();
                $table->tinyInteger('fair_start_hour')->unsigned();
                $table->tinyInteger('fair_start_minute')->unsigned();
                $table->tinyInteger('fair_end_hour')->unsigned();
                $table->tinyInteger('fair_end_minute')->unsigned();
                $table->integer('required_minute')->unsigned();
                $table->tinyInteger('secret_flg')->unsigned();
                $table->tinyInteger('head_fair_flg')->unsigned();
                $table->string('fair_nm',30);
                $table->string('main_catch',100);
                $table->tinyInteger('tour_flg')->unsigned()->nullable();
                for($i=1;$i<5;++$i) {
                    $table->tinyInteger('tour_start_hour_'.$i)->unsigned()->nullable();
                    $table->tinyInteger('tour_start_minute_'.$i)->unsigned()->nullable();
                    $table->tinyInteger('tour_end_hour_'.$i)->unsigned()->nullable();
                    $table->tinyInteger('tour_end_minute_'.$i)->unsigned()->nullable();
                }
                $table->tinyInteger('pack_yoyaku_flg')->unsigned()->nullable();
                $table->tinyInteger('pack_yoyaku_kbn')->unsigned()->nullable();
                $table->tinyInteger('pack_yoyaku_unit_kbn')->unsigned()->nullable();
                $table->integer('pack_yoyaku_uketsuke_cnt')->unsigned()->nullable();
                $table->text('fair_perk_naiyo')->nullable();
                $table->text('fair_perk_period')->nullable();
                $table->text('fair_perk_remarks')->nullable();
                $table->text('free_config_question')->nullable();
                $table->tinyInteger('free_config_answer_must_flg')->unsigned()->nullable();
                $table->text('input_address')->nullable();
                $table->text('parking')->nullable();
                $table->string('target_person',50)->nullable();
                $table->text('etc')->nullable();
                for($i=1;$i<=2;++$i) {
                    $table->string('tel_1_'.$i,4);
                    $table->string('tel_2_'.$i,4);
                    $table->string('tel_3_'.$i,4);
                    $table->tinyInteger('tel_shubetsu_kbn_'.$i)->unsigned();
                    $table->string('tel_tanto_nm_'.$i,100);
                }
                $table->string('toiawase',50)->nullable();
                $table->string('tanto',50)->nullable();
                $table->tinyInteger('yoyaku_uketsuke_how_kbn')->unsigned();
                $table->tinyInteger('yoyaku_uketsuke_possible_nissu_net')->unsigned()->nullable();
                $table->tinyInteger('yoyaku_uketsuke_end_time_net')->unsigned()->nullable();
                $table->tinyInteger('yoyaku_uketsuke_possible_nissu_tel')->unsigned()->nullable();
                $table->tinyInteger('request_change_config_kbn')->unsigned()->nullable();
                $table->integer('request_change_rem_frame_cnt')->unsigned()->nullable();
                $table->datetime('keisai_start_date');
                $table->datetime('keisai_end_date');
                $table->timestamps();
                
                $table->foreign('fair_id')->references('id')->on('fairs');
            });
            //ゼクシィフェア詳細
            $schema->create('fair_zexy_contents', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('fair_zexy_id')->unsigned();
                $table->tinyInteger('fair_tkch_cd')->unsigned();
                $table->string('fair_tkch_etc_nm',200);
                $table->tinyInteger('fair_yoyaku_shubetsu_cd')->nullable();
                $table->tinyInteger('yuryo_flg')->unsigned()->nullable();
                $table->integer('entry_ninzu')->unsigned()->nullable();
                $table->integer('entry_charge')->unsigned()->nullable();
                $table->tinyInteger('real_time_yoyaku_unit_kbn')->unsigned()->nullable();
                $table->text('detail')->nullable();
                $table->timestamps();
                
                $table->foreign('fair_zexy_id')->references('id')->on('fair_zexys');
                $table->unique(array('fair_zexy_id','fair_tkch_cd'));
            });
            //ゼクシィフェア詳細の詳細
            $schema->create('fair_zexy_content_details', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('fair_zexy_content_id')->unsigned();
                $table->tinyInteger('no')->unsigned();
                $table->tinyInteger('start_hour')->unsigned()->nullable();
                $table->tinyInteger('start_minute')->unsigned()->nullable();
                $table->tinyInteger('end_hour')->unsigned()->nullable();
                $table->tinyInteger('end_minute')->unsigned()->nullable();
                $table->string('title',100)->nullable();
                $table->integer('yoyaku_cnt')->unsigned()->nullable();
                $table->timestamps();
                
                $table->foreign('fair_zexy_content_id')->references('id')->on('fair_zexy_contents');
                $table->unique(array('fair_zexy_content_id','no'));
            });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
            $schema = Schema::connection('migration');
            $schema->drop('fair_zexy_content_details');
            $schema->drop('fair_zexy_contents');
            $schema->drop('fair_zexys');
            $schema->drop('fair_sugukons');
            $schema->drop('fair_rakuten_contents');
            $schema->drop('fair_rakutens');
            $schema->drop('fair_park_contents');
            $schema->drop('fair_parks');
            $schema->drop('fair_mynavi_contents');
            $schema->drop('fair_mynavis');
            $schema->drop('fair_mwed_contents');
            $schema->drop('fair_mweds');
            $schema->drop('fair_gnavis');
            $schema->drop('fair_dates');
            $schema->drop('fair_contents');
            $schema->drop('fairs');
	}

}
