<fieldset id="page_sugukon" style="display:none">
    <!-- フェア名 -->
    <div class="control-group">
        <label class="control-label" for="fair_name">フェア名</label>
        <div class="controls">
            {{Form::text('sugukon_title',$fair->sugukon->title,array('id'=>'sugukon_title','limit'=>'40','class'=>'counter'))}}
            &nbsp;<span class="text-inline">(<span id="sugukon_title_count">{{mb_strlen($fair->sugukon->title)}}</span>/40)</span>
            &nbsp;<span class="badge bg-red">必須</span>
        </div><!-- /controls -->
        <div class="controls">
            <label class="checkbox inline">{{Form::checkbox('sugukon_is_recommend',Fair::FLG_ON,$fair->sugukon->is_recommend==Fair::FLG_ON)}}おススメフェアにする</label>
        </div><!-- /controls -->
    </div><!-- /control-group -->
    <!-- 説明文 -->
    <div class="control-group">
        <label class="control-label" for="target">説明文</label>
        <div class="controls">
            {{Form::textarea('sugukon_description',$fair->sugukon->description,array('id'=>'sugukon_description','limit'=>'300','class'=>'counter w300','rows'=>'3'))}}
            &nbsp;<span class="text-inline">(<span id="sugukon_description_count">{{mb_strlen($fair->sugukon->description)}}</span>/300)</span>
            &nbsp;<span class="badge bg-red">必須</span>
        </div><!-- /controles -->
    </div><!-- /control-group -->
    <!-- 内容 -->
    <div class="control-group">
        <label class="control-label" for="target">内容</label>
        <div class="controls">
            @foreach(FairSugukon::$contentList as $v => $view)
            <?php
                $content = 'content_'.$v;
            ?>
            <label class="checkbox inline">{{Form::checkbox('sugukon_'.$content,Fair::FLG_ON,$fair->sugukon->$content==Fair::FLG_ON)}}{{$view}}</label><br/>
            @endforeach
        </div><!-- /controles -->
    </div><!-- /control-group -->
    <!-- 写真 -->
    <div class="control-group">
        <label class='control-label'>写真</label>
        <div class="controls">
            ここに画像
        </div><!-- /controls -->
        <div class="controls">
            {{Form::text('sugukon_caption',$fair->sugukon->caption,array('id'=>'sugukon_caption','limit'=>'14','class'=>'counter'))}}
            &nbsp;<span class="text-inline">(<span id="sugukon_caption_count">{{mb_strlen($fair->sugukon->caption)}}</span>/14)</span>
            &nbsp;<span class="badge bg-red">必須</span>
        </div><!-- /controls -->
    </div><!-- /control-group -->
    <hr/>
    <!-- 受付時間 -->
    <div class="control-group">
        <label class="control-label">受付時間</label>
        <div class="controls">
            @foreach(FairSugukon::$reserveTimeTypeList as $v => $view)
            <label class="radio inline">{{Form::radio('sugukon_reserve_time_type',$v,$fair->sugukon->reserve_time_type==$v,array('class'=>'views','view'=>'sugukon_reserve_time_type_'.$v,'view_list'=>'sugukon_reserve_time_type'))}}{{$view}}</label>
            @endforeach
            &nbsp;<span class="badge bg-red">必須</span>
        </div><!-- /controls -->
        <div class="controls" id="sugukon_reserve_time_type_{{FairSugukon::RESERVE_TIME_TYPE_MARK}}" style="display:none">
            <label class="control-label">時間指定</label>
            <div class="controls-inline">
                @for($i=1;$i<=5;++$i)
                <div class="controls">
                    <?php
                        $head = 'sugukon_';
                        $hour = 'reserve_time_'.$i.'_hour';
                        $minute = 'reserve_time_'.$i.'_minute';
                    ?>
                    <span class="text-inline" style="text-align:center;margin:0 5px;">{{$i}}</span>
                    {{Form::select($head.$hour,Fair::$hList8_22,$fair->sugukon->$hour,array('id'=>$head.$hour,'class'=>'hhmm'))}}
                    &nbsp;:&nbsp;
                    {{Form::select($head.$minute,Fair::$mList10,$fair->sugukon->$minute,array('id'=>$head.$minute,'class'=>'hhmm'))}}
                </div>
                @endfor
            </div>
        </div><!-- /controles -->
        <div class="controls" id="sugukon_reserve_time_type_{{FairSugukon::RESERVE_TIME_TYPE_ANYTIME}}" style="display:none">
            <label class="control-label">随時受付</label>
            {{Form::select('sugukon_reserve_time_begin_hour',Fair::$hList8_22,$fair->sugukon->reserve_time_begin_hour,array('id'=>'sugukon_reserve_time_begin_hour','class'=>'hhmm'))}}
            &nbsp;:&nbsp;
            {{Form::select('sugukon_reserve_time_begin_minute',Fair::$mList30,$fair->sugukon->reserve_time_begin_minute,array('id'=>'sugukon_reserve_time_begin_minute','class'=>'hhmm'))}}
            &nbsp;～&nbsp;
            {{Form::select('sugukon_reserve_time_end_hour',Fair::$hList8_22,$fair->sugukon->reserve_time_end_hour,array('id'=>'sugukon_reserve_time_end_hour','class'=>'hhmm'))}}
            &nbsp;:&nbsp;
            {{Form::select('sugukon_reserve_time_end_minute',Fair::$mList30,$fair->sugukon->reserve_time_begin_minute,array('id'=>'sugukon_reserve_time_end_minute','class'=>'hhmm'))}}
        </div><!-- /controles -->
        <hr/>
    </div><!-- /control-group -->
    <!-- 所用時間 -->
    <div class="control-group">
        <label class='control-label'>所用時間</label>
        <div class="controls">
            {{Form::select('sugukon_time_needed_hour',Fair::$hList,$fair->sugukon->time_needed_hour,array('id'=>'sugukon_time_needed_hour','class'=>'hhmm'))}}
            &nbsp;:&nbsp;
            {{Form::select('sugukon_time_needed_minute',Fair::$mList30,$fair->sugukon->time_needed_minute,array('id'=>'sugukon_time_needed_minute','class'=>'hhmm'))}}
            &nbsp;<span class="badge bg-red">必須</span>
        </div><!-- /controls -->
    </div><!-- /control-group -->
    <!-- 料金 -->
    <div class="control-group">
        <label class='control-label'>料金</label>
        <div class="controls">
            {{Form::text('sugukon_fee',$fair->sugukon->fee,array('id'=>'sugukon_fee','limit'=>'27','class'=>'counter'))}}
            &nbsp;<span class="text-inline">(<span id="sugukon_fee_count">{{mb_strlen($fair->sugukon->fee)}}</span>/27)</span>
            &nbsp;<span class="badge bg-red">必須</span>
        </div><!-- /controls -->
    </div><!-- /control-group -->
    <!-- 予約締切 -->
    <div class="control-group">
        <label class='control-label'>予約締切</label>
        <div class="controls">
            {{Form::select('sugukon_reserve_period_limit',FairSugukon::$reservePeriodLimitList,$fair->sugukon->reserve_period_limit,array('id'=>'sugukon_reserve_period_limit','limit'=>'27','class'=>'w80'))}}
            &nbsp;<span class="badge bg-red">必須</span>
        </div><!-- /controls -->
    </div><!-- /control-group -->
    <!-- 駐車場 -->
    <div class="control-group">
        <label class='control-label'>駐車場</label>
        <div class="controls">
            {{Form::text('sugukon_parking_explain',$fair->sugukon->parking_explain,array('id'=>'sugukon_parking_explain','limit'=>'27','class'=>'counter'))}}
            &nbsp;<span class="text-inline">(<span id="sugukon_parking_explain_count">{{mb_strlen($fair->sugukon->parking_explain)}}</span>/27)</span>
            &nbsp;<span class="badge bg-red">必須</span>
        </div><!-- /controls -->
    </div><!-- /control-group -->
</fieldset>