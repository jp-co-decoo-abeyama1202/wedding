<fieldset id="page_4">
    <h3>4.画像選択</h3>
    <!--画像選択設定-->
    <div class="control-group">
        <label class="control-label">画像</label>
        <div class="controls">
            <div class="controls-inline">
                <div class="controls" style='padding-bottom:10px;'>
                    <a href="#image_select_modal" role="button" class="btn btn-imagemodal" data-toggle="modal" target='all'>画像選択(まとめて適用)</a>
                </div><!-- /controls -->
                @foreach(Site::$_site_names as $id => $name)
                <div class="{{Fair::$fairClasses[$id]}}">
                    <label class="control-label text-left-i">画像選択({{$name}})</label>
                    <div class="controls" style='padding-bottom:10px;'>
                        <a href="#image_select_modal" role="button" class="btn btn-imagemodal" data-toggle="modal" target='{{$id}}'>選択</a>
                        {{Form::hidden('image_id_'.$id,'',array('id'=>'image_id_'.$id,'class'=>'image_id'))}}
                        @if(in_array($id,array(SiteSugukon::SITE_LOGIN_ID,SiteGnavi::SITE_LOGIN_ID)))
                        &nbsp;<span class="badge bg-red">必須</span>
                        &nbsp;&nbsp;<span class="text-inline">画像説明</span>
                        {{Form::text('image_caption_'.$id,'',array('id'=>'image_caption_'.$id,'maxlength'=>$id==SiteSugukon::SITE_LOGIN_ID?14:30,'class'=>'w300 image_caption'))}}&nbsp;<text class="text-inline">({{$id==SiteSugukon::SITE_LOGIN_ID?14:30}}文字まで)</span>
                        @endif
                    </div><!-- /controls -->
                </div>
                @endforeach
            </div><!-- /controls-inline -->
        </div><!-- /controls -->
    </div><!-- /controle-group -->
    <div class="control-group">
        <label class="control-label">サンプル</label>
        <div class="controls">
            <div class="image-boxs">
                @foreach(Site::$_site_names as $id => $name)
                <div class="image-box {{Fair::$fairClasses[$id]}}">
                    <div class="image-title">
                        {{$name}}
                    </div><!-- /image-title -->
                    <div class="image-body">
                        @if(false)
                        {{HTML::image()}}
                        @else
                        {{HTML::image('assets/img/sample.png',null,array('id'=>'sample_image_'.$id))}}
                        @endif
                    </div>
                </div><!-- /image-box -->
                @endforeach
                <div class="clear"></div>
            </div><!-- /image-boxs -->
        </div><!-- /controls -->
    </div><!-- /controle-group -->
    @include('fair.edit.footbutton')
</fieldset>