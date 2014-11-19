<fieldset id="page_5">
    <h3>5.特典入力</h3>
    <!-- ゼクシィ -->
    <div class="control-group zexys">
        <label class="control-label">ゼクシィ</label>
        <div class="controls">
            <label class="checkbox inline">{{Form::checkbox('zexy_tokuten_flg',Fair::FLG_ON,$fair->zexy_tokuten_flg==Fair::FLG_ON,array('class'=>'views','view'=>'zexy_tokutens'))}}特典あり</label>
            <div class="controls-inline hide" id="zexy_tokutens">
                <label class="control-label">特典内容説明</label>
                <div class="controls">
                    {{Form::text('zexy_tokuten_description',$fair->zexy_tokuten_description,array('id'=>'zexy_tokuten_description','limit'=>'50','class'=>'counter w300'))}}
                    &nbsp;<span class="text-inline">(<span id="zexy_tokuten_description_count">{{mb_strlen($fair->zexy_tokuten_description)}}</span>/50)</span>
                    &nbsp;<span class="badge bg-red">必須</span>
                </div><!-- /controls -->
                <label class="control-label">備考</label>
                <div class="controls">
                    {{Form::text('zexy_tokuten_remarks',$fair->zexy_tokuten_remarks,array('id'=>'zexy_tokuten_remarks','limit'=>'50','class'=>'counter w300'))}}
                    &nbsp;<span class="text-inline">(<span id="zexy_tokuten_remarks_count">{{mb_strlen($fair->zexy_tokuten_remarks)}}</span>/50)</span>
                    &nbsp;<span class="badge bg-red">必須</span>
                </div><!-- /controls -->
                <label class="control-label">期間</label>
                <div class="controls">
                    {{Form::text('zexy_tokuten_period',$fair->zexy_tokuten_period,array('id'=>'zexy_tokuten_period','limit'=>'50','class'=>'counter w300'))}}
                    &nbsp;<span class="text-inline">(<span id="zexy_tokuten_period_count">{{mb_strlen($fair->zexy_tokuten_period)}}</span>/50)</span>
                    &nbsp;<span class="badge bg-red">必須</span>
                </div><!-- /controls -->
            </div><!-- /controls-inline -->
        </div><!-- /controls -->
        <hr/>
    </div><!-- /control-group -->
    <!-- みんなの -->
    <div class="control-group mweds">
        <label class="control-label">みんなの</label>
        <div class="controls">
            <label class="checkbox inline">{{Form::checkbox('mwed_tokuten_flg',Fair::FLG_ON,$fair->mwed_tokuten_flg==Fair::FLG_ON,array('class'=>'views','view'=>'mwed_tokutens'))}}特典あり</label>
            <div class="controls-inline hide" id="mwed_tokutens">
                <label class="control-label">特典内容説明</label>
                <div class="controls">
                    {{Form::text('mwed_tokuten_description',$fair->mwed_tokuten_description,array('id'=>'mwed_tokuten_description','limit'=>'50','class'=>'counter w300'))}}
                    &nbsp;<span class="text-inline">(<span id="mwed_tokuten_description_count">{{mb_strlen($fair->mwed_tokuten_description)}}</span>/50)</span>
                    &nbsp;<span class="badge bg-red">必須</span>
                </div><!-- /controls -->
            </div><!-- /controls-inline -->
        </div><!-- /controls -->
        <hr/>
    </div><!-- /control-group -->
    
    <!-- パーク -->
    <div class="control-group parks">
        <label class="control-label">パーク</label>
        <div class="controls">
            <label class="checkbox inline">{{Form::checkbox('park_tokuten_flg',Fair::FLG_ON,$fair->park_tokuten_flg==Fair::FLG_ON,array('class'=>'views','view'=>'park_tokutens'))}}特典あり</label>
            <div class="controls-inline hide" id="park_tokutens">
                <label class="control-label">特典内容説明</label>
                <div class="controls">
                    {{Form::textarea('park_tokuten_description',$fair->park_tokuten_description,array('id'=>'park_tokuten_description','limit'=>'200','class'=>'counter w300','rows'=>'3'))}}
                    &nbsp;<span class="text-inline">(<span id="park_tokuten_description_count">{{mb_strlen($fair->park_tokuten_description)}}</span>/200)</span>
                    &nbsp;<span class="badge bg-red">必須</span>
                </div><!-- /controls -->
            </div><!-- /controls-inline -->
        </div><!-- /controls -->
        <hr/>
    </div><!-- /control-group -->
    
    <!-- 楽天 -->
    <div class="control-group rakutens">
        <label class="control-label">楽天</label>
        <div class="controls">
            <label class="checkbox inline">{{Form::checkbox('rakuten_tokuten_flg',Fair::FLG_ON,$fair->rakuten_tokuten_flg==Fair::FLG_ON,array('class'=>'views','view'=>'rakuten_tokutens'))}}特典あり</label>
            <div class="controls-inline hide" id="rakuten_tokutens">
                <div class="controls">
                </div><!-- /controls -->
            </div><!-- /controls-inline -->
        </div><!-- /controls -->
        <hr/>
    </div><!-- /control-group -->
    
    <!-- マイナビ -->
    <div class="control-group mynavis">
        <label class="control-label">マイナビ</label>
        <div class="controls">
            <label class="checkbox inline">{{Form::checkbox('mynavi_tokuten_flg',Fair::FLG_ON,$fair->mynavi_tokuten_flg==Fair::FLG_ON,array('class'=>'views','view'=>'mynavi_tokutens'))}}特典あり</label>
            <div class="controls-inline hide" id="mynavi_tokutens">
                <label class="control-label">特典内容説明</label>
                <div class="controls">
                    {{Form::textarea('mynavi_tokuten_description',$fair->mynavi_tokuten_description,array('id'=>'mynavi_tokuten_description','limit'=>'200','class'=>'counter w300','rows'=>'3'))}}
                    &nbsp;<span class="text-inline">(<span id="mynavi_tokuten_description_count">{{mb_strlen($fair->mynavi_tokuten_description)}}</span>/200)</span>
                    &nbsp;<span class="badge bg-red">必須</span>
                </div><!-- /controls -->
            </div><!-- /controls-inline -->
        </div><!-- /controls -->
        <hr/>
    </div><!-- /control-group -->
    
    <!-- ぐるナビ -->
    <div class="control-group gnavis">
        <label class="control-label">ぐるナビ</label>
        <div class="controls">
            <label class="checkbox inline">{{Form::checkbox('gnavi_tokuten_flg',Fair::FLG_ON,$fair->gnavi_tokuten_flg==Fair::FLG_ON)}}特典あり</label>
        </div><!-- /controls -->
    </div><!-- /control-group -->
    @include('fair.edit.footbutton')
</fieldset>