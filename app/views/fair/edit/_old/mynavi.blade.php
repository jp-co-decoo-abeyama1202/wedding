<fieldset id="page_mynavi" style="display:none">
    <div class="control-group">
        <label class="control-label">フェアタイトル</label>
        <div class="controls">
            {{Form::text('mynavi_title',$fair->mynavi->title,array('id'=>'mynavi_title','limit'=>'100','class'=>'counter'))}}
            &nbsp;<span class="text-inline">(<span id="mynavi_title_count">{{mb_strlen($fair->mynavi->title)}}</span>/100)</span>
            &nbsp;<span class="badge bg-red">必須</span>
        </div><!-- /controles -->
    </div><!-- /control-group -->
    <div class="control-group">
        <label class="control-label">フェア紹介文</label>
        <div class="controls">
            {{Form::textarea('mynavi_text',$fair->mynavi->text,array('id'=>'mynavi_text','limit'=>'500','class'=>'counter w450','rows'=>5))}}
            &nbsp;<span class="text-inline">(<span id="mynavi_text_count">{{mb_strlen($fair->mynavi->text)}}</span>/500)</span>
        </div><!-- /controles -->
    </div><!-- /control-group -->
    <!-- 画像 -->
    <div class="control-group">
        <label class="control-label">画像</label>
        <div class="controls">
            {{-- ここに画像 --}}
        </div><!-- /controles -->
        <div class="controls">
            キャプション内容
        </div><!-- /controles -->
    </div><!-- /control-group -->
    <!-- 開催会場 -->
    <div class="control-group">
        <label class="control-label">開催会場</label>
        <div class="controls">
            <label class="control-label">会場選択</label>
            {{Form::select('mynavi_access_data_id',Fair::$hollList,$fair->mynavi->access_data_id or Fair::HOLL_PLACE,array('id'=>'mynavi_access_data_id','class'=>'w80'))}}
        </div><!-- /controles -->
        <div class="controls">
            <label class="control-label">所在地</label>
            {{Form::textarea('mynavi_access_location',$fair->mynavi->access_location,array('id'=>'mynavi_access_location','limit'=>'200','class'=>'w300 counter','rows'=>3))}}
            &nbsp;<span class="text-inline">(<span id="mynavi_access_location_count">{{mb_strlen($fair->mynavi->access_location)}}</span>/300)</span>
            &nbsp;<span class="badge bg-red">必須</span>
        </div><!-- /controles -->
        <div class="controls">
            <label class="control-label">所在地備考</label>
            {{Form::textarea('mynavi_access_location_note',$fair->mynavi->access_location_note,array('id'=>'mynavi_access_location_note','limit'=>'500','class'=>'w450 counter','rows'=>5))}}
            &nbsp;<span class="text-inline">(<span id="mynavi_access_location_note_count">{{mb_strlen($fair->mynavi->access_location_note)}}</span>/500)</span>
        </div><!-- /controles -->
    </div><!-- /control-group -->
    <!-- 予約受付 -->
    <div class="control-group">
        <label class="control-label">予約受付</label>
        <div class="controls">
            <label class="radio inline">{{Form::radio('mynavi_answer_div',FairMynavi::ANSWER_DIV_DOUBLE,$fair->mynavi->answer_div==FairMynavi::ANSWER_DIV_DOUBLE)}}ネット・電話両方で受付</label>
            <label class="radio inline">{{Form::radio('mynavi_answer_div',FairMynavi::ANSWER_DIV_NET,$fair->mynavi->answer_div==FairMynavi::ANSWER_DIV_NET)}}ネットのみで受付</label>
            <label class="radio inline">{{Form::radio('mynavi_answer_div',FairMynavi::ANSWER_DIV_TEL,$fair->mynavi->answer_div==FairMynavi::ANSWER_DIV_TEL)}}電話のみで受付</label>
            &nbsp;<span class="badge bg-red">必須</span>
        </div><!-- /controles -->
    </div><!-- /control-group -->
    <!-- 予約受付期限 -->
    <div class="control-group">
        <label class="control-label">予約受付期限</label>
        <div class="controls">
            <label class="control-label">ネット予約</label>
            {{Form::select('mynavi_answer_limit_net_div',FairMynavi::$answerLimitDivList,$fair->mynavi->answer_limit_net_div,array('class'=>'w80'))}}&nbsp<span class="text-inline">まで</span>&nbsp
            {{Form::select('mynavi_answer_limit_time_net',Fair::$hList,$fair->mynavi->answer_limit_time_net,array('class'=>'hhmm'))}}&nbsp<span class="text-inline">時まで</span>&nbsp
        </div><!-- /controles -->
        <div class="controls">
            <label class="control-label">電話予約</label>
            {{Form::select('mynavi_answer_limit_tel_div',FairMynavi::$answerLimitDivList,$fair->mynavi->answer_limit_tel_div,array('class'=>'w80'))}}&nbsp<span class="text-inline">まで</span>&nbsp
            {{Form::select('mynavi_answer_limit_time_tel',Fair::$hList,$fair->mynavi->answer_limit_time_tel,array('class'=>'hhmm'))}}&nbsp<span class="text-inline">時まで</span>&nbsp
        </div><!-- /controles -->
    </div><!-- /control-group -->
    <!-- 対象者 -->
    <div class="control-group">
        <label class="control-label">対象者</label>
        <div class="controls">
            {{Form::text('mynavi_target_note',$fair->mynavi->target_note,array('id'=>'mynavi_target_note','limit'=>'100','class'=>'counter'))}}
            &nbsp;<span class="text-inline">(<span id="mynavi_target_note_count">{{mb_strlen($fair->mynavi->target_note)}}</span>/100)</span>
        </div><!-- /controles -->
    </div><!-- /control-group -->
    <!-- その他 -->
    <div class="control-group">
        <label class="control-label">その他</label>
        <div class="controls">
            {{Form::textarea('mynavi_etc_note',$fair->mynavi->etc_note,array('id'=>'mynavi_etc_note','limit'=>'500','class'=>'counter w450','rows'=>5))}}
            &nbsp;<span class="text-inline">(<span id="mynavi_etc_note_count">{{mb_strlen($fair->mynavi->etc_note)}}</span>/500)</span>
        </div><!-- /controles -->
    </div><!-- /control-group -->
    <!-- 特典 -->
    <div class="control-group">
        <label class="control-label">特典</label>
        <div class="controls">
            {{Form::textarea('mynavi_special_note',$fair->mynavi->text,array('id'=>'mynavi_special_note','limit'=>'500','class'=>'counter w450','rows'=>5))}}
            &nbsp;<span class="text-inline">(<span id="mynavi_special_note_count">{{mb_strlen($fair->mynavi->special_note)}}</span>/500)</span>
        </div><!-- /controles -->
    </div><!-- /control-group -->
    <!-- 開催時間 -->
    <div class="control-group">
        <label class="control-label">開催時間</label>
        <div class="controls">
            <label class="checkbox inline">{{Form::checkbox('mynavi_plura_flg',Fair::FLG_ON,$fair->mynavi->plura_flg)}}複数部制にする</label>
            <span class="text-inline" style="margin-left:10px">部数</span>
            {{Form::select('mynavi_max_open_time_row',array(1=>1,2=>2,3=>3,4=>4,5=>5),$fair->mynavi->max_open_time_row or 1,array('id'=>'mynavi_max_open_time_row','class'=>'hhmm'))}}
        </div>
        @for($i=1;$i<=5;++$i)
        <?php
            $startHour = 'start_hour_'.$i;
            $startMinute = 'start_minute_'.$i;
            $endHour = 'end_hour_'.$i;
            $endMinute = 'end_minute_'.$i;
        ?>
        <div class="controls">
            <span style="display:inline-block;width:35px;text-align:center">第{{$i}}部</span>
            {{Form::select('mynavi_'.$startHour,Fair::$hList,$fair->mynavi->$startHour,array('id'=>'mynavi_'.$startHour,'class'=>'hhmm'))}}
            &nbsp;:&nbsp;
            {{Form::select('mynavi_'.$startMinute,Fair::$mList,$fair->mynavi->$startMinute,array('id'=>'mynavi_'.$startMinute,'class'=>'hhmm'))}}
            &nbsp;:&nbsp;
            {{Form::select('mynavi_'.$endHour,Fair::$hList,$fair->mynavi->$endHour,array('id'=>'mynavi_'.$endHour,'class'=>'hhmm'))}}
            &nbsp;:&nbsp;
            {{Form::select('mynavi_'.$endMinute,Fair::$mList,$fair->mynavi->$endMinute,array('id'=>'mynavi_'.$endMinute,'class'=>'hhmm'))}}
            &nbsp;
            @if($i===1)
            &nbsp;<span class="badge bg-red">必須</span>
            @endif
        </div><!-- /controles -->
        @endfor
    </div><!-- /control-group -->
    <!--所用時間-->
    <div class="control-group">
        <label class="control-label">所用時間</label>
        <div class="controls">
            {{Form::select('mynavi_need_hour',Fair::$hList,$fair->mynavi->need_hour,array('id'=>'mynavi_need_hour','class'=>'hhmm'))}}
            <span class="text-inline">&nbsp;時間&nbsp;</span>
            {{Form::select('mynavi_need_minute',FairMynavi::$mList,$fair->mynavi->need_minute,array('id'=>'mynavi_need_minute','class'=>'hhmm'))}}
            <span class="text-inline">&nbsp;分</span>
        </div><!-- /controls -->
    </div><!-- /controle-group -->
    <!--フェア内容選択不可-->
    <div class="control-group">
        <div class="controls">
            <label class="checkbox inline">{{Form::checkbox('mynavi_detail_unselect_flg',Fair::FLG_ON,$fair->mynavi->detail_unselect_flg==Fair::FLG_ON)}}フェア内容選択不可</label>
        </div><!-- /controls -->
    </div><!-- /controle-group -->
    <!-- フェアの内容 -->
    @for($i=1;$i<=7;$i++)
    <?php
        $content = isset($this->fair->mynavi->contents[$i]) ? $this->fair->mynavi->contents[$i] : new FairMynaviContent();
        $head = 'mynavi_content_fair_detail_';
    ?>
    <div class="control-group">
        <label class="control-label">フェア内容{{$i}}</label>
        <div class="controls">
            {{Form::select($head.'type_'.$i,FairMynavi::$fairDetailTypeList,$content->fair_detail_type)}}
            {{Form::text($head.'etc_note_'.$i,$content->fair_detail_etc_note,array('id'=>$head.'etc_note_'.$i,'limit'=>'100','class'=>'counter','placeholder'=>'その他内容'))}}
            &nbsp;<span class="text-inline">(<span id="{{$head}}etc_note_{{$i}}_count">{{mb_strlen($content->fair_detail_etc_note)}}</span>/100)</span>
        </div>
        <div class="controls">
            <label class="control-label">予約</label>
            {{Form::select($head.'reserve_div_'.$i,FairMynavi::$fairReserveDivList,$content->fair_detail_reserve_div,array('class'=>'w80'))}}
        </div>
        <div class="controls">
            <label class="control-label">参加料金</label>
            {{Form::select($head.'price_div_'.$i,FairMynavi::$fairPriceDivList,$content->fair_detail_price_div,array('class'=>'w80'))}}
            {{Form::text($head.'price_'.$i,$content->fair_detail_price,array('id'=>$head.'price_'.$i,'maxlength'=>'9','class'=>'w80'))}}<span class="text-inline">&nbsp;円/人</span>
        </div>
        <div class="controls">
            <label class="control-label">開催時間</label>
            {{Form::select($head.'start_hour_'.$i,Fair::$hList,$content->start_hour,array('id'=>$head.'start_hour_'.$i,'class'=>'hhmm'))}}
            &nbsp;:&nbsp;
            {{Form::select($head.'start_minute_'.$i,Fair::$mList,$content->start_minute,array('id'=>$head.'start_minute_'.$i,'class'=>'hhmm'))}}
            &nbsp;:&nbsp;
            {{Form::select($head.'end_hour_'.$i,Fair::$hList,$content->end_hour,array('id'=>$head.'end_hour_'.$i,'class'=>'hhmm'))}}
            &nbsp;:&nbsp;
            {{Form::select($head.'end_minute_'.$i,Fair::$mList,$content->end_minute,array('id'=>$head.'end_minute_'.$i,'class'=>'hhmm'))}}
        </div>
        <div class="controls">
            <label class="control-label">見出し</label>
            {{Form::text($head.'headline_'.$i,$content->fair_detail_headline,array('id'=>$head.'headline_'.$i,'class'=>'counter','limit'=>'100'))}}
            &nbsp;<span class="text-inline">(<span id="{{$head}}headline_{{$i}}_count">{{mb_strlen($content->fair_detail_headline)}}</span>/100)</span>
        </div>
        <div class="controls">
            <label class="control-label">補足</label>
            {{Form::textarea($head.'complement_'.$i,$content->fair_detail_complement,array('id'=>$head.'complement_'.$i,'class'=>'counter w450','limit'=>'500','rows'=>'4'))}}
            &nbsp;<span class="text-inline">(<span id="{{$head}}complement_{{$i}}_count">{{mb_strlen($content->fair_detail_complement)}}</span>/500)</span>
        </div>
    </div><!-- /controle-group -->
    @endfor
    <hr/>
</fieldset>