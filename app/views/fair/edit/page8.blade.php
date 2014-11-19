<fieldset id="page_8">
    <h3>8.個別設定項目</h3>
    <!-- 共通 -->
    <div class="control-group mynavis zexys">
        <label class="control-label">共通</label>
        <div class="controls mynavis zexys">
            <div class="controls-inline">
                <label class="control-label">対象者</label>
                <div class="controls">
                    {{Form::text('target_note',$fair->target_note,array('id'=>'target_note','limit'=>'100','class'=>'counter'))}}
                    &nbsp;<span class="text-inline">(<span id="target_note_count">{{mb_strlen($fair->target_note)}}</span>/100)</span>
                </div><!-- /controls -->
                <label class="control-label">その他</label>
                <div class="controls">
                    {{Form::textarea('etc_note',$fair->etc_note,array('id'=>'etc_note','limit'=>'100','class'=>'counter w300','rows'=>2))}}
                    &nbsp;<span class="text-inline">(<span id="etc_note_count">{{mb_strlen($fair->etc_note)}}</span>/100)</span>
                </div><!-- /controls -->
            </div><!-- controls-inline -->
        </div><!-- /controls -->
        <hr/>
    </div><!-- /control-group -->
    <!-- ゼクシィ -->
    <div class="control-group zexys">
        <label class="control-label">ゼクシィ</label>
        <div class="controls">
            <div class="controls-inline">
                <label class="control-label">フェアの分類設定</label>
                <div class="controls">
                    <label class="radio inline">{{Form::radio('zexy_secret_flg',Fair::FLG_OFF,$fair->zexy->secret_flg==Fair::FLG_OFF)}}ノーマルフェア</label>
                    &nbsp;<label class="checkbox inline">{{Form::checkbox('zexy_head_fair_flg',Fair::FLG_ON,$fair->zexy->head_fair_flg==Fair::FLG_ON)}}代表フェアにする</label>
                    <br/>
                    <label class="radio inline">{{Form::radio('zexy_secret_flg',Fair::FLG_ON,$fair->zexy->secret_flg==Fair::FLG_ON)}}シークレットフェア</label><br/>
                </div><!-- /controls -->
                <label class="control-label">質問項目</label>
                <div class="controls">
                    {{Form::textarea('zexy_free_config_question',$fair->zexy->free_config_question,array('id'=>'zexy_free_config_question','limit'=>'200','class'=>'counter w300','rows'=>'2'))}}
                    &nbsp;<span class="text-inline">(<span id="zexy_free_config_question_count">{{mb_strlen($fair->zexy->free_config_question)}}</span>/200)</span><br/>
                    <label class="checkbox inline">{{Form::checkbox('zexy_free_config_answer_must_flg',Fair::FLG_ON,$fair->zexy->free_config_answer_must_flg==Fair::FLG_ON)}}必須回答にする</label>
                </div><!-- /controls -->
                <label class='control-label'>まとめて予約受付</label>
                <div class="controls">
                    <label class="checkbox inline">{{Form::checkbox('zexy_pack_flg',Fair::FLG_ON,$fair->zexy->pack_flg==Fair::FLG_ON,array('class'=>'views','view'=>'zexy_packs'))}}まとめて予約受付にする</label>
                </div><!-- /controls -->
                <div class="hide" id="zexy_packs">
                    <div class="controls">
                        <label class="control-label">予約区分</label>
                        {{Form::select('zexy_pack_yoyaku_kbn',FairZexy::$packYoyakuKbnList,$fair->zexy->pack_yoyaku_kbn,array('id'=>'zexy_pack_yoyaku_kbn','class'=>'w150'))}}
                    </div><!-- /controls -->
                    <div class="controls">
                        <label class="control-label">単位</label>
                        {{Form::select('zexy_pack_yoyaku_unit_kbn',FairZexy::$packYoyakuUnitKbnList,$fair->zexy->pack_yoyaku_unit_kbn,array('id'=>'zexy_pack_yoyaku_unit_kbn','class'=>'hhmm'))}}
                    </div><!-- /controls -->
                    <div class="controls">
                        <label class="control-label">zebra予約受付</label>
                        {{Form::text('zexy_pack_yoyaku_uketsuke_cnt',$fair->zexy->pack_yoyaku_uketsuke_cnt,array('id'=>'zexy_pack_yoyaku_uketsuke_cnt','maxlength'=>'5'))}}&nbsp;<span class="text-inline">(5桁まで)</span>
                    </div><!-- /controls -->
                </div><!-- /hide -->
            </div><!-- controls-inline -->
        </div><!-- /controls -->
        <hr/>
    </div><!-- /control-group-->
    <!-- すぐ婚 -->
    <div class="control-group sugukons">
        <label class="control-label">すぐ婚</label>
        <div class="controls">
            <div class="controls-inline">
                <label class="control-label">オススメフェア</label>
                <div class="controls">
                    <label class="checkbox inline">{{Form::checkbox('sugukon_is_recommend',Fair::FLG_ON,$fair->sugukon->is_recommend)}}オススメフェアとして登録する</label>
                </div><!-- /controls -->
            </div><!-- controls-inline -->
        </div><!-- /controls -->
        <hr/>
    </div><!-- /control-group -->
    <!-- ぐるナビ -->
    <div class="control-group gnavis">
        <label class="control-label">ぐるナビ</label>
        <div class="controls">
            <div class="controls-inline">
                <label class="control-label">検索キーワード設定</label>
                <div class="controls">
                    {{Form::text('gnavi_freeword_search',$fair->gnavi->freeword_search,array('id'=>'gnavi_freeword_search','limit'=>'512','class'=>'counter w400'))}}
                    <a id="gnavi_freeword_get" role="button" class="btn btn-contentsmodal">内容取得</a>
                    &nbsp;<span class="text-inline">(<span id="gnavi_freeword_search_count">{{mb_strlen($fair->gnavi->freeword_search)}}</span>/512)</span>
                </div><!-- /controls -->
                <label class="control-label" for="target">キャッチコピー</label>
                <div class="controls">
                    {{Form::text('gnavi_fair_catch',$fair->gnavi->fair_catch,array('id'=>'gnavi_fair_catch','limit'=>'30','class'=>'counter w300'))}}
                    &nbsp;<span class="text-inline">(<span id="gnavi_fair_catch_count">{{mb_strlen($fair->gnavi->fair_catch)}}</span>/50)</span>
                </div><!-- /controls -->
                <label class="control-label">ココに注目</label>
                <div class="controls">
                    {{Form::text('gnavi_fair_point',$fair->gnavi->fair_point,array('id'=>'gnavi_fair_point','limit'=>'30','class'=>'counter w300'))}}
                    &nbsp;<span class="text-inline">(<span id="fair_point_count">{{mb_strlen($fair->gnavi->fair_point)}}</span>/30)</span>
                </div><!-- /controls -->
                <div class="controls">
                    <label class="checkbox inline">{{Form::checkbox('gnavi_gnavi_limit_flg',Fair::FLG_ON,$fair->gnavi->gnavi_limit_flg,array('id'=>'gnavi_gnavi_limit_flg'))}}ぐるナビ限定</label>
                    <label class="checkbox inline">{{Form::checkbox('gnavi_just_one_ok_flg',Fair::FLG_ON,$fair->gnavi->just_one_ok_flg,array('id'=>'gnavi_just_one_ok_flg'))}}おひとり様参加OK</label>
                    <label class="checkbox inline">{{Form::checkbox('gnavi_estimate_bid_flg',Fair::FLG_ON,$fair->gnavi->estimate_bid_flg,array('id'=>'gnavi_estimate_bid_flg'))}}見積書のご案内</label>
                </div><!-- /controls -->
                <label class="control-label">定員</label>
                <div class="controls">
                    {{Form::text('gnavi_customer_count',$fair->gnavi->customer_count,array('id'=>'gnavi_customer_count','maxlength'=>'3','max-length'=>'3','class'=>'w30'))}}
                    &nbsp;<span class="text-inline">人(3桁まで)</span>
                </div><!-- /controls -->
            </div><!-- controls-inline -->
        </div><!-- /controls -->
        <hr/>
    </div><!-- /control-group -->
    @include('fair.edit.footbutton')
</fieldset>