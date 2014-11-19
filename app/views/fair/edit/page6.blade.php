<fieldset id="page_6">
    <h3>6.契約期間及び受付方法</h3>
    <div class="control-group zexys">
        <label class="control-label">リアルタイム受付設定</label>
        <div class="controls">
            <label class="checkbox inline">{{Form::checkbox('zexy_real_time_yoyaku_flg',Fair::FLG_ON,$fair->zexy->real_time_yoyaku_flg)}}受付する</label>
        </div>
    </div><!-- /control-group -->
    <div class="control-group zexys">
        <label class="control-label">予約切替</label>
        <div class="controls">
            <label class="radio inline">{{Form::radio('zexy_request_change_config_kbn',FairZexy::REQUEST_CHANGE_CONFIG_KBN_ON,$fair->zexy->request_change_config_kbn==FairZexy::REQUEST_CHANGE_CONFIG_KBN_ON)}}リクエスト切替する</label>
            <label class="radio inline">{{Form::radio('zexy_request_change_config_kbn',FairZexy::REQUEST_CHANGE_CONFIG_KBN_OFF,$fair->zexy->request_change_config_kbn==FairZexy::REQUEST_CHANGE_CONFIG_KBN_OFF)}}リクエスト切替しない</label>
            <div class="controls-inline">
                <label class="control-label">切替枠数</label>
                <div class="controls">
                    {{Form::text('zexy_request_change_rem_frame_cnt',$fair->zexy->request_change_rem_frame_cnt,array('id'=>'zexy_request_change_rem_frame_cnt','maxlength'=>'2','class'=>'w80'))}}<span class="text-inline">&nbsp;(5桁)</span>
                </div><!-- /controls -->
            </div><!-- /controls-inline -->
        </div><!-- /controls -->
    </div><!-- /control-group -->
    <div class="control-group">
        <label class="control-label">オンライン受付</label>
        <div class="controls">
            <label class="checkbox inline">{{Form::checkbox('reserve_net',Fair::FLG_ON,$fair->reserve_net==Fair::FLG_ON,array('id'=>'reserve_net','class'=>'views','view'=>'reserve_nets'))}}設定する</label>
            <div class="controls-inline">
                <div id="reserve_nets" class="hide">
                    <label class="control-label">掲載期間</label>
                    <div class="controls">
                        {{Form::select('reserve_net_day',Fair::$reserveDayList,$fair->reserve_net_day,array('id'=>'reserve_net_day','class'=>'w80'))}}<span class="text-inline">&nbsp;まで&nbsp;</span>
                        <span class="text-inline">&nbsp;受付時間&nbsp;</span>{{Form::select('reserve_net_time',Fair::$reserveTimeList,$fair->reserve_net_time,array('id'=>'reserve_net_time','class'=>'w80'))}}<span class="text-inline">&nbsp;まで&nbsp;</span>
                        &nbsp;<span class="badge bg-red">必須</span>
                    </div><!-- /controls -->
                </div><!-- /reserve_nets -->
            </div><!-- /controls-inline -->
        </div><!-- /controls-->
    </div><!-- /control-group -->
    <div class="control-group">
        <label class="control-label">電話受付</label>
        <div class="controls">
            <label class="checkbox inline">{{Form::checkbox('reserve_tel',Fair::FLG_ON,$fair->reserve_tel==Fair::FLG_ON,array('id'=>'reserve_tel','class'=>'views','view'=>'reserve_tels'))}}設定する</label>
            <div class="controls-inline">
                <div id="reserve_tels" class="hide">
                    <label class="control-label">掲載期間</label>
                    <div class="controls">
                        {{Form::select('reserve_tel_day',Fair::$reserveDayList,$fair->reserve_tel_day,array('id'=>'reserve_tel_day','class'=>'w80'))}}<span class="text-inline">&nbsp;まで&nbsp;</span>
                        <span class="text-inline">&nbsp;受付時間&nbsp;</span>{{Form::select('reserve_tel_time',Fair::$reserveTimeList,$fair->reserve_tel_time,array('id'=>'reserve_tel_time','class'=>'w80'))}}<span class="text-inline">&nbsp;まで&nbsp;</span>
                        &nbsp;<span class="badge bg-red">必須</span>
                    </div><!-- /controls -->
                </div><!-- /reserve_tels -->
            </div><!-- /controls-inline -->
        </div><!-- /controls -->
    </div><!-- /control-group -->
    <div class="control-group">
        <label class="control-label">優先度</label>
        <div class="controls">
            <label class="radio inline">{{Form::radio('reserve',Fair::RESERVE_NET_PRIORITY,$fair->reserve == Fair::RESERVE_NET_PRIORITY)}}ネット</label>
            <label class="radio inline">{{Form::radio('reserve',Fair::RESERVE_TEL_PRIORITY,$fair->reserve == Fair::RESERVE_TEL_PRIORITY)}}電話</label>
            &nbsp;<span class="badge bg-red">必須</span>
        </div><!-- /controls -->
    </div><!-- /control-group -->
    @include('fair.edit.footbutton')
</fieldset>