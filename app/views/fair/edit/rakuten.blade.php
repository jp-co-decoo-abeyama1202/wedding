<fieldset id="page_rakuten" style="display:none">
    <!-- フェア名 -->
    <div class="control-group">
        <label class="control-label" for="fair_name">フェア名</label>
        <div class="controls">
            {{Form::text('rakuten_fair_name',$fair->rakuten->fair_name,array('id'=>'rakuten_fair_name','limit'=>'40','class'=>'counter'))}}
            &nbsp;<span class="text-inline">(<span id="rakuten_fair_name_count">{{mb_strlen($fair->rakuten->fair_name)}}</span>/40)</span>
            &nbsp;<span class="badge bg-red">必須</span>
        </div><!-- /controles -->
    </div><!-- /control-group -->
    <!-- 紹介文 -->
    <div class="control-group">
        <label class="control-label" for="target">紹介文</label>
        <div class="controls">
            {{Form::textarea('rakuten_introduction',$fair->rakuten->introduction,array('id'=>'rakuten_introduction','limit'=>'200','class'=>'counter w300','rows'=>'3'))}}
            &nbsp;<span class="text-inline">(<span id="rakuten_introduction_count">{{mb_strlen($fair->rakuten->introduction)}}</span>/200)</span>
        </div><!-- /controles -->
    </div><!-- /control-group -->
    <!-- 紹介文 -->
    <div class="control-group">
        <label class="control-label" for="target">予約受付</label>
        <div class="controls">
            <label class="checkbox inline">{{Form::checkbox('dummy',Fair::FLG_ON,true,array('disabled'=>'disabled'))}}オンライン</label>
            {{Form::hidden('rakuten_reserve_online_flag',Fair::FLG_ON)}}
            <label class="checkbox inline">{{Form::checkbox('rakuten_reserve_phone_flag',Fair::FLG_ON,$fair->rakuten->reserve_phone_flag == Fair::FLG_ON)}}電話</label>
        </div><!-- /controles -->
        <div class="controls">
            <label class="control-label" for="target">予約期間</label>
            {{Form::select('rakuten_reception_cd',FairRakuten::$receptionCdList,$fair->rakuten->reception_cd,array('id'=>'rakuten_reception_cd','class'=>'w150'))}}
            <span class="text-inline">&nbsp;(ｵﾝﾗｲﾝ)</span>
        </div><!-- /controles -->
    </div><!-- /control-group -->
    <!-- 開催内容 -->
    <div class="control-group">
        <label class='control-label'>フェア内容詳細</label>
        <div class="controls">
            <label class="checkbox inline">{{Form::checkbox('rakuten_same_event_time_flag',Fair::FLG_ON,$fair->rakuten->same_event_time_flag==Fair::FLG_ON,array('class'=>'views','view'=>'rakuten_save_event_time'))}}同じ開催時刻を設定</label>
            <div class="controls-inline" id="rakuten_save_event_time" style="display:none">
                <label class='control-label'>開催時刻</label>
                <div class="controls">
                    {{Form::select('rakuten_same_event_from_hour',Fair::$hList8_22,$fair->rakuten->same_event_from_hour,array('id'=>'rakuten_same_event_from_hour','class'=>'hhmm'))}}
                    &nbsp;:&nbsp;
                    {{Form::select('rakuten_same_event_from_minute',Fair::$mList,$fair->rakuten->same_event_from_minute,array('id'=>'rakuten_same_event_from_minute','class'=>'hhmm'))}}
                    &nbsp;～&nbsp;
                    {{Form::select('rakuten_same_event_to_hour',Fair::$hList8_22,$fair->rakuten->same_event_to_hour,array('id'=>'rakuten_same_event_to_hour','class'=>'hhmm'))}}
                    &nbsp;:&nbsp;
                    {{Form::select('rakuten_same_event_to_minute',Fair::$mList,$fair->rakuten->same_event_to_minute,array('id'=>'rakuten_same_event_to_minute','class'=>'hhmm'))}}
                </div><!-- /controls -->
            </div><!-- /controls-inline -->
        </div><!-- /controls -->
        <div class="controls">
            {{Form::Button('フェア内容追加',array('id'=>'rakuten_content_add'))}}
        </div>
    </div><!-- /control-group -->
    <hr/>
    <!-- 各詳細 -->
    @foreach($fair->rakuten->contents as $content)
    <?php
        $head = 'rakuten_content_';
        $no = (int)$content->no;
    ?>
    <div class="control-group" id="rakuten_content_{{$no}}">
        <label class="control-label">{{$no}}</label>
        {{Form::hidden($head.'no_'.$no,$no,array('id'=>$head.'no_'.$no))}}
        {{Form::hidden($head.'kbn_2_'.$no,$content->kbn_2,array('id'=>$head.'kbn_2_'.$no))}}
        {{Form::hidden($head.'kbn_3_'.$no,$content->kbn_3,array('id'=>$head.'kbn_3_'.$no))}}
        {{Form::hidden($head.'kbn_4_'.$no,$content->kbn_4,array('id'=>$head.'kbn_4_'.$no))}}
        <div class="controls">
            ココに内容が表示される
            {{Form::Button('修正',array('class'=>'rakuten_content_update','content_no'=>$no))}}
            {{Form::Button('削除',array('class'=>'rakuten_content_delete','content_no'=>$no))}}
        </div><!-- /controles -->
        <div class="controls">
            <label class="control-label">所用時間</label>
            {{Form::text($head.'event_time_need_'.$no,$content->event_time_need,array('id'=>$head.'event_time_need_'.$no,'maxlength'=>'3','class'=>'w80'))}}<span class="text-inline">&nbsp;(3桁まで)&nbsp;</span>
        </div><!-- /controles -->
        <div class="controls">
            <label class="control-label">所用時間</label>
            {{Form::text($head.'event_price_'.$no,$content->event_price,array('id'=>$head.'event_price_'.$no,'maxlength'=>'6','class'=>'w80'))}}<span class="text-inline">&nbsp;(6桁まで)&nbsp;</span>
        </div><!-- /controles -->
        <div class="controls">
            <label class="control-label">詳細</label>
            {{Form::textarea($head.'event_detail_'.$no,$content->event_detail,array('id'=>$head.'event_detail_'.$no,'limit'=>'120','class'=>'counter w350'))}}
            &nbsp;<span class="text-inline">(<span id="{{$head}}event_detail_{{$no}}_count">{{mb_strlen($content->event_detail)}}</span>/120)</span>
        </div><!-- /controles -->
        <div class="controls">
            <label class="control-label">時間</label>
            {{Form::select($head.'event_time_from_hour_'.$no,Fair::$hList8_22,$content->event_time_from_hour,array('id'=>$head.'event_time_from_hour_'.$no,'class'=>'hhmm'))}}
            &nbsp;:&nbsp;
            {{Form::select($head.'event_time_from_minute_'.$no,Fair::$mList,$content->same_event_from_minute,array('id'=>$head.'event_time_from_minute_'.$no,'class'=>'hhmm'))}}
            &nbsp;～&nbsp;
            {{Form::select($head.'event_time_to_hour_'.$no,Fair::$hList8_22,$content->event_time_to_hour,array('id'=>$head.'event_time_to_hour_'.$no,'class'=>'hhmm'))}}
            &nbsp;:&nbsp;
            {{Form::select($head.'event_time_to_minute_'.$no,Fair::$mList,$content->event_time_to_minute,array('id'=>$head.'event_time_to_minute_'.$no,'class'=>'hhmm'))}}
        </div><!-- /controles -->
        <hr/>
    </div><!-- /control-group -->
    @endforeach
    <!-- 特典 -->
    <div class="control-group">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th></th>
                    <th>特典名</th>
                    <th>特典内容</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tokutens as $tokuten)
                <tr>
                    <td>{{Form::checkbox('rakuten_tokutens[]',$tokuten->id,false)}}</td>
                    <td>{{$tokuten->privilege_name}}</td>
                    <td>{{$tokuten->privilege_content}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div><!-- /control-group -->
    
    <!-- 追加用 -->
    <div class="control-group" id="rakuten_content_0" style="display:none">
        <label class="control-label">フェア詳細0</label>
        {{Form::hidden('rakuten_content_no_0',0,array('id'=>'rakuten_content_no_0'))}}
        {{Form::hidden('rakuten_content_kbn_2_0',null,array('id'=>'rakuten_content_kbn_2_0'))}}
        {{Form::hidden('rakuten_content_kbn_3_0',null,array('id'=>'rakuten_content_kbn_3_0'))}}
        {{Form::hidden('rakuten_content_kbn_4_0',null,array('id'=>'rakuten_content_kbn_4_0'))}}
        <div class="controls">
            ココに内容が表示される
            {{Form::Button('修正',array('class'=>'rakuten_content_update','content_no'=>0))}}
            {{Form::Button('削除',array('class'=>'rakuten_content_delete','content_no'=>0))}}
        </div><!-- /controles -->
        <div class="controls">
            <label class="control-label">所用時間</label>
            {{Form::text('rakuten_content_event_time_need_0',null,array('id'=>'rakuten_content_event_time_need_0','maxlength'=>'3','class'=>'w80'))}}<span class="text-inline">&nbsp;(3桁まで)&nbsp;</span>
        </div><!-- /controles -->
        <div class="controls">
            <label class="control-label">所用時間</label>
            {{Form::text('rakuten_content_event_price_0',null,array('id'=>'rakuten_content_event_price_0','maxlength'=>'6','class'=>'w80'))}}<span class="text-inline">&nbsp;(6桁まで)&nbsp;</span>
        </div><!-- /controles -->
        <div class="controls">
            <label class="control-label">詳細</label>
            {{Form::textarea('rakuten_content_event_detail_0',null,array('id'=>'rakuten_content_event_detail_0','limit'=>'120','class'=>'counter w300','rows'=>'3'))}}
            &nbsp;<span class="text-inline">(<span id="rakuten_content_event_detail_0_count">{{mb_strlen('')}}</span>/120)</span>
        </div><!-- /controles -->
        <div class="controls">
            <label class="control-label">時間</label>
            {{Form::select('rakuten_content_event_time_from_hour_0',Fair::$hList8_22,null,array('id'=>'rakuten_content_event_time_from_hour_0','class'=>'hhmm'))}}
            &nbsp;:&nbsp;
            {{Form::select('rakuten_content_event_time_from_minute_0',Fair::$mList,null,array('id'=>'rakuten_content_event_time_from_minute_0','class'=>'hhmm'))}}
            &nbsp;～&nbsp;
            {{Form::select('rakuten_content_event_time_to_hour_0',Fair::$hList8_22,null,array('id'=>'rakuten_content_event_time_to_hour_0','class'=>'hhmm'))}}
            &nbsp;:&nbsp;
            {{Form::select('rakuten_content_event_time_to_minute_0',Fair::$mList,null,array('id'=>'rakuten_content_event_time_to_minute_0','class'=>'hhmm'))}}
        </div><!-- /controles -->
        <hr/>
    </div><!-- /control-group -->
</fieldset>