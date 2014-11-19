@extends('layout')
@section('style')
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
                                <i class="icon-flag"></i>
                                <h3 id="page-title"> 会場情報編集</h3>
                            </div>
                        </div><!-- /widget-header -->
                        <div class="widget-content">
                            {{Form::open(array('url'=>'admin/holl','method'=>'post','id'=>'edit_form','class'=>'form-horizontal'))}}
                            <fieldset>
                                <!-- 開催会場 -->
                                <div class="control-group">
                                    <label class="control-label">開催会場</label>
                                    <div class="controls">
                                        {{Form::textarea('address',$holl->address,array('id'=>'address','limit'=>'100','class'=>'counter w300','rows'=>'2'))}}
                                        &nbsp;<span class="text-inline">(<span id="address_count">{{mb_strlen($holl->address)}}</span>/100)</span>
                                        &nbsp;<span class="badge bg-red">必須</span>
                                    </div>
                                </div><!-- /control-group -->
                                <!-- 駐車場 -->
                                <div class="control-group">
                                    <label class="control-label">駐車場</label>
                                    <div class="controls">
                                        {{Form::textarea('parking',$holl->parking,array('id'=>'parking','limit'=>'50','class'=>'counter w300','rows'=>'2'))}}
                                        &nbsp;<span class="text-inline">(<span id="parking_count">{{mb_strlen($holl->parking)}}</span>/50)</span>
                                        &nbsp;<span class="badge bg-red">必須</span>
                                    </div>
                                </div><!-- /control-group -->
                                <!-- その他 -->
                                <div class="control-group">
                                    <label class="control-label">その他</label>
                                    <div class="controls">
                                        {{Form::textarea('etc',$holl->etc,array('id'=>'etc','limit'=>'100','class'=>'counter w300','rows'=>'2'))}}
                                        &nbsp;<span class="text-inline">(<span id="etc_count">{{mb_strlen($holl->etc)}}</span>/100)</span>
                                    </div>
                                </div><!-- /control-group -->
                                <hr/>
                                <!-- 電話番号1 -->
                                <div class="control-group">
                                    <label class="control-label">電話番号1</label>
                                    <div class="controls">
                                        <label class="control-label"></label>
                                        {{Form::text('tel1_1',$holl->tel1_1,array('class'=>'w30','maxlength'=>'4'))}}&nbsp;-&nbsp;
                                        {{Form::text('tel1_2',$holl->tel1_2,array('class'=>'w30','maxlength'=>'4'))}}&nbsp;-&nbsp;
                                        {{Form::text('tel1_3',$holl->tel1_3,array('class'=>'w30','maxlength'=>'4'))}}
                                        &nbsp;<span class="badge bg-red">必須</span>
                                    </div>
                                    <div class="controls">
                                        <label class="control-label">種別</label>
                                        <label class="radio inline">{{Form::radio('tel1_syubetsu',Holl::TEL_SYUBETSU_NORMAL,$holl->tel1_syubetsu == Holl::TEL_SYUBETSU_NORMAL)}}TEL</label>
                                        <label class="radio inline">{{Form::radio('tel1_syubetsu',Holl::TEL_SYUBETSU_FREE,$holl->tel1_syubetsu == Holl::TEL_SYUBETSU_FREE)}}無料TEL</label>
                                        &nbsp;<span class="badge bg-red">必須</span>
                                    </div><!-- /controls -->
                                    <div class="controls">
                                        <label class="control-label">担当窓口</label>
                                        {{Form::text('tel1_tanto',$holl->tel1_tanto,array('id'=>'tel1_tanto','limit'=>'50','class'=>'counter'))}}
                                        &nbsp;<span class="text-inline">(<span id="tel1_tanto_count">{{mb_strlen($holl->tel1_tanto)}}</span>/50)</span>
                                        &nbsp;<span class="badge bg-red">必須</span>
                                    </div><!-- /controls -->
                                </div><!-- /control-group -->
                                <hr/>
                                <!-- 電話番号2 -->
                                <div class="control-group">
                                    <label class="control-label">電話番号2</label>
                                    <div class="controls">
                                        <label class="control-label"></label>
                                        {{Form::text('tel2_1',$holl->tel2_1,array('class'=>'w30','maxlength'=>'4'))}}&nbsp;-&nbsp;
                                        {{Form::text('tel2_2',$holl->tel2_2,array('class'=>'w30','maxlength'=>'4'))}}&nbsp;-&nbsp;
                                        {{Form::text('tel2_3',$holl->tel2_3,array('class'=>'w30','maxlength'=>'4'))}}
                                    </div>
                                    <div class="controls">
                                        <label class="control-label">種別</label>
                                        <label class="radio inline">{{Form::radio('tel2_syubetsu',Holl::TEL_SYUBETSU_NORMAL,$holl->tel2_syubetsu == Holl::TEL_SYUBETSU_NORMAL)}}TEL</label>
                                        <label class="radio inline">{{Form::radio('tel2_syubetsu',Holl::TEL_SYUBETSU_FREE,$holl->tel2_syubetsu == Holl::TEL_SYUBETSU_FREE)}}無料TEL</label>
                                        <label class="radio inline">{{Form::radio('tel2_syubetsu',Holl::TEL_SYUBETSU_FAX,$holl->tel2_syubetsu == Holl::TEL_SYUBETSU_FAX)}}FAX</label>
                                    </div><!-- /controls -->
                                    <div class="controls">
                                        <label class="control-label">担当窓口</label>
                                        {{Form::text('tel2_tanto',$holl->tel2_tanto,array('id'=>'tel2_tanto','limit'=>'50','class'=>'counter'))}}
                                        &nbsp;<span class="text-inline">(<span id="tel2_tanto2_count">{{mb_strlen($holl->tel2_tanto)}}</span>/50)</span>
                                    </div><!-- /controls -->
                                </div><!-- /control-group -->
                                <hr/>
                                <!-- 問合せ -->
                                <div class="control-group">
                                    <label class="control-label">問合せ</label>
                                    <div class="controls">
                                        <label class="control-label">受付時間</label>
                                        {{Form::text('inquery_time',$holl->inquery_time,array('id'=>'inquery_time','limit'=>'50','class'=>'counter'))}}
                                        &nbsp;<span class="text-inline">(<span id="inquery_time_count">{{mb_strlen($holl->inquery_time)}}</span>/50)</span>
                                        &nbsp;<span class="badge bg-red">必須</span>
                                    </div><!-- /controls -->
                                    <div class="controls">
                                        <label class="control-label">担当</label>
                                        {{Form::textarea('inquery_support_name',$holl->inquery_support_name,array('id'=>'tanto','limit'=>'50','class'=>'counter w300','rows'=>'2'))}}
                                        &nbsp;<span class="text-inline">(<span id="inquery_support_name_count">{{mb_strlen($holl->inquery_support_name)}}</span>/50)</span>
                                        &nbsp;<span class="badge bg-red">必須</span>
                                    </div><!-- /controls -->
                                </div><!-- /control-group -->
                                <hr/>
                                <div class="control-group">
                                    {{Form::submit('更新',array('class'=>'btn btn-large btn-primary','style'=>'width:200px;'))}}
                                </div><!-- /control-group -->
                            </fieldset>
                            {{Form::close()}}
                        </div><!-- /widget-content -->
                    </div><!-- /widget -->
                </div><!-- /span10 -->
            </div><!-- /row -->
        </div><!-- container -->
    </div><!-- /main-inner -->
</div><!-- /main -->
@stop
@section('scripts')
<script>
$(document).ready(function(){
    // 共通
    $('.counter').bind('keydown keyup keypress change',function(){
        var counterId = $(this).attr('id')+'_count';
        $('#'+counterId).html($(this).val().length);
        if($(this).val().length > $(this).attr('limit')) {
            $(this).addClass('has-error');
            $('#'+counterId).addClass('text-red');
        } else {
            $(this).removeClass('has-error');
            $('#'+counterId).removeClass('text-red');
        }
    });
});
</script>
@stop