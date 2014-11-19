<fieldset id="page_7">
    <h3>7.アクセスデータ</h3>
    <!-- 開催会場 -->
    <div class="control-group">
        <label class="control-label">開催会場</label>
        <div class="controls" style="padding-bottom:5px;">
            {{Form::select('holl_id',Fair::$hollList,$fair->holl_id,array('id'=>'holl_id','class'=>'w80'))}}
            &nbsp;<span class="badge bg-red">必須</span>
        </div><!-- /controls -->
    </div><!-- /control-group-->
    <div class="control-group">
        <label class="control-label">所在地</label>
        <div class="controls">
            {{Form::textarea('address',$fair->address,array('id'=>'address','limit'=>'100','class'=>'counter w300','rows'=>'2'))}}
            &nbsp;<span class="text-inline">(<span id="address_count">{{mb_strlen($fair->address)}}</span>/100)</span>
            &nbsp;<span class="badge bg-red">必須</span>
        </div><!-- /controls -->
    </div><!-- /control-group-->
    <div class="control-group">
        <label class="control-label">所在地備考</label>
        <div class="controls">
            {{Form::textarea('address',$fair->address,array('id'=>'address_note','limit'=>'500','class'=>'counter w300','rows'=>'4'))}}
            &nbsp;<span class="text-inline">(<span id="address_count">{{mb_strlen($fair->address)}}</span>/500)</span>
        </div><!-- /controls -->
    </div><!-- /control-group-->
    <div class="control-group">
        <label class="control-label">駐車場</label>
        <div class="controls">
            {{Form::textarea('parking',$fair->parking,array('id'=>'parking','limit'=>'50','class'=>'counter w300','rows'=>'2'))}}
            &nbsp;<span class="text-inline">(<span id="parking_count">{{mb_strlen($fair->parking)}}</span>/50)</span>
            &nbsp;<span class="badge bg-red">必須</span>
        </div><!-- /controls -->
    </div><!-- /control-group -->
    <div class="control-group">
        <label class="control-label">電話番号1</label>
        <div class="controls">
            {{Form::text('tel1_1',$fair->tel1_1,array('id'=>'tel1_1','class'=>'w30','limit'=>'4'))}}&nbsp;-&nbsp;
            {{Form::text('tel1_2',$fair->tel1_2,array('id'=>'tel1_2','class'=>'w30','limit'=>'4'))}}&nbsp;-&nbsp;
            {{Form::text('tel1_3',$fair->tel1_3,array('id'=>'tel1_3','class'=>'w30','limit'=>'4'))}}
            &nbsp;<span class="badge bg-red">必須</span>
            <div class="controls-inline">
                <label class="control-label">種別</label>
                <div class="controls">
                    <label class="radio inline">{{Form::radio('tel1_syubetsu',Fair::TEL_SYUBETSU_NORMAL,$fair->tel1_syubetsu == Fair::TEL_SYUBETSU_NORMAL)}}{{Fair::$telSyubetsuList[Fair::TEL_SYUBETSU_NORMAL]}}</label>
                    <label class="radio inline">{{Form::radio('tel1_syubetsu',Fair::TEL_SYUBETSU_NOPRICE,$fair->tel1_syubetsu == Fair::TEL_SYUBETSU_NOPRICE)}}{{Fair::$telSyubetsuList[Fair::TEL_SYUBETSU_NOPRICE]}}</label>
                    &nbsp;<span class="badge bg-red">必須</span>
                </div><!-- /controls -->
                <label class="control-label">担当窓口</label>
                <div class="controls">
                    {{Form::text('tel1_tanto',$fair->tel1_tanto,array('id'=>'tel1_tanto','limit'=>50,'class'=>'counter'))}}
                    &nbsp;<span class="text-inline">(<span id="tel1_tanto_count">{{mb_strlen($fair->tel1_tanto)}}</span>/50)</span>
                    &nbsp;<span class="badge bg-red">必須</span>
                </div><!-- /controls -->
            </div><!-- /controls-inline -->
        </div><!-- /controls -->
    </div><!-- /control-group -->
    <div class="control-group">
        <label class="control-label">電話番号2</label>
        <div class="controls">
            {{Form::text('tel2_1',$fair->tel2_1,array('id'=>'tel2_1','class'=>'w30','limit'=>'4'))}}&nbsp;-&nbsp;
            {{Form::text('tel2_2',$fair->tel2_2,array('id'=>'tel2_2','class'=>'w30','limit'=>'4'))}}&nbsp;-&nbsp;
            {{Form::text('tel2_3',$fair->tel2_3,array('id'=>'tel2_3','class'=>'w30','limit'=>'4'))}}
            <div class="controls-inline">
                <label class="control-label">種別</label>
                <div class="controls">
                    <label class="radio inline">{{Form::radio('tel2_syubetsu',Fair::TEL_SYUBETSU_NORMAL,$fair->tel2_syubetsu == Fair::TEL_SYUBETSU_NORMAL)}}{{Fair::$telSyubetsuList[Fair::TEL_SYUBETSU_NORMAL]}}</label>
                    <label class="radio inline">{{Form::radio('tel2_syubetsu',Fair::TEL_SYUBETSU_NOPRICE,$fair->tel2_syubetsu == Fair::TEL_SYUBETSU_NOPRICE)}}{{Fair::$telSyubetsuList[Fair::TEL_SYUBETSU_NOPRICE]}}</label>
                    <label class="radio inline">{{Form::radio('tel2_syubetsu',Fair::TEL_SYUBETSU_FAX,$fair->tel2_syubetsu == Fair::TEL_SYUBETSU_FAX)}}{{Fair::$telSyubetsuList[Fair::TEL_SYUBETSU_FAX]}}</label>
                </div><!-- /controls -->
                <label class="control-label">担当窓口</label>
                <div class="controls">
                    {{Form::text('tel2_tanto',$fair->tel2_tanto,array('id'=>'tel2_tanto','limit'=>50,'class'=>'counter'))}}
                   &nbsp;<span class="text-inline">(<span id="tel2_tanto_count">{{mb_strlen($fair->tel2_tanto)}}</span>/50)</span>
                </div><!-- /controls -->
            </div><!-- /controls-inline -->
        </div><!-- /controls -->
    </div><!-- /control-group -->
    <hr/>
    <!-- 問合せ -->
    <div class="control-group">
        <label class="control-label">問合せ</label>
        <div class="controls">
            <div class="controls-inline">
                <label class="control-label">受付時間</label>
                <div class="controls">
                    {{Form::text('inquery_time',$fair->inquery_time,array('id'=>'inquery_time','limit'=>50,'class'=>'counter'))}}
                    &nbsp;<span class="text-inline">(<span id="inquery_time_count">{{mb_strlen($fair->inquery_time)}}</span>/50)</span>
                </div><!-- /controls -->
                <label class="control-label">担当者</label>
                <div class="controls">
                    {{Form::text('inquery_support_name',$fair->inquery_support_name,array('id'=>'inquery_support_name','limit'=>50,'class'=>'counter'))}}
                    &nbsp;<span class="text-inline">(<span id="inquery_support_name_count">{{mb_strlen($fair->inquery_support_name)}}</span>/50)</span>
                </div><!-- /controls -->
            </div><!-- /controls-inline -->
        </div><!-- /controls -->
    </div><!-- /control-group -->
    @include('fair.edit.footbutton')
</fieldset>