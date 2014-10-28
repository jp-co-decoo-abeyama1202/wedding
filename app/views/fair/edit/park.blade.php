<fieldset id="page_park" style="display:none">
    <!-- 開催時刻 -->
    <div class="control-group">
        <label class="control-label">開催時刻</label>
        <div class="controls">
            {{Form::select('park_start_hour',Fair::$hList,$fair->park->start_hour,array('id'=>'park_start_hour','class'=>'hhmm'))}}
            &nbsp;:&nbsp;
            {{Form::select('park_start_min',Fair::$mList,$fair->park->start_min,array('id'=>'park_start_min','class'=>'hhmm'))}}
            &nbsp;～&nbsp;
            {{Form::select('park_end_hour',Fair::$hList,$fair->park->end_hour,array('id'=>'park_end_hour','class'=>'hhmm'))}}
            &nbsp;:&nbsp;
            {{Form::select('park_end_min',Fair::$mList,$fair->park->end_m,array('id'=>'park_end_min','class'=>'hhmm'))}}
            &nbsp;<span class="badge bg-red">必須</span>
        </div><!-- /controles -->
    </div><!-- /control-group -->
    <!-- フェアタイトル -->
    <div class="control-group">
        <label class="control-label" for="fair_name">フェアタイトル</label>
        <div class="controls">
            {{Form::text('park_name',$fair->park->name,array('id'=>'park_name','limit'=>'35','class'=>'counter'))}}
            &nbsp;<span class="text-inline">(<span id="park_name_count">{{mb_strlen($fair->park->name)}}</span>/35)</span>
            &nbsp;<span class="badge bg-red">必須</span>
        </div><!-- /controles -->
    </div><!-- /control-group -->
    <!-- フェア紹介文 -->
    <div class="control-group">
        <label class="control-label" for="target">フェア紹介文</label>
        <div class="controls">
            {{Form::textarea('park_description',$fair->park->description,array('id'=>'park_description','limit'=>'115','class'=>'counter w300','rows'=>'3'))}}
            &nbsp;<span class="text-inline">(<span id="park_description_count">{{mb_strlen($fair->park->description)}}</span>/115)</span>
        </div><!-- /controles -->
    </div><!-- /control-group -->
    <!-- 開催内容 -->
    <div class="control-group">
        <label class='control-label'>開催内容</label>
        <div class="controls">
            @foreach(FairPark::$fairFlgList as $v => $view)
            <?php
                $value = 'fair_'.$v.'_flag';
            ?>
            <label class="checkbox inline">{{Form::checkbox('park_'.$value,Fair::FLG_ON,$fair->park->$value==Fair::FLG_ON,array('view'=>'park_fair_'.$v,'class'=>'views'))}}{{$view}}</label></br>
            @endforeach
        </div><!-- /controles -->
    </div><!-- /control-group -->
    <hr/>
    @foreach(FairPark::$fairFlgList as $v => $view)
    <?php
        $head = 'park_content_';
        //$content = isset($fair->park->contents[$v]) ? $fair->park->contents[$v] : new FairParkContent();
        $content = new FairParkContent();
    ?>
    <div class="control-group" id="park_fair_{{$v}}" style="display:none">
        <label class="control-label">{{$view}}</label>
        @if(in_array($v,array(FairPark::FAIR_FLAG_ETC_1,FairPark::FAIR_FLAG_ETC_2,FairPark::FAIR_FLAG_ETC_3)))
        <div class="controls">
            <label class="control-label">項目名</label>
            {{Form::text($head.'name_'.$v,$content->name,array('id'=>$head.'name_'.$v,'limit'=>'35','class'=>'counter'))}}
            &nbsp;<span class="text-inline">(<span id="{{$head}}name_{{$v}}">{{mb_strlen($content->name)}}</span>/35)</span>
            <label class="checkbox inline" style="margin-left:10px">{{Form::checkbox($head.'reservation_flag_'.$v,Fair::FLG_ON,$content->reservation_flag==Fair::FLG_ON)}}要予約</label>
        </div><!-- /controles -->
        @else
        <div class="controls">
            <label class="checkbox inline" style="margin-left:10px">{{Form::checkbox($head.'reservation_flag_'.$v,Fair::FLG_ON,$content->reservation_flag==Fair::FLG_ON)}}要予約</label>
        </div><!-- /controles -->
        @endif
        <div class="controls">
            <label class="control-label">料金</label>
            {{Form::text($head.'people_'.$v,$content->people,array('id'=>$head.'people_'.$v,'maxlength'=>'5','class'=>'w80'))}}<span class="text-inline">&nbsp;人で&nbsp;</span>
            {{Form::text($head.'price_'.$v,$content->price,array('id'=>$head.'price_'.$v,'maxlength'=>'8','class'=>'w80'))}}<span class="text-inline">&nbsp;円</span>
        </div><!-- /controles -->
        <div class="controls">
            <label class="control-label">開催時間</label>
            <div class="controls-inline">
                @for($i=1;$i<=3;++$i)
                <?php
                    $startH = 'start_hour_'.$i;
                    $startM = 'start_min_'.$i;
                ?>
                <div class="controls">
                    <label class="control-label">{{$i}}回目</label>
                    {{Form::select($head.$startH.'_'.$v,Fair::$hList,$content->$startH,array('id'=>$head.$startH.'_'.$v,'class'=>'hhmm'))}}
                    &nbsp;:&nbsp;
                    {{Form::select($head.$startM.'_'.$v,Fair::$mList,$content->$startM,array('id'=>$head.$startM.'_'.$v,'class'=>'hhmm'))}}
                </div>
                @endfor
            </div>
        </div><!-- /controles -->
        <div class="controls">
            <label class="control-label">備考</label>
            {{Form::textarea($head.'note_'.$v,$content->note,array('id'=>$head.'note_'.$v,'limit'=>'200','class'=>'w300 counter','rows'=>'3'))}}
            &nbsp;<span class="text-inline">(<span id="{{$head}}note_{{$v}}">{{mb_strlen($content->note)}}</span>/200)</span>
        </div><!-- /controles -->
        <hr/>
    </div><!-- /control-group -->
    @endforeach
</fieldset>