<fieldset id="page_gnavi" style="display:none">
    <div class="control-group">
        <label class="control-label" for="fair_name">フェア名</label>
        <div class="controls">
            {{Form::text('gnavi_fair_title',$fair->gnavi->fair_title,array('id'=>'gnavi_fair_title','limit'=>'35','class'=>'counter'))}}
            &nbsp;<span class="text-inline">(<span id="gnavi_fair_title_count">{{mb_strlen($fair->gnavi->fair_title)}}</span>/35)</span>
            &nbsp;<span class="badge bg-red">必須</span>
        </div><!-- /controles -->
    </div><!-- /control-group -->
    <div class="control-group">
        <label class="control-label">開催時刻</label>
        <div class="controls">
            {{Form::select('gnavi_fair_time_start_h',Fair::$hList,$fair->gnavi->fair_time_start_h,array('id'=>'gnavi_fair_time_start_h','class'=>'hhmm'))}}
            &nbsp;:&nbsp;
            {{Form::select('gnavi_fair_time_start_m',Fair::$mList,$fair->gnavi->fair_time_start_m,array('id'=>'gnavi_fair_time_start_m','class'=>'hhmm'))}}
            &nbsp;～&nbsp;
            {{Form::select('gnavi_fair_time_end_h',Fair::$hList,$fair->gnavi->fair_time_end_h,array('id'=>'gnavi_fair_time_end_h','class'=>'hhmm'))}}
            &nbsp;:&nbsp;
            {{Form::select('gnavi_fair_time_end_m',Fair::$mList,$fair->gnavi->fair_time_end_m,array('id'=>'gnavi_fair_time_end_m','class'=>'hhmm'))}}
            &nbsp;<span class="badge bg-red">必須</span>
        </div><!-- /controles -->
        <div class='controls'>
            <label class="checkbox inline">{{Form::checkbox('gnavi_registration_flg',Fair::FLG_ON,$fair->gnavi->registration_flg)}}ユーザ参加希望時間指定</label>
        </div>
    </div><!-- /control-group -->
    <!-- 画像 -->
    <div class="control-group">
        <label class="control-label" for="description">画像</label>
        <div class="controls">
            {{--ここに画像--}}
        </div><!-- /controls -->
        <div class='controls'>
            <label class='control-label'>画像説明</label>
            {{Form::text('gnavi_fair_img_alt',$fair->gnavi->fair_img_alt,array('id'=>'gnavi_fair_img_alt','limit'=>'30','class'=>'counter'))}}
            &nbsp;<span class="text-inline">(<span id="gnavi_fair_img_alt_count">{{mb_strlen($fair->gnavi->fair_img_alt)}}</span>/30)</span>
        </div><!-- /controls -->
    </div><!-- /control-group -->
    <!-- フェア内容 -->
    <div class="control-group">
        <label class="control-label" for="target">キャッチコピー</label>
        <div class="controls">
            {{Form::text('gnavi_fair_catch',$fair->gnavi->fair_catch,array('id'=>'gnavi_fair_catch','limit'=>'30','class'=>'counter'))}}
            &nbsp;<span class="text-inline">(<span id="gnavi_fair_catch_count">{{mb_strlen($fair->gnavi->fair_catch)}}</span>/50)</span>
        </div><!-- /controles -->
    </div><!-- /control-group -->
    <div class="control-group">
        <label class='control-label'>フェア内容詳細</label>
        <div class="controls">
            {{Form::text('gnavi_fair_read',$fair->gnavi->fair_read,array('id'=>'gnavi_fair_read','limit'=>'250','class'=>'counter'))}}
            &nbsp;<span class="text-inline">(<span id="gnavi_fair_read_count">{{mb_strlen($fair->gnavi->fair_read)}}</span>/250)</span>
        </div><!-- /controles -->
    </div><!-- /control-group -->
    <!--予約-->
    <div class="control-group">
        <label class="control-label" for="other_description">予約</label>
        <div class="controls">
            <label class='checkbox inline'>{{Form::checkbox('gnavi_icon_flg',Fair::FLG_ON,$fair->gnavi->icon_flg==Fair::FLG_ON)}}要予約</label>
            <label class='checkbox inline'>{{Form::checkbox('gnavi_icon_flg',Fair::FLG_OFF,$fair->gnavi->icon_flg==Fair::FLG_OFF)}}予約不要</label>
        </div><!-- /controles -->
    </div><!-- /control-group -->
    <!-- 複数部制の場合の時間 -->
    <div class="control-group">
        <label class="control-label">スケジュール</label>
        <div class="control-group-group">
            @for ($i=1;$i<=5;++$i)
            <div class="controls">
                <label class="control-label">段取り{{$i}}</label>
                <?php
                    $timeH = 'program_time_'.$i.'_h';
                    $timeM = 'program_time_'.$i.'_m';
                    $comment = 'program_comment_'.$i;
                ?>
                {{Form::select("gnavi_program_time_".$i."_h",Fair::$hList,$fair->gnavi->$timeH,array('id'=>"gnavi_program_time_".$i."_h",'class'=>'hhmm'))}}
                &nbsp;:&nbsp;
                {{Form::select("gnavi_program_time_".$i."_m",Fair::$mList1,$fair->gnavi->$timeM,array('id'=>"gnavi_program_time_".$i."_m",'class'=>'hhmm'))}}
            </div><!-- /controles -->
            <div class='controls'>
                <label class="control-label">詳細</label>
                {{Form::text('gnavi_program_comment_'.$i,$fair->gnavi->$comment,array('id'=>'gnavi_program_comment_'.$i,'limit'=>'40','class'=>'counter'))}}
                &nbsp;<span class="text-inline">(<span id="gnavi_program_comment_{{$i}}_count">{{mb_strlen($fair->gnavi->$comment)}}</span>/40)</span>
            </div><!-- /controles -->
            @endfor
        </div><!-- /control-group-group -->
    </div><!-- /control-group -->
    <!--ココに注目-->
    <div class="control-group">
        <label class="control-label" for="other_description">ココに注目</label>
        <div class="controls">
            {{Form::text('gnavi_fair_point',$fair->gnavi->fair_point,array('id'=>'gnavi_fair_point','limit'=>'30','class'=>'counter'))}}
            &nbsp;<span class="text-inline">(<span id="fair_point_count">{{mb_strlen($fair->gnavi->fair_point)}}</span>/30)</span>
        </div><!-- /controles -->
    </div><!-- /control-group -->
    <!--まとめて予約設定-->
    <div class="control-group">
        <label class="control-label" for="pack_flg">フェアタイプ</label>
        @foreach(FairGnavi::$fairTypeList as $value => $view)
        <div class="controls">
            <label class="checkbox inline">{{Form::checkbox('gnavi_'.$value,Fair::FLG_ON,$fair->gnavi->$value,array('id'=>'gnavi_'.$value))}}{{$view}}</label>
            @if($value === 'tasting_flg')
            <div class='controls-inline'>
                <label class="control-label">有料/無料</label>
                <div class='controls'>
                    <label class='radio inline'>{{Form::radio('gnavi_fair_tasteing_flg',FairGnavi::FAIR_TASTEING_FLG_PAY,$fair->gnavi->fair_tasteing_flg==FairGnavi::FAIR_TASTEING_FLG_PAY)}}有料</label>
                    <label class='radio inline'>{{Form::radio('gnavi_fair_tasteing_flg',FairGnavi::FAIR_TASTEING_FLG_NOPAY,$fair->gnavi->fair_tasteing_flg==FairGnavi::FAIR_TASTEING_FLG_NOPAY)}}無料</label>
                </div><!-- /controls -->
                <label class="control-label">値段</label>
                <div class='controls'>
                    {{Form::text('gnavi_pay_tasting_price',$fair->gnavi->pay_tasting_price,array('id'=>'gnavi_pay_tasting_price','maxlength'=>8))}}
                </div><!-- /controls -->
                <label class="control-label">消費税</label>
                <div class='controls'>
                    <label class="control-label">扱い</label>
                    <label class='radio inline'>{{Form::radio('gnavi_option_tax',FairGnavi::OPTION_TAX_INCLUDED,$fair->gnavi->option_tax==FairGnavi::OPTION_TAX_INCLUDED)}}税込</label>
                    <label class='radio inline'>{{Form::radio('gnavi_option_tax',FairGnavi::OPTION_TAX_EXCLUDING,$fair->gnavi->option_tax==FairGnavi::OPTION_TAX_EXCLUDING)}}税抜</label>
                </div><!-- /controls -->
                <div class='controls'>
                    <label class="control-label">計算方法</label>
                    <label class='radio inline'>{{Form::radio('gnavi_option_round_tax',FairGnavi::OPTION_ROUND_TAX_OFF,$fair->gnavi->option_round_tax==FairGnavi::OPTION_ROUND_TAX_OFF)}}四捨五入</label>
                    <label class='radio inline'>{{Form::radio('gnavi_option_round_tax',FairGnavi::OPTION_ROUND_TAX_DOWN,$fair->gnavi->option_round_tax==FairGnavi::OPTION_ROUND_TAX_DOWN)}}切り捨て</label>
                    <label class='radio inline'>{{Form::radio('gnavi_option_round_tax',FairGnavi::OPTION_ROUND_TAX_UP,$fair->gnavi->option_round_tax==FairGnavi::OPTION_ROUND_TAX_UP)}}切り上げ</label>
                </div><!-- /controls -->
            </div><!-- /controls-inline -->
            @endif
        </div><!-- /controls -->
        @endforeach
    </div><!-- /controle-group -->
    <!--フリー検索ワード-->
    <div class="control-group">
        <label class="control-label" for="other_description">検索ワード</label>
        <div class="controls">
            {{Form::text('gnavi_freeword_search',$fair->gnavi->freeword_search,array('id'=>'gnavi_freeword_search','limit'=>'512','class'=>'counter w300'))}}
            &nbsp;<span class="text-inline">(<span id="gnavi_freeword_search_count">{{mb_strlen($fair->gnavi->freeword_search)}}</span>/512)</span>
        </div><!-- /controles -->
    </div><!-- /control-group -->
    <!--定員-->
    <div class="control-group">
        <label class="control-label" for="other_description">定員</label>
        <div class="controls">
            {{Form::text('gnavi_freeword_search',$fair->gnavi->customer_count,array('id'=>'gnavi_customer_count','limit'=>'3','max-length'=>'3','class'=>'counter w30'))}}
            &nbsp;<span class="text-inline">(<span id="gnavi_customer_count_count">{{mb_strlen($fair->gnavi->customer_count)}}</span>/3)</span>
        </div><!-- /controles -->
    </div><!-- /control-group -->
    <!--予約ボタン-->
    <div class="control-group">
        <label class="control-label" for="other_description">予約ボタン</label>
        <div class="controls">
            <label class='radio inline'>{{Form::radio('gnavi_reserve_flg',Fair::FLG_ON,$fair->gnavi->reserve_flg==Fair::FLG_ON)}}表示</label>
            <label class='radio inline'>{{Form::radio('gnavi_reserve_flg',Fair::FLG_OFF,$fair->gnavi->reserve_flg==Fair::FLG_OFF)}}非表示</label>
        </div><!-- /controles -->
    </div><!-- /control-group -->
    <hr/>
</fieldset>