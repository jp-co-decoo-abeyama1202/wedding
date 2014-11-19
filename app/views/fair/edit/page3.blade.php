<fieldset id="page_3">
    <h3>3.基本フェア構成作成</h3>
    @for($i=1;$i<=8;++$i)
    <div class="control-group" id="fair_{{$i}}">
        <label class="control-label">フェア内容{{$i}}</label>
        <div class="controls">
            <div class='controls-inline'>
                <label class="control-label">コンテンツ</label>
                <div class='controls'>
                    <a href="#contents_select_modal" role="button" class="btn btn-contentsmodal" data-toggle="modal" target='{{$i}}'>選択</a>
                    {{Form::hidden('content_id_'.$i,'',array('id'=>'content_id_'.$i))}}
                    {{Form::text('','',array('readonly'=>'readonly','placeholder'=>'ここに選択した内容が入ります','id'=>'content_text_'.$i,'class'=>'w350'))}}
                </div><!-- /controles -->
                <div id="fair-contents-{{$i}}" class="hide">
                    <label class="control-label">タイトル</label>
                    <div class="controls">
                        {{Form::text('content_title_'.$i,'',array('id'=>'content_title_'.$i,'class'=>'counter','limit'=>'30'))}}
                        &nbsp;<span class="text-inline">(<span id="content_title_{{$i}}_count">{{mb_strlen('')}}</span>/30)</span>
                        &nbsp;<span class="badge bg-red">必須</span>
                    </div><!-- /controles -->
                    <label class="control-label">所用時間</label>
                    <div class="controls">
                        {{Form::select("content_shoyo_h_".$i,Fair::$hList,null,array('id'=>"content_shoyo_h_".$i,'class'=>'hhmm shoyo_h'))}}<span class="text-inline">&nbsp;時&nbsp;</span>
                        {{Form::select("content_shoyo_m_".$i,Fair::$mList,null,array('id'=>"content_shoyo_m_".$i,'class'=>'hhmm shoyo_m'))}}<span class="text-inline">&nbsp;分&nbsp;</span>
                        &nbsp;<span class="badge bg-red">必須</span>
                    </div><!-- /controles -->
                    <label class="control-label">フェア内容説明文</label>
                    <div class="controls">
                        {{Form::textarea('content_description_'.$i,'',array('id'=>'content_description_'.$i,'class'=>'counter w300','limit'=>'100','rows'=>'2'))}}
                        &nbsp;<span class="text-inline">(<span id="content_description_{{$i}}_count">{{mb_strlen('')}}</span>/100)</span>
                        &nbsp;<span class="badge bg-red">必須</span>
                    </div><!-- /controles -->
                    <label class="control-label">予約有無</label>
                    <div class="controls">
                        {{Form::select('content_reserve_'.$i,FairContent::$reserveList,'',array('id'=>'content_reserve_'.$i,'class'=>'w100'))}}
                        &nbsp;<span class="badge bg-red">必須</span>
                    </div><!-- /controles -->
                    <label class="control-label">有料/無料</label>
                    <div class="controls">
                        {{Form::select('content_price_flg_'.$i,FairContent::$priceFlagList,'',array('id'=>'content_price_flg_'.$i,'class'=>'w100 views','view'=>'content_prices_'.$i,'view_value'=>FairContent::PRICE_FLG_ON))}}
                        &nbsp;<span class="badge bg-red">必須</span>
                    </div><!-- /controles -->
                    <label class="control-label">料金</label>
                    <div class="controls">
                        {{Form::text('content_price_'.$i,'',array('id'=>'content_price_'.$i))}}&nbsp;<span class="text-inline">円/人</span>
                        <span id="content_prices_{{$i}}" class="hide">&nbsp;<span class="badge bg-red">必須</span></span>
                    </div><!-- /controles -->
                    <label class="control-label">個別フェア在庫数</label>
                    <div class="controls">
                        {{Form::text('content_stock_'.$i,'',array('id'=>'content_stock_'.$i,'class'=>'hhmm','maxlength'=>'3'))}}
                    </div><!-- /controles -->
                    <label class="control-label">削除</label>
                    <div class="controls">
                        {{Form::button('コンテンツクリア',array('class'=>'btn btn-danger btn-contents-clear','target'=>$i))}}
                    </div><!-- /controles -->
                </div><!-- /fair-contents-{{$i}} -->
            </div><!-- controls-inline -->
        </div><!-- /controls -->
    </div><!-- /control-group -->
    <hr/>
    @endfor
    <div class="control-group">
        <label class="control-label">所用時間</label>
        <div class="controls">
            <label class="control-label">合計</label>
            {{Form::select("shoyo_sum_h",Fair::$hList,0,array('id'=>"shoyo_sum_h",'class'=>'hhmm'))}}<span class="text-inline">&nbsp;時&nbsp;</span>
            {{Form::select("shoyo_sum_m",Fair::$mList,0,array('id'=>"shoyo_sum_m",'class'=>'hhmm'))}}<span class="text-inline">&nbsp;分&nbsp;</span>
            &nbsp;<span class="badge bg-blue">自動計算</span>
        </div><!-- /controles -->
    </div><!-- control-group-->
    <hr/>
    <div class="control-group">
        <label class="control-label">部制選択</label>
        <div class="controls">
            <label class="control-label"></label>
            {{Form::select('tour_count',array(1=>1,2=>2,3=>3,4=>4,5=>5),$fair->tour_count or 1,array('id'=>'tour_count','class'=>'hhmm'))}}&nbsp;<span class="badge bg-red">必須</span>
        </div><!-- /controles -->
    </div><!-- /control-group -->
    <!-- 複数部制の場合の時間 -->
    <div class="control-group">
        <label class="control-label">複数部設定</label>
        <div class="controls">
            <div class="controls-inline">
                @for ($i=1;$i<=5;++$i)
                <div id="tours_{{$i}}" class="tours" style="{{$fair->tour_count or 1 >= $i ? '':'display:none'}}">
                    <label class="control-label">第{{$i}}部</label>
                    <div class="controls">
                        <?php
                            $startH = 'tour_'.$i.'_start_h';
                            $startM = 'tour_'.$i.'_start_m';
                            $endH = 'tour_'.$i.'_end_h';
                            $endM = 'tour_'.$i.'_end_m';
                        ?>
                        {{Form::select("tour_".$i."_start_h",Fair::$hList,$fair->$startH,array('id'=>"tour_".$i."_start_h",'class'=>'hhmm'))}}
                        &nbsp;:&nbsp;
                        {{Form::select("tour_".$i."_start_m",Fair::$mList,$fair->$startM,array('id'=>"tour_".$i."_start_m",'class'=>'hhmm'))}}
                        &nbsp;～&nbsp;
                        {{Form::select("tour_".$i."_end_h",Fair::$hList,$fair->$endH,array('id'=>"tour_".$i."_end_h",'class'=>'hhmm'))}}
                        &nbsp;:&nbsp;
                        {{Form::select("tour_".$i."_end_m",Fair::$mList,$fair->$endM,array('id'=>"tour_".$i."_end_m",'class'=>'hhmm'))}}&nbsp;<span class="badge bg-red">必須</span>
                    </div><!-- /controles -->
                </div>
                @endfor
            </div><!-- /controls-inline -->
        </div><!-- /controls -->
    </div><!-- /control-group -->
    @include('fair.edit.footbutton')
</fieldset>