<fieldset id="page_2">
    <h3>2.基本情報入力</h3>
    <div class="control-group">
        <label class="control-label" for="fair_name">フェア名称</label>
        <div class="controls">
            {{Form::text('fair_name',$fair->fair_name,array('id'=>'fair_name','limit'=>'30','class'=>'counter w400'))}}
            &nbsp;<span class="text-inline">(<span id="fair_name_count">{{mb_strlen($fair->fair_name)}}</span>/30)</span>
            &nbsp;<span class="badge bg-red">必須</span>
        </div><!-- /controles -->
    </div><!-- /control-group -->
    <div class="control-group">
        <label class="control-label">全体説明文</label>
        <div class="controls">
            {{Form::textarea('description',$fair->description,array('id'=>'description','limit'=>'500','rows'=>'4','class'=>'w400 counter'))}}
            &nbsp;<span class="text-inline">(<span id="description_count">{{mb_strlen($fair->description)}}</span>/<span id="description_max">500</span>)</span>
            &nbsp;<span class="badge bg-red">必須</span>
        </div><!-- /controles -->
    </div><!-- /control-group -->
    @include('fair.edit.footbutton')
</fieldset>