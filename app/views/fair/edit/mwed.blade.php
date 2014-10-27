<fieldset id="page_mwed" style="display:none">
    <div class="control-group">
        <label class="control-label">フェア名称</label>
        <div class="controls">
            {{Form::text('mwed_fair_title',$fair->mwed->fair_title,array('id'=>'mwed_fair_title','limit'=>'30','class'=>'counter'))}}
            &nbsp;<span class="text-inline">(<span id="mwed_fair_title_count">{{mb_strlen($fair->mwed->fair_title)}}</span>/30)</span>
            &nbsp;<span class="badge bg-red">必須</span>
        </div><!-- /controles -->
    </div><!-- /control-group -->
    <div class="control-group">
        <label class="control-label">開催時刻</label>
        <div class="controls">
            {{Form::select('mwed_st_hour',Fair::$hList,$fair->mwed->st_hour,array('id'=>'mwed_st_hour','class'=>'hhmm'))}}
            &nbsp;:&nbsp;
            {{Form::select('mwed_st_min',Fair::$mList,$fair->mwed->st_min,array('id'=>'mwed_st_min','class'=>'hhmm'))}}
            &nbsp;～&nbsp;
            {{Form::select('mwed_ed_hour',Fair::$hList,$fair->mwed->ed_hour,array('id'=>'mwed_ed_hour','class'=>'hhmm'))}}
            &nbsp;:&nbsp;
            {{Form::select('mwed_ed_min',Fair::$mList,$fair->mwed->ed_min,array('id'=>'mwed_ed_min','class'=>'hhmm'))}}
            &nbsp;<span class="badge bg-red">必須</span>
        </div><!-- /controles -->
        <div class='controls'>
            <label class="checkbox inline">{{Form::checkbox('mwed_registration_flg',Fair::FLG_ON,$fair->mwed->registration_flg)}}ユーザ参加希望時間指定</label>
        </div>
    </div><!-- /control-group -->
    <!--含まれるフェア内容-->
    <div class="control-group">
        <label class="control-label" for="pack_flg">含まれるフェアタイプ</label>
        @foreach(FairMwed::$fairTypeList as $value => $view)
        <div class="controls">
            <label class="checkbox inline">{{Form::checkbox('mwed_'.$value,Fair::FLG_ON,$fair->mwed->$value,array('id'=>'mwed_'.$value))}}{{$view}}</label>
        </div><!-- /controls -->
        @endforeach
    </div><!-- /controle-group -->
    <!--フェア内容詳細-->

    <div class="control-group">
        <label class="control-label">フェア詳細</label>
        @for($i=1;$i<=16;++$i)
        <?php
            $content = isset($fair->mwed->contents[$i-1]) ? $fair->mwed->contents[$i-1] : new FairMwedContent();
            $dtType = 'dt_type_'.$i;
            $dtStHour = 'dt_st_hour_'.$i;
            $dtStMin = 'dt_st_min_'.$i;
            $dtEdHour = 'dt_ed_hour_'.$i;
            $dtEdMin = 'dt_ed_min_'.$i;
        ?>
        <div class="controls">
            <span style="display:inline-block;text-align:center;width:15px;">{{$i}}</span>
            {{Form::select('mwed_content_'.$dtType,FairMwed::$dtTypeList,$content->dt_type,array('id'=>'mwed_'.$dtType))}}
            &nbsp;&nbsp;&nbsp;&nbsp;
            {{Form::select('mwed_content_'.$dtStHour,Fair::$hList,$content->dt_st_hour,array('id'=>'mwed_content_','class'=>'hhmm'))}}
            &nbsp;:&nbsp;
            {{Form::select('mwed_content_'.$dtStMin,Fair::$mList,$content->dt_st_min,array('id'=>'mwed_content_','class'=>'hhmm'))}}
            &nbsp;～&nbsp;
            {{Form::select('mwed_content_'.$dtEdHour,Fair::$hList,$content->dt_ed_hour,array('id'=>'mwed_content_','class'=>'hhmm'))}}
            &nbsp;:&nbsp;
            {{Form::select('mwed_content_'.$dtEdMin,Fair::$mList,$content->dt_ed_min,array('id'=>'mwed_content_','class'=>'hhmm'))}}
        </div><!-- /controls -->
        @endfor
        <div class="controls">
            <label class="control-label">その他1</label>
            {{Form::text('mwed_etc1_txt',$fair->mwed->etc1_txt,array('id'=>'mwed_etc1_txt','limit'=>'15','class'=>'counter','placeholder'=>'タイトル入力'))}}
            &nbsp;<span class="text-inline">(<span id="mwed_etc1_txt_count">{{mb_strlen($fair->mwed->etc1_txt)}}</span>/15)</span>
        </div><!-- /controls -->
        <div class="controls">
            <label class="control-label">その他2</label>
            {{Form::text('mwed_etc2_txt',$fair->mwed->etc2_txt,array('id'=>'mwed_etc2_txt','limit'=>'15','class'=>'counter','placeholder'=>'タイトル入力'))}}
            &nbsp;<span class="text-inline">(<span id="mwed_etc2_txt_count">{{mb_strlen($fair->mwed->etc2_txt)}}</span>/15)</span>
        </div><!-- /controls -->
    </div><!-- /controle-group -->
    <hr/>
    <!-- 説明文 -->
    <div class="control-group">
        <label class="control-label">説明文</label>
        <div class="controls">
            {{Form::textarea('mwed_plan_txt',$fair->mwed->plan_txt,array('id'=>'mwed_plan_txt','limit'=>'300','class'=>'counter w450','rows'=>'3'))}}
            &nbsp;<span class="text-inline">(<span id="mwed_plan_txt_count">{{mb_strlen($fair->mwed->plan_txt)}}</span>/300)</span>
        </div><!-- /controls -->
    </div><!-- /controle-group -->
    <!-- 特典 -->
    <div class="control-group">
        <label class="control-label">特典</label>
        <div class="controls">
            {{Form::text('mwed_priv_txt',$fair->mwed->priv_txt,array('id'=>'mwed_priv_txt','limit'=>'50','class'=>'counter'))}}
            &nbsp;<span class="text-inline">(<span id="mwed_priv_txt_count">{{mb_strlen($fair->mwed->priv_txt)}}</span>/50)</span>
        </div><!-- /controls -->
    </div><!-- /controle-group -->
    <hr/>
    <!-- 予約 -->
    <div class="control-group">
        <label class="control-label">予約</label>
        <div class="controls">
            <label class="radio inline">{{Form::radio('mwed_reserve',FairMwed::RESERVE_NEED,$fair->mwed->reserve==FairMwed::RESERVE_NEED)}}要予約</label>
            <label class="radio inline">{{Form::radio('mwed_reserve',FairMwed::RESERVE_PRIORITY,$fair->mwed->reserve==FairMwed::RESERVE_PRIORITY)}}予約優先</label>
            <label class="radio inline">{{Form::radio('mwed_reserve',FairMwed::RESERVE_NONE,$fair->mwed->reserve==FairMwed::RESERVE_NONE)}}予約不要</label>
        </div><!-- /controls -->
        <div class="controls">
            <label class="control-label">補足説明</label>
            {{Form::text('mwed_reserve_txt',$fair->mwed->reserve_txt,array('id'=>'mwed_reserve_txt','limit'=>'20','class'=>'counter'))}}
            &nbsp;<span class="text-inline">(<span id="mwed_reserve_txt_count">{{mb_strlen($fair->mwed->reserve_txt)}}</span>/20)</span>
        </div><!-- /controls -->
    </div><!-- /controle-group -->
    <hr/>
    <!-- 料金 -->
    <div class="control-group">
        <label class="control-label">料金</label>
        <div class="controls">
            <label class="radio inline">{{Form::radio('mwed_rate',FairMwed::RATE_FREE,$fair->mwed->rate==FairMwed::RATE_FREE)}}無料</label>
            <label class="radio inline">{{Form::radio('mwed_rate',FairMwed::RATE_PAY,$fair->mwed->rate==FairMwed::RATE_PAY)}}有料</label>
            <label class="radio inline">{{Form::radio('mwed_rate',FairMwed::RATE_PART_PAY,$fair->mwed->rate==FairMwed::RATE_PART_PAY)}}一部有料</label>
            <label class="radio inline">{{Form::radio('mwed_rate',FairMwed::RATE_NONE,$fair->mwed->rate==FairMwed::RATE_NONE)}}設定なし</label>
        </div><!-- /controls -->
        <div class="controls">
            <label class="control-label">補足説明</label>
            {{Form::text('mwed_rate_txt',$fair->mwed->rate_txt,array('id'=>'mwed_rate_txt','limit'=>'20','class'=>'counter'))}}
            &nbsp;<span class="text-inline">(<span id="mwed_rate_txt_count">{{mb_strlen($fair->mwed->rate_txt)}}</span>/20)</span>
        </div><!-- /controls -->
    </div><!-- /controle-group -->
    <hr/>
</fieldset>