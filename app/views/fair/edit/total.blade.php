<fieldset id="page_total">
    <div class="control-group">
        <label class="control-label">出稿サイト選択</label>
        <div class="controls">
            <label class="checkbox inline">{{Form::checkbox('flg_gnavi',Fair::FLG_ON,$fair->flg_gnavi,array('class'=>'site_flg','view'=>'gnavi'))}}ぐるナビ</label>
            <label class="checkbox inline">{{Form::checkbox('flg_mwed',Fair::FLG_ON,$fair->flg_mwed,array('class'=>'site_flg','view'=>'mwed'))}}みんなの</label>
            <label class="checkbox inline">{{Form::checkbox('flg_mynavi',Fair::FLG_ON,$fair->flg_mynavi,array('class'=>'site_flg','view'=>'mynavi'))}}マイナビ</label>
            <label class="checkbox inline">{{Form::checkbox('flg_park',Fair::FLG_ON,$fair->flg_park,array('class'=>'site_flg','view'=>'park'))}}パーク</label>
        </div><!-- /controls -->
        <div class="controls">
            <label class="checkbox inline">{{Form::checkbox('flg_rakuten',Fair::FLG_ON,$fair->flg_rakuten,array('class'=>'site_flg','view'=>'rakuten'))}}楽天</label>
            <label class="checkbox inline">{{Form::checkbox('flg_sugukon',Fair::FLG_ON,$fair->flg_sugukon,array('class'=>'site_flg','view'=>'sugukon'))}}すぐ婚</label>
            <label class="checkbox inline">{{Form::checkbox('flg_zexy',Fair::FLG_ON,$fair->flg_zexy,array('class'=>'site_flg','view'=>'zexy'))}}ゼクシィ</label>
        </div><!-- /controls -->
    </div><!-- /control-group -->
    <div class="control-group">
        <label class="control-label" for="fair_name">フェア名</label>
        <div class="controls">
            {{Form::text('fair_name',$fair->fair_name,array('id'=>'fair_name','limit'=>'30','class'=>'counter'))}}
            &nbsp;<span class="text-inline">(<span id="fair_name_count">{{mb_strlen($fair->fair_name)}}</span>/30)</span>
            &nbsp;<span class="badge bg-red">必須</span>
        </div><!-- /controles -->
    </div><!-- /control-group -->
    <div class="control-group">
        <label class="control-label">開催時間</label>
        <div class="controls">
            {{Form::select('start_h',Fair::$hList,$fair->start_h,array('id'=>'start_h','class'=>'hhmm'))}}
            &nbsp;:&nbsp;
            {{Form::select('start_m',Fair::$mList,$fair->start_m,array('id'=>'start_m','class'=>'hhmm'))}}
            &nbsp;～&nbsp;
            {{Form::select('end_h',Fair::$hList,$fair->end_h,array('id'=>'end_h','class'=>'hhmm'))}}
            &nbsp;:&nbsp;
            {{Form::select('end_m',Fair::$mList,$fair->end_m,array('id'=>'end_m','class'=>'hhmm'))}}
            &nbsp;<span class="badge bg-red">必須</span>
        </div><!-- /controles -->
    </div><!-- /control-group -->
    <div class="control-group">
        <label class="control-label" for="description">フェア説明</label>
        <div class="controls">
            {{Form::textarea('description',$fair->description,array('id'=>'description','limit'=>'100','rows'=>'3','class'=>'w300 counter'))}}
            &nbsp;<span class="text-inline">(<span id="description_count">{{mb_strlen($fair->description)}}</span>/100)</span>
            &nbsp;<span class="badge bg-red">必須</span>
        </div><!-- /controles -->
    </div><!-- /control-group -->
    <div class="control-group">
        <label class="control-label" for="target">対象者</label>
        <div class="controls">
            {{Form::text('target',$fair->target,array('id'=>'target','limit'=>'50','class'=>'counter'))}}
            &nbsp;<span class="text-inline">(<span id="target_count">{{mb_strlen($fair->target)}}</span>/50)</span>
        </div><!-- /controles -->
    </div><!-- /control-group -->
    <div class="control-group">
        <label class="control-label" for="other_description">その他</label>
        <div class="controls">
            {{Form::textarea('other_description',$fair->other_description,array('id'=>'other_description','limit'=>'100','rows'=>'3','class'=>'w300 counter'))}}
            &nbsp;<span class="text-inline">(<span id="other_description_count">{{mb_strlen($fair->other_description)}}</span>/100)</span>
        </div>
    </div><!-- /control-group -->
    <div class="control-group">
        <label class="control-label">部制選択</label>
        <div class="controls">
            {{Form::select('tour_count',array(1=>1,2=>2,3=>3,4=>4,5=>5),$fair->tour_count or 1,array('id'=>'tour_count','class'=>'hhmm'))}}&nbsp;<span class="badge bg-red">必須</span>
        </div><!-- /controles -->
    </div><!-- /control-group -->
    <!-- 複数部制の場合の時間 -->
    <div class="control-group" id="tour_area">
        <label class="control-label">複数部設定</label>
        <div class="control-group-group">
            @for ($i=1;$i<=5;++$i)
            <div class="controls">
                <label class="control-label">第{{$i}}部</label>
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
                {{Form::select("tour_".$i."_end_m",Fair::$mList,$fair->$endM,array('id'=>"tour_".$i."_end_m",'class'=>'hhmm'))}}
            </div><!-- /controles -->
            @endfor
        </div><!-- /control-group-group -->
    </div><!-- /control-group -->
    <!--まとめて予約設定-->
    <div class="control-group">
        <label class="control-label" for="pack_flg">まとめて予約</label>
        <div class="controls">
            <label class="checkbox inline" for="pack_flg">
            {{Form::checkbox('pack_flg',Fair::FLG_ON,$fair->pack_flg,array('id'=>'pack_flg'))}}まとめて予約設定
            </label>
        </div><!-- /controles -->
    </div><!-- /controle-group -->
    <hr/>
    <!-- フェア内容 -->
    <div class="control-group" id="fair_1">
        <label class="control-label">フェア内容</label>
        <div class="control-group-group" id="tour_area">
            <div class="controls">
                <label class="control-label">フェア内容</label>
                {{Form::button('選択')}}
                {{Form::text('','',array('readonly'=>'readonly','placeholder'=>'ここに選択した内容が入ります'))}}
            </div><!-- /controles -->

            <div class="controls">
                <label class="control-label">その他内容</label>
                {{Form::text('content_1_title','',array('class'=>'counter'))}}
                &nbsp;<span class="text-inline">(<span id="content_1_title_count">{{mb_strlen('')}}</span>/15)</span>
            </div><!-- /controles -->
            <div class="controls">
                <label class="control-label">予約有無</label>
                {{Form::select('content_1_reserve',FairContent::$reserveList)}}
            </div><!-- /controles -->
            <div class="controls">
                <label class="control-label">有料/無料</label>
                {{Form::select('content_1_price_flg',FairContent::$priceFlagList)}}
            </div><!-- /controles -->
            <div class="controls content_price_field">
                <label class="control-label">料金</label>
                {{Form::text('content_1_price','')}}
            </div><!-- /controles -->
            <div class="controls">
                <label class="control-label">所用時間</label>
                {{Form::select("tour_".$i."_start_h",Fair::$hList,0,array('id'=>"tour_".$i."_start_h",'class'=>'hhmm'))}}<span class="text-inline">&nbsp;時間&nbsp;</span>
                {{Form::select("tour_".$i."_start_m",Fair::$mList,0,array('id'=>"tour_".$i."_start_m",'class'=>'hhmm'))}}<span class="text-inline">&nbsp;分&nbsp;</span>
            </div><!-- /controles -->
            <div class="controls">
                <label class="control-label">個別フェア<br/>時間設定</label>
                <label class="checkbox inline" for="pack_flg">
                {{Form::checkbox('pack_flg',Fair::FLG_ON,$fair->pack_flg,array('id'=>'pack_flg'))}}設定する
                </label>
                <div class="controls-inline">
                {{Form::select("tour_".$i."_start_h",Fair::$hList,0,array('id'=>"tour_".$i."_start_h",'class'=>'hhmm'))}}
                &nbsp;:&nbsp;
                {{Form::select("tour_".$i."_start_m",Fair::$mList,0,array('id'=>"tour_".$i."_start_m",'class'=>'hhmm'))}}
                &nbsp;～&nbsp;
                {{Form::select("tour_".$i."_end_h",Fair::$hList,0,array('id'=>"tour_".$i."_end_h",'class'=>'hhmm'))}}
                &nbsp;:&nbsp;
                {{Form::select("tour_".$i."_end_m",Fair::$mList,0,array('id'=>"tour_".$i."_end_m",'class'=>'hhmm'))}}
                </div><!-- /controls-inline -->
            </div><!-- /controles -->
        </div><!-- /control-group-group -->
    </div><!-- /control-group -->
    <hr/>
    <!--画像選択設定-->
    <div class="control-group">
        <label class="control-label">画像</label>
        <div class="controls" style="padding-bottom:5px;">
            <label class="control-label">画像選択</label>
            {{Form::button('選択')}}
            {{Form::text('','',array('readonly'=>'readonly','placeholder'=>'ここに画像ファイル名が入ります'))}}&nbsp;<span class="badge bg-red">必須</span>
        </div><!-- /controles -->
        <div class="controls">
            <label class="control-label">画像説明</label>
            {{Form::text('image_description',$fair->image_description,array('id'=>'image_description','limit'=>'14','placeholder'=>'画像説明','class'=>'counter'))}}
            &nbsp;<span class="text-inline">(<span id="image_description_count">{{mb_strlen($fair->image_description)}}</span>/14)</span>
        </div><!-- /controles -->
    </div><!-- /controle-group -->
    <hr/>
    <!--予約-->
    <div class="control-group">
        <label class="control-label">予約</label>
        <div class="control-group-group">
            <div class="controls">
                <label class="radio inline">{{Form::radio('reserve',Fair::RESERVE_NONE,$fair->reserve == Fair::RESERVE_NONE)}}予約不要</label>
                <label class="radio inline">{{Form::radio('reserve',Fair::RESERVE_NONE,$fair->reserve == Fair::RESERVE_NET_ONLY)}}ネットのみ</label>
                <label class="radio inline">{{Form::radio('reserve',Fair::RESERVE_NONE,$fair->reserve == Fair::RESERVE_TEL_ONLY)}}電話のみ</label>
            </div>
            <div class="controls">
                <label class="radio inline">{{Form::radio('reserve',Fair::RESERVE_NONE,$fair->reserve == Fair::RESERVE_NET_PRIORITY)}}両方（ネット優先）</label>
                <label class="radio inline">{{Form::radio('reserve',Fair::RESERVE_NONE,$fair->reserve == Fair::RESERVE_TEL_PRIORITY)}}両方（電話優先）</label>
            </div><!-- /controls -->
            <div class="controls">
                <label class="control-label">ネット受付</label>
                {{Form::select('reserve_net_day',Fair::$reserveDayList,$fair->reserve_net_day,array('id'=>'reserve_net_day','class'=>'w80'))}}<span class="text-inline">&nbsp;まで&nbsp;</span>
                <span class="text-inline">&nbsp;受付時間&nbsp;</span>{{Form::select('reserve_net_time',Fair::$reserveTimeList,$fair->reserve_net_time,array('id'=>'reserve_net_time','class'=>'w80'))}}<span class="text-inline">&nbsp;まで&nbsp;</span>
            </div><!-- /controls -->
            <div class="controls">
                <label class="control-label">電話受付</label>
                {{Form::select('reserve_tel_day',Fair::$reserveDayList,$fair->reserve_tel_day,array('id'=>'reserve_tel_day','class'=>'w80'))}}<span class="text-inline">&nbsp;まで&nbsp;</span>
                <span class="text-inline">&nbsp;受付時間&nbsp;</span>{{Form::select('reserve_tel_time',Fair::$reserveTimeList,$fair->reserve_tel_time,array('id'=>'reserve_tel_time','class'=>'w80'))}}<span class="text-inline">&nbsp;まで&nbsp;</span>
            </div><!-- /controls -->
            <div class="controls">
                <label class="control-label">補足説明</label>
                {{Form::text('reserve_description',$fair->reserve_description,array('id'=>'reserve_description','limit'=>20,'class'=>'counter'))}}
                &nbsp;<span class="text-inline">(<span id="reserve_description_count">{{mb_strlen($fair->reserve_description)}}</span>/20)</span>
            </div>
        </div><!-- /control-group-group -->
    </div><!-- /control-group -->
    <hr/>
    <!-- 開催会場 -->
    <div class="control-group">
        <label class="control-label">アクセス</label>
        <div class="control-group-group">
            <div class="controls" style="padding-bottom:5px;">
                <label class="control-label">開催会場</label>
                {{Form::select('holl_id',Fair::$hollList,$fair->holl_id or Fair::HOLL_PLACE,array('class'=>'w80'))}}
            </div><!-- /controls -->
            <div class="controls">
                <label class="control-label">所在地</label>
                {{Form::text('address',$fair->address,array('id'=>'address','limit'=>'100','class'=>'counter'))}}
                &nbsp;<span class="text-inline">(<span id="address_count">{{mb_strlen($fair->address)}}</span>/100)</span>
                &nbsp;<span class="badge bg-red">必須</span>
            </div><!-- /controls -->
            <div class="controls">
                <label class="control-label">駐車場</label>
                {{Form::text('parking',$fair->parking,array('id'=>'parking','limit'=>'50','class'=>'counter'))}}
                &nbsp;<span class="text-inline">(<span id="parking_count">{{mb_strlen($fair->parking)}}</span>/50)</span>
                &nbsp;<span class="badge bg-red">必須</span>
            </div><!-- /controls -->
            <div class="controls">
                <label class="control-label">電話1</label>
                {{Form::text('tel1_1',$fair->tel1_1,array('class'=>'w30','limit'=>'4'))}}&nbsp;-&nbsp;
                {{Form::text('tel1_2',$fair->tel1_2,array('class'=>'w30','limit'=>'4'))}}&nbsp;-&nbsp;
                {{Form::text('tel1_3',$fair->tel1_3,array('class'=>'w30','limit'=>'4'))}}
                &nbsp;<span class="badge bg-red">必須</span>
                <div class="controls-inline">
                    <div class="controls">
                        <label class="control-label">種別</label>
                        <label class="radio inline">{{Form::radio('tel1_syubetsu',Fair::TEL_SYUBETSU_NORMAL,$fair->tel1_syubetsu == Fair::TEL_SYUBETSU_NORMAL)}}{{Fair::$telSyubetsuList[Fair::TEL_SYUBETSU_NORMAL]}}</label>
                        <label class="radio inline">{{Form::radio('tel1_syubetsu',Fair::TEL_SYUBETSU_NOPRICE,$fair->tel1_syubetsu == Fair::TEL_SYUBETSU_NOPRICE)}}{{Fair::$telSyubetsuList[Fair::TEL_SYUBETSU_NOPRICE]}}</label>
                        &nbsp;<span class="badge bg-red">必須</span>
                    </div><!-- /controls -->
                    <div class="controls">
                        <label class="control-label">担当窓口</label>
                        {{Form::text('tel1_tanto',$fair->tel1_tanto,array('id'=>'tel1_tanto','limit'=>50,'class'=>'counter'))}}
                        &nbsp;<span class="text-inline">(<span id="tel1_tanto_count">{{mb_strlen($fair->tel1_tanto)}}</span>/50)</span>
                        &nbsp;<span class="badge bg-red">必須</span>
                    </div><!-- /controls -->
                </div><!-- /controls-inline -->
            </div><!-- /controls -->
            <div class="controls">
                <label class="control-label">電話2</label>
                {{Form::text('tel2_1',$fair->tel2_1,array('class'=>'w30','limit'=>'4'))}}&nbsp;-&nbsp;
                {{Form::text('tel2_2',$fair->tel2_2,array('class'=>'w30','limit'=>'4'))}}&nbsp;-&nbsp;
                {{Form::text('tel2_3',$fair->tel2_3,array('class'=>'w30','limit'=>'4'))}}
                <div class="controls-inline">
                    <div class="controls">
                        <label class="control-label">種別</label>
                        <label class="radio inline">{{Form::radio('tel2_syubetsu',Fair::TEL_SYUBETSU_NORMAL,$fair->tel2_syubetsu == Fair::TEL_SYUBETSU_NORMAL)}}{{Fair::$telSyubetsuList[Fair::TEL_SYUBETSU_NORMAL]}}</label>
                        <label class="radio inline">{{Form::radio('tel2_syubetsu',Fair::TEL_SYUBETSU_NOPRICE,$fair->tel2_syubetsu == Fair::TEL_SYUBETSU_NOPRICE)}}{{Fair::$telSyubetsuList[Fair::TEL_SYUBETSU_NOPRICE]}}</label>
                        <label class="radio inline">{{Form::radio('tel2_syubetsu',Fair::TEL_SYUBETSU_FAX,$fair->tel2_syubetsu == Fair::TEL_SYUBETSU_FAX)}}{{Fair::$telSyubetsuList[Fair::TEL_SYUBETSU_FAX]}}</label>
                    </div><!-- /controls -->
                    <div class="controls">
                        <label class="control-label">担当窓口</label>
                        {{Form::text('tel2_tanto',$fair->tel2_tanto,array('id'=>'tel2_tanto','limit'=>50,'class'=>'counter'))}}
                       &nbsp;<span class="text-inline">(<span id="tel2_tanto_count">{{mb_strlen($fair->tel2_tanto)}}</span>/50)</span>
                    </div><!-- /controls -->
                </div><!-- /controls-inline -->
            </div><!-- /controls -->
        </div><!-- /control-group-group -->
    </div><!-- /control-group -->
    <hr/>
    <!-- 問合せ -->
    <div class="control-group">
        <label class="control-label">問合せ</label>
        <div class="control-group-group">
            <div class="controls">
                <label class="control-label">受付時間</label>
                {{Form::text('inquery_time',$fair->inquery_time,array('id'=>'inquery_time','limit'=>50,'class'=>'counter'))}}
                &nbsp;<span class="text-inline">(<span id="inquery_time_count">{{mb_strlen($fair->inquery_time)}}</span>/50)</span>
            </div><!-- /controls -->
            <div class="controls">
                <label class="control-label">担当者</label>
                {{Form::text('inquery_support_name',$fair->inquery_support_name,array('id'=>'inquery_support_name','limit'=>50,'class'=>'counter'))}}
                &nbsp;<span class="text-inline">(<span id="inquery_support_name_count">{{mb_strlen($fair->inquery_support_name)}}</span>/50)</span>
            </div><!-- /controls -->
        </div><!-- /control-group-group -->
    </div><!-- /control-group -->
    <hr/>
</fieldset>