<fieldset id="page_1">
    <h3>1.初期選択</h3>
    <div class="control-group">
        <label class="control-label">使用サイト選択</label>
        <div class="controls">
            <label class="checkbox inline">{{Form::checkbox('flg_gnavi',Fair::FLG_ON,$fair->flg_gnavi,array('id'=>'flg_gnavi','class'=>'site_flg','view'=>'gnavis'))}}ぐるナビ</label>
        </div><!-- /controls -->
        <div class="controls">
            <label class="checkbox inline">{{Form::checkbox('flg_mwed',Fair::FLG_ON,$fair->flg_mwed,array('id'=>'flg_mwed','class'=>'site_flg','view'=>'mweds'))}}みんなの</label>
        </div><!-- /controls -->
        <div class="controls">
            <label class="checkbox inline">{{Form::checkbox('flg_mynavi',Fair::FLG_ON,$fair->flg_mynavi,array('id'=>'flg_mynavi','class'=>'site_flg','view'=>'mynavis'))}}マイナビ</label>
        </div><!-- /controls -->
        <div class="controls">
            <label class="checkbox inline">{{Form::checkbox('flg_park',Fair::FLG_ON,$fair->flg_park,array('id'=>'flg_park','class'=>'site_flg','view'=>'parks'))}}パーク</label>
        </div><!-- /controls -->
        <div class="controls">
            <label class="checkbox inline">{{Form::checkbox('flg_rakuten',Fair::FLG_ON,$fair->flg_rakuten,array('id'=>'flg_rakuten','class'=>'site_flg','view'=>'rakutens'))}}楽天</label>
        </div><!-- /controls -->
        <div class="controls">
            <label class="checkbox inline">{{Form::checkbox('flg_sugukon',Fair::FLG_ON,$fair->flg_sugukon,array('id'=>'flg_sugukon','class'=>'site_flg','view'=>'sugukons'))}}すぐ婚</label>
        </div><!-- /controls -->
        <div class="controls">
            <label class="checkbox inline">{{Form::checkbox('flg_zexy',Fair::FLG_ON,$fair->flg_zexy,array('id'=>'flg_zexy','class'=>'site_flg','view'=>'zexys'))}}ゼクシィ</label>
        </div><!-- /controls -->
    </div><!-- /control-group -->
    @include('fair.edit.footbutton')
</fieldset>