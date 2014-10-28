<fieldset id="page_zexy" style="display:none">
    <!-- リアルタイム予約受付 -->
    <div class="control-group">
        <div class="controls">
            <label class="checkbox inline">{{Form::checkbox('zexy_real_time_yoyaku_flg',Fair::FLG_ON,$fair->zexy->real_time_yoyaku_flg==Fair::FLG_ON)}}リアルタイム予約受付</label>
        </div><!-- /controls -->
    </div><!-- /control-group -->
    <!-- 開催日時 -->
    <div class="control-group">
        <label class="control-label">開催時刻</label>
        <div class="controls">
            {{Form::select('zexy_fair_start_hour',Fair::$hList,$fair->zexy->fair_start_hour,array('id'=>'zexy_fair_start_hour','class'=>'hhmm'))}}
            &nbsp;:&nbsp;
            {{Form::select('zexy_fair_start_minute',Fair::$mList1,$fair->zexy->fair_start_minute,array('id'=>'zexy_fair_start_minute','class'=>'hhmm'))}}
            &nbsp;～&nbsp;
            {{Form::select('zexy_fair_end_hour',Fair::$hList,$fair->zexy->fair_end_hour,array('id'=>'zexy_fair_end_hour','class'=>'hhmm'))}}
            &nbsp;:&nbsp;
            {{Form::select('zexy_fair_end_minute',Fair::$mList1,$fair->zexy->fair_end_minute,array('id'=>'zexy_fair_end_minute','class'=>'hhmm'))}}
            &nbsp;<span class="badge bg-red">必須</span>
        </div><!-- /controles -->
    </div><!-- /control-group -->
    <!-- 所用時間 -->
    <div class="control-group">
        <label class="control-label">所用時間</label>
        <div class="controls">
            {{Form::text('zexy_required_minute',$fair->zexy->required_minute,array('id'=>'zexy_title','maxlength'=>'3','class'=>'hhmm'))}}
        </div><!-- /controls -->
    </div><!-- /control-group -->
    <!-- フェア種類 -->
    <div class="control-group">
        <div class="controls">
            <label class="checkbox inline">{{Form::checkbox('zexy_secret_flg',Fair::FLG_ON,$fair->zexy->secret_flg==Fair::FLG_ON)}}シークレットフェアにする</label>
        </div><!-- /controls -->
        <div class="controls">
            <label class="checkbox inline">{{Form::checkbox('zexy_head_fair_flg',Fair::FLG_ON,$fair->zexy->head_fair_flg==Fair::FLG_ON)}}代表フェアにする</label>
        </div><!-- /controls -->
    </div><!-- /control-group -->
    <!-- フェア名 -->
    <div class="control-group">
        <label class="control-label">フェア名</label>
        <div class="controls">
            {{Form::text('zexy_fair_nm',$fair->zexy->fair_nm,array('id'=>'zexy_fair_nm','limit'=>'30','class'=>'counter'))}}
            &nbsp;<span class="text-inline">(<span id="zexy_fair_nm_count">{{mb_strlen($fair->zexy->fair_nm)}}</span>/30)</span>
            &nbsp;<span class="badge bg-red">必須</span>
        </div><!-- /controls -->
    </div><!-- /control-group -->
    <!-- 全体説明文 -->
    <div class="control-group">
        <label class="control-label" for="target">全体説明文</label>
        <div class="controls">
            {{Form::textarea('zexy_main_catch',$fair->zexy->main_catch,array('id'=>'zexy_main_catch','limit'=>'100','class'=>'counter w300','rows'=>'3'))}}
            &nbsp;<span class="text-inline">(<span id="zexy_main_catch_count">{{mb_strlen($fair->zexy->main_catch)}}</span>/100)</span>
            &nbsp;<span class="badge bg-red">必須</span>
        </div><!-- /controles -->
    </div><!-- /control-group -->
    <!-- 複数部設定 -->
    <div class="control-group">
        <label class="control-label">複数部設定</label>
        <div class="controls">
            <label class="checkbox inline">{{Form::checkbox('zexy_tour_flg',Fair::FLG_ON,$fair->zexy->tour_flg==Fair::FLG_ON,array('class'=>'views','view'=>'zexy_tours'))}}複数部にする</label>
        </div><!-- /controls -->
        <div class="controls" id="zexy_tours" style="display:none">
            <div class="controls-inline">
                @for($i=1;$i<=5;++$i)
                <?php
                    $startHour = 'tour_start_hour_'.$i;
                    $startMinute = 'tour_start_minute_'.$i;
                    $endHour = 'tour_end_hour_'.$i;
                    $endMinute = 'tour_end_minute_'.$i;
                ?>
                <div class="controls">
                    <span class="text-inline" style="text-align:center;margin:0 5px">{{$i}}</span>
                    {{Form::select('zexy_'.$startHour,Fair::$hList,$fair->zexy->$startHour,array('id'=>'zexy_'.$startHour,'class'=>'hhmm'))}}
                    &nbsp;:&nbsp;
                    {{Form::select('zexy_'.$startMinute,Fair::$mList,$fair->zexy->$startMinute,array('id'=>'zexy_'.$startMinute,'class'=>'hhmm'))}}
                    &nbsp;～&nbsp;
                    {{Form::select('zexy_'.$endHour,Fair::$hList,$fair->zexy->$endHour,array('id'=>'zexy_'.$endHour,'class'=>'hhmm'))}}
                    &nbsp;:&nbsp;
                    {{Form::select('zexy_'.$endMinute,Fair::$mList,$fair->zexy->$endMinute,array('id'=>'zexy_'.$endMinute,'class'=>'hhmm'))}}
                </div><!-- /controls -->
                @endfor
            </div><!-- /controles-inline -->
        </div><!-- /controles -->
    </div><!-- /control-group -->
    <!-- まとめて予約受付 -->
    <div class="control-group">
        <label class='control-label'>まとめて予約受付</label>
        <div class="controls">
            <label class="checkbox inline">{{Form::checkbox('zexy_pack_flg',Fair::FLG_ON,$fair->zexy->pack_flg==Fair::FLG_ON,array('class'=>'views','view'=>'zexy_packs'))}}まとめて予約受付にする</label>
        </div><!-- /controls -->
        <div class="controls" id="zexy_packs" style="display:none">
            <div class="controls-inline">
                <div class="controls">
                    <label class="control-label">予約</label>
                    {{Form::select('zexy_pack_yoyaku_kbn',FairZexy::$packYoyakuKbnList,$fair->zexy->pack_yoyaku_kbn,array('id'=>'zexy_pack_yoyaku_kbn','class'=>'w150'))}}
                </div><!-- /controls -->
                <div class="controls">
                    <label class="control-label">単位</label>
                    {{Form::select('zexy_pack_yoyaku_unit_kbn',FairZexy::$packYoyakuUnitKbnList,$fair->zexy->pack_yoyaku_unit_kbn,array('id'=>'zexy_pack_yoyaku_unit_kbn','class'=>'hhmm'))}}
                </div><!-- /controls -->
                <div class="controls">
                    <label class="control-label">zebra予約受付</label>
                    {{Form::text('zexy_pack_yoyaku_uketsuke_cnt',$fair->zexy->pack_yoyaku_uketsuke_cnt,array('id'=>'zexy_pack_yoyaku_uketsuke_cnt','maxlength'=>'5'))}}<span class="text-inline">(5桁まで)</span>
                </div><!-- /controls -->
            </div><!-- /controls-inline -->
        </div><!-- /controls -->
    </div><!-- /control-group -->
    <hr/>
    <!-- フェア内容 -->
    @foreach(FairZexy::$fairFlgList as $v => $view)
    <?php
    $content = isset($fair->zexy->contents[$v]) ? $fair->zexy->contents[$v] : new FairZexyContent();
    $details = $content->details;
    ?>
    <div class="control-group">
        <div class="controls">
            <label class="checkbox inline">{{Form::checkbox('zexy_content_tkch_cd_'.$v,Fair::FLG_ON,$content->fair_tkch_cd==Fair::FLG_ON,array('class'=>'views','view'=>'zexy_content_'.$v))}}{{$view}}</label>
        </div>
        <div class="controls" id="zexy_content_{{$v}}" style="display:none">
            <div class="controls-inline">
                <div class="controls">
                    <label class="control-label">予約</label>
                    {{Form::select('zexy_content_fair_yoyaku_shubetsu_cd_'.$v,FairZexyContent::$fairYoyakuShubetsuCdList,$content->fair_yoyaku_shubetsu_cd,array('id'=>'zexy_content_fair_yoyaku_shubetsu_cd_'.$v))}}
                </div><!-- /controls -->
                <div class="controls">
                    <label class="control-label">料金区分</label>
                    <label class="radio inline">{{Form::radio('zexy_content_yuryo_flg_'.$v,FairZexyContent::YURYO_FLG_FREE,$content->yuryo_flg==FairZexyContent::YURYO_FLG_FREE)}}無料</label>
                    <label class="radio inline">{{Form::radio('zexy_content_yuryo_flg_'.$v,FairZexyContent::YURYO_FLG_PAY,$content->yuryo_flg==FairZexyContent::YURYO_FLG_PAY)}}有料</label>
                </div><!-- /controls -->
                <div class="controls">
                    <label class="control-label">参加者</label>
                    {{Form::text('zexy_content_entry_ninzu_'.$v,$content->entry_ninzu,array('id'=>'zexy_content_entry_ninzu_'.$v,'maxlength'=>'3'))}}<span class="text-inline">(3桁まで)</span>
                </div><!-- /controls -->
                <div class="controls">
                    <label class="control-label">料金</label>
                    {{Form::text('zexy_content_entry_charge_'.$v,$content->entry_charge,array('id'=>'zexy_content_entry_charge_'.$v))}}
                </div><!-- /controls -->
                <div class="controls">
                    <label class="control-label">受付単位</label>
                    {{Form::select('zexy_content_real_time_yoyaku_unit_kbn_'.$v,FairZexyContent::$realTimeYoyakuUnitKbn,$content->real_time_yoyaku_unit_kbn,array('id'=>'zexy_content_real_time_yoyaku_unit_kbn_'.$v))}}
                </div><!-- /controls -->
                <div class="controls">
                    <label class="control-label">詳細</label>
                    {{Form::textarea('zexy_content_detail_'.$v,$content->detail,array('id'=>'zexy_content_detail_'.$i,'limit'=>'100','class'=>'w300 counter','rows'=>'2'))}}
                    &nbsp;<span class="text-inline">(<span id="zexy_content_detail_{{$v}}">{{mb_strlen($content->detail)}}</span>/100)</span>
                </div><!-- /controls -->
            </div><!-- /controls-inline -->
        </div><!-- /controls -->
        <hr/>
    </div><!-- /control-group -->
    @endforeach
    <!-- 特典 -->
    <div class="control-group">
        <label class="control-label">フェア特典</label>
        <div class="controls">
            <label class="control-label">特典内容</label>
            {{Form::textarea('zexy_fair_perk_naiyo',$fair->zexy->fair_perk_naiyo,array('id'=>'zexy_fair_peak_naiyo','limit'=>'50','class'=>'counter w300','rows'=>'2'))}}
            &nbsp;<span class="text-inline">(<span id="zexy_fair_perk_naiyo_count">{{mb_strlen($fair->zexy->fair_perk_naiyo)}}</span>/50)</span>
        </div><!-- /controls -->
        <div class="controls">
            <label class="control-label">期間</label>
            {{Form::textarea('zexy_fair_perk_period',$fair->zexy->fair_perk_period,array('id'=>'zexy_fair_perk_period','limit'=>'50','class'=>'counter w300','rows'=>'2'))}}
            &nbsp;<span class="text-inline">(<span id="zexy_fair_perk_period_count">{{mb_strlen($fair->zexy->fair_perk_period)}}</span>/50)</span>
        </div><!-- /controls -->
        <div class="controls">
            <label class="control-label">備考</label>
            {{Form::textarea('zexy_fair_perk_remarks',$fair->zexy->fair_perk_remarks,array('id'=>'zexy_fair_perk_remarks','limit'=>'50','class'=>'counter w300','rows'=>'2'))}}
            &nbsp;<span class="text-inline">(<span id="zexy_fair_perk_remarks_count">{{mb_strlen($fair->zexy->fair_perk_remarks)}}</span>/50)</span>
        </div><!-- /controls -->
    </div><!-- /control-group -->
    <!-- 自由設定質問 -->
    <div class="control-group">
        <label class="control-label">自由設定質問</label>
        <div class="controls">
            <label class="control-label">質問内容</label>
            {{Form::textarea('zexy_free_config_question',$fair->zexy->free_config_question,array('id'=>'zexy_free_config_question','limit'=>'200','class'=>'counter w300','rows'=>'2'))}}
            &nbsp;<span class="text-inline">(<span id="zexy_free_config_question_count">{{mb_strlen($fair->zexy->free_config_question)}}</span>/200)</span>
        </div><!-- /controls -->
        <div class="controls">
            <label class="checkbox inline">{{Form::checkbox('zexy_free_config_answer_must_flg',Fair::FLG_ON,$fair->zexy->free_config_answer_must_flg==Fair::FLG_ON)}}必須回答にする</label>
        </div><!-- /controls -->
    </div><!-- /control-group -->
    <!-- 開催会場 -->
    <div class="control-group">
        <label class="control-label">開催会場</label>
        <div class="controls">
            {{Form::textarea('zexy_input_address',$fair->zexy->input_address,array('id'=>'zexy_input_address','limit'=>'100','class'=>'counter w300','rows'=>'2'))}}
            &nbsp;<span class="text-inline">(<span id="zexy_input_address_count">{{mb_strlen($fair->zexy->input_address)}}</span>/100)</span>
        </div>
    </div><!-- /control-group -->
    <!-- 駐車場 -->
    <div class="control-group">
        <label class="control-label">駐車場</label>
        <div class="controls">
            {{Form::textarea('zexy_parking',$fair->zexy->parking,array('id'=>'zexy_parking','limit'=>'50','class'=>'counter w300','rows'=>'2'))}}
            &nbsp;<span class="text-inline">(<span id="zexy_parking_count">{{mb_strlen($fair->zexy->parking)}}</span>/50)</span>
        </div>
    </div><!-- /control-group -->
    <!-- 対象者 -->
    <div class="control-group">
        <label class="control-label">対象者</label>
        <div class="controls">
            {{Form::textarea('zexy_target_person',$fair->zexy->target_person,array('id'=>'zexy_target_person','limit'=>'50','class'=>'counter w300','rows'=>'2'))}}
            &nbsp;<span class="text-inline">(<span id="zexy_target_person_count">{{mb_strlen($fair->zexy->target_person)}}</span>/50)</span>
        </div>
    </div><!-- /control-group -->
    <!-- その他 -->
    <div class="control-group">
        <label class="control-label">その他</label>
        <div class="controls">
            {{Form::textarea('zexy_etc',$fair->zexy->etc,array('id'=>'zexy_etc','limit'=>'100','class'=>'counter w300','rows'=>'2'))}}
            &nbsp;<span class="text-inline">(<span id="zexy_etc_count">{{mb_strlen($fair->zexy->etc)}}</span>/100)</span>
        </div>
    </div><!-- /control-group -->
    <!-- 電話番号1 -->
    <div class="control-group">
        <label class="control-label">電話番号1</label>
        <div class="controls">
            <label class="control-label"></label>
            {{Form::text('zexy_tel_1_1',$fair->zexy->tel__1_1,array('class'=>'w30','limit'=>'4'))}}&nbsp;-&nbsp;
            {{Form::text('zexy_tel_2_1',$fair->zexy->tel_2_1,array('class'=>'w30','limit'=>'4'))}}&nbsp;-&nbsp;
            {{Form::text('zexy_tel_3_1',$fair->zexy->tel_3_1,array('class'=>'w30','limit'=>'4'))}}
            &nbsp;<span class="badge bg-red">必須</span>
        </div>
        <div class="controls">
            <label class="control-label">種別</label>
            <label class="radio inline">{{Form::radio('zexy_tel1_syubetsu',FairZexy::TEL_SHUBETSU_KBN_TEL,$fair->zexy->tel_shubetsu_kbn_1 == FairZexy::TEL_SHUBETSU_KBN_TEL)}}TEL</label>
            <label class="radio inline">{{Form::radio('zexy_tel1_syubetsu',FairZexy::TEL_SHUBETSU_KBN_FREE,$fair->zexy->tel_shubetsu_kbn_1 == FairZexy::TEL_SHUBETSU_KBN_FREE)}}無料TEL</label>
            &nbsp;<span class="badge bg-red">必須</span>
        </div><!-- /controls -->
        <div class="controls">
            <label class="control-label">担当窓口</label>
            {{Form::text('zexy_tel_tanto_nm_1',$fair->zexy->tel_tanto_nm_1,array('id'=>'zexy_tel_tanto_nm_1','limit'=>'100','class'=>'counter'))}}
            &nbsp;<span class="text-inline">(<span id="zexy_tel_tanto_nm_1_count">{{mb_strlen($fair->zexy->tel_tanto_nm_1)}}</span>/100)</span>
            &nbsp;<span class="badge bg-red">必須</span>
        </div><!-- /controls -->
    </div><!-- /control-group -->
    <!-- 電話番号2 -->
    <div class="control-group">
        <label class="control-label">電話番号2</label>
        <div class="controls">
            <label class="control-label"></label>
            {{Form::text('zexy_tel_1_2',$fair->zexy->tel_1_2,array('class'=>'w30','limit'=>'4'))}}&nbsp;-&nbsp;
            {{Form::text('zexy_tel_2_2',$fair->zexy->tel_2_2,array('class'=>'w30','limit'=>'4'))}}&nbsp;-&nbsp;
            {{Form::text('zexy_tel_3_2',$fair->zexy->tel_3_2,array('class'=>'w30','limit'=>'4'))}}
        </div>
        <div class="controls">
            <label class="control-label">種別</label>
            <label class="radio inline">{{Form::radio('zexy_tel2_syubetsu',FairZexy::TEL_SHUBETSU_KBN_TEL,$fair->zexy->tel_shubetsu_kbn_2 == FairZexy::TEL_SHUBETSU_KBN_TEL)}}TEL</label>
            <label class="radio inline">{{Form::radio('zexy_tel2_syubetsu',FairZexy::TEL_SHUBETSU_KBN_FREE,$fair->zexy->tel_shubetsu_kbn_2 == FairZexy::TEL_SHUBETSU_KBN_FREE)}}無料TEL</label>
            <label class="radio inline">{{Form::radio('zexy_tel2_syubetsu',FairZexy::TEL_SHUBETSU_KBN_FAX,$fair->zexy->tel_shubetsu_kbn_2 == FairZexy::TEL_SHUBETSU_KBN_FAX)}}FAX</label>
        </div><!-- /controls -->
        <div class="controls">
            <label class="control-label">担当窓口</label>
            {{Form::text('zexy_tel_tanto_nm_2',$fair->zexy->tel_tanto_nm_2,array('id'=>'zexy_tel_tanto_nm_2','limit'=>'100','class'=>'counter'))}}
            &nbsp;<span class="text-inline">(<span id="zexy_tel_tanto_nm_2_count">{{mb_strlen($fair->zexy->tel_tanto_nm_2)}}</span>/100)</span>
            &nbsp;<span class="badge bg-red">必須</span>
        </div><!-- /controls -->
    </div><!-- /control-group -->
    <!-- 問合せ -->
    <div class="control-group">
        <label class="control-label">問合せ</label>
        <div class="controls">
            <label class="control-label">受付時間</label>
            {{Form::text('zexy_toiawase',$fair->zexy->toiawase,array('id'=>'zexy_toiawase','limit'=>'50','class'=>'counter'))}}
            &nbsp;<span class="text-inline">(<span id="zexy_toiawase">{{mb_strlen($fair->zexy->toiawase)}}</span>/50)</span>
        </div><!-- /controls -->
    </div><!-- /control-group -->
    <!-- 担当 -->
    <div class="control-group">
        <label class="control-label">担当</label>
        <div class="controls">
            {{Form::textarea('zexy_tanto',$fair->zexy->tanto,array('id'=>'zexy_tanto','limit'=>'50','class'=>'counter w300','rows'=>'2'))}}
            &nbsp;<span class="text-inline">(<span id="zexy_tanto">{{mb_strlen($fair->zexy->tanto)}}</span>/50)</span>
        </div><!-- /controls -->
    </div><!-- /control-group -->
    <!-- 予約方法/受付期間 -->
    <div class="control-group">
        <label class="control-label">予約方法</label>
        <div class="controls">
            <label class="radio inline">{{Form::radio('zexy_yoyaku_uketsuke_how_kbn',FairZexy::YOYAKU_KBN_DOUBLE,$fair->zexy->yoyaku_uketsuke_how_kbn==FairZexy::YOYAKU_KBN_DOUBLE)}}ネット・電話で予約を受付</label>
            <label class="radio inline">{{Form::radio('zexy_yoyaku_uketsuke_how_kbn',FairZexy::YOYAKU_KBN_TEL_ONLY,$fair->zexy->yoyaku_uketsuke_how_kbn==FairZexy::YOYAKU_KBN_TEL_ONLY)}}電話で予約を受付</label>
        </div><!-- /controls -->
        <div class="controls">
            <label class="control-label">受付期間</label>
            <div class="controls-inline">
                <div class="controls">
                    <span class="text-inline" style="text-align:center;margin:0 5px;">ネット受付</span>{{Form::text('zexy_yoyaku_uketsuke_possible_nissu_net',$fair->zexy->yoyaku_uketsuke_possible_nissu_net,array('id'=>'zexy_yoyaku_uketsuke_possible_nissu_net','maxlength'=>'2','class'=>'hhmm'))}}<span class="text-inline">&nbsp;日前(2桁)</span>
                </div><!-- /controls -->
                <div class="controls">
                    <span class="text-inline" style="text-align:center;margin:0 5px;">ネット受付</span>{{Form::select('zexy_yoyaku_uketsuke_end_time_net',Fair::$hList,$fair->zexy->yoyaku_uketsuke_end_time_net,array('id'=>'zexy_yoyaku_uketsuke_possible_nissu_net','class'=>'hhmm'))}}<span class="text-inline">&nbsp;時まで受付</span>
                </div><!-- /controls -->
                <div class="controls">
                    <span class="text-inline" style="text-align:center;margin:0 5px;">電話受付</span>{{Form::text('zexy_yoyaku_uketsuke_possible_nissu_tel',$fair->zexy->yoyaku_uketsuke_possible_nissu_tel,array('id'=>'zexy_yoyaku_uketsuke_possible_nissu_tel','maxlength'=>'2','class'=>'hhmm'))}}<span class="text-inline">&nbsp;日前(2桁)</span>
                </div><!-- /controls -->
            </div><!-- /controls-inline -->
        </div><!-- /controls -->
    </div><!-- /control-group -->
    <!-- 予約切替 -->
    <div class="control-group">
        <label class="control-label">予約切替</label>
        <div class="controls">
            <label class="radio inline">{{Form::radio('zexy_request_change_config_kbn',FairZexy::REQUEST_CHANGE_CONFIG_KBN_ON,$fair->zexy->request_change_config_kbn==FairZexy::REQUEST_CHANGE_CONFIG_KBN_ON)}}リクエスト切替する</label>
            <label class="radio inline">{{Form::radio('zexy_request_change_config_kbn',FairZexy::REQUEST_CHANGE_CONFIG_KBN_OFF,$fair->zexy->request_change_config_kbn==FairZexy::REQUEST_CHANGE_CONFIG_KBN_OFF)}}リクエスト切替しない</label>
        </div><!-- /controls -->
        <div class="controls">
            <label class="control-label">切替枠数</label>
            {{Form::text('zexy_request_change_rem_frame_cnt',$fair->zexy->request_change_rem_frame_cnt,array('id'=>'zexy_request_change_rem_frame_cnt','maxlength'=>'2','class'=>'w80'))}}<span class="text-inline">&nbsp;(5桁)</span>
        </div><!-- /controls -->
    </div><!-- /control-group -->
</fieldset>