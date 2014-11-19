@extends('layout')
@section('style')
<style>
.form-horizontal .control-label {
    width: 140px;
}
.form-horizontal .controls
{
    margin-left: 150px!important;
    margin-bottom: 5px;
}
</style>
@stop
@section('content')
<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <div class="widget widget-nopad">
                        <div class="widget-header">
                            <div class="header_title">
                                <i class="icon-upload-alt"></i>
                                <h3 id="page-title"> 画像アップロード</h3>
                            </div>
                            <div class="clear"></div>
                        </div><!-- /widget-header -->
                        <div class="widget-content">
                            {{Form::open(array('url'=>'image/upload','method'=>'post','id'=>'upload_form','class'=>'form-horizontal','files'=>true))}}
                            <div class="control-group">
                                <label class="control-label">画像カテゴリ</label>
                                <div class="controls">
                                    {{Form::select('image_category_id',ImageCategory::getList(),null,array('class'=>'w150'))}}
                                </div><!-- /controls -->
                            </div><!-- /control-group -->
                            @for($i=1;$i<=10;++$i)
                            <div class="control-group">
                                <label class="control-label">アップロード画像{{sprintf('%02d',$i)}}</label>
                                <div class="controls">
                                    {{Form::file('image_'.$i)}}
                                </div><!-- /controls -->
                            </div><!-- /control-group -->
                            @endfor
                            <div class="control-group">
                                {{Form::button('アップロードする',array('class'=>'btn btn-large btn-primary','style'=>'width:200px;','onclick'=>'submit();'))}}
                            </div><!-- /control-group -->
                            {{Form::close()}}
                            {{Form::hidden('mynavi_tag_id_limit',3,array('id'=>'mynavi_tag_id_limit'))}}
                        </div>
                    </div><!-- /widget -->
                </div><!-- /span10 -->
            </div><!-- /row -->
        </div><!-- container -->
    </div><!-- /main-inner -->
</div><!-- /main -->
@stop
@section('scripts')
<script>
$('input.restricted_check[type="checkbox"]').click(function(){
    var max = $('#'+$(this).attr('groups')+'_limit').val();
    if(max < $('input.restricted_check[type="checkbox"]:checked').length) {
        $(this).attr('checked',false);
    }
    if(max <= $('input.restricted_check[type="checkbox"]:checked').length) {
        $('input.restricted_check[type="checkbox"]:not(:checked)').attr('disabled','disabled');
    } else {
        $('input.restricted_check[type="checkbox"]').removeAttr('disabled');
    }
    
});
</script>
@stop