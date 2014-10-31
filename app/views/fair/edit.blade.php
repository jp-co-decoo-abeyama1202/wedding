@extends('layout')
@section('style')
<style>
.form-horizontal {
    margin:20px;
}
.form-horizontal .controls
{
    margin-left: 100px!important;
    margin-bottom: 5px;
}
.form-horizontal .control-label {
    width: 85px;
}
//control-groupのさらに子要素
.form-horizontal .control-group-group {
    margin-bottom:18px;
}
.form-horizontal .control-group-group .controls {
    margin-bottom:5px;
}
.form-horizontal .controls .control-label {
    width:65px!important;
    margin-right:15px;
}
span.text-inline {
    padding-top:5px;
    display:inline-block;
    vertical-align:middle;
}
.controls .controls-inline {
    margin-top:5px;
    margin-bottom:5px;
}
.controls .controls-inline .controls {
    margin-left: 80px!important;
    padding-bottom:5px;
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
                            <div class="header_tab selected" id="page_tab_total">
                                <i class="icon-edit"></i>
                                <h3 id="page-title"> 総合</h3>
                            </div>
                            <div class="header_tab {{$fair->flg_gnavi?'':'disabled'}}" id="page_tab_gnavi">
                                <i class="icon-edit"></i>
                                <h3 id="page-title"> ぐるナビ</h3>
                            </div>
                            <div class="header_tab {{$fair->flg_mwed?'':'disabled'}}" id="page_tab_mwed">
                                <i class="icon-edit"></i>
                                <h3 id="page-title"> みんなの</h3>
                            </div>
                            <div class="header_tab {{$fair->flg_mynavi?'':'disabled'}}" id="page_tab_mynavi">
                                <i class="icon-edit"></i>
                                <h3 id="page-title"> マイナビ</h3>
                            </div>
                            <div class="header_tab {{$fair->flg_park?'':'disabled'}}" id="page_tab_park">
                                <i class="icon-edit"></i>
                                <h3 id="page-title"> パーク</h3>
                            </div>
                            <div class="header_tab {{$fair->flg_rakuten?'':'disabled'}}" id="page_tab_rakuten">
                                <i class="icon-edit"></i>
                                <h3 id="page-title"> 楽天</h3>
                            </div>
                            <div class="header_tab {{$fair->flg_sugukon?'':'disabled'}}" id="page_tab_sugukon">
                                <i class="icon-edit"></i>
                                <h3 id="page-title"> すぐ婚</h3>
                            </div>
                            <div class="header_tab {{$fair->flg_zexy?'':'disabled'}}" id="page_tab_zexy">
                                <i class="icon-edit"></i>
                                <h3 id="page-title"> ゼクシィ</h3>
                            </div>
                            <div class="header-buttons">
                                <button class="btn btn-info" id="button_reflection">総合の内容を反映</button>
                                <button class="btn btn-info" id="button_confirm">確認</button>
                            </div>
                            <div class="clear"></div>
                        </div><!-- /widget-header -->
                        <div class="widget-content">
                            {{Form::open(array('url'=>'fair/confirm','method'=>'post','id'=>'edit_form','class'=>'form-horizontal'))}}
                                {{Form::hidden('id',$fair->id)}}
                                {{Form::hidden('only_total',false,array('id'=>'only_total'))}}
                                @include('fair.edit.total')
                                @include('fair.edit.gnavi')
                                @include('fair.edit.mwed')
                                @include('fair.edit.mynavi')
                                @include('fair.edit.park')
                                @include('fair.edit.rakuten')
                                @include('fair.edit.sugukon')
                                @include('fair.edit.zexy')
                            {{Form::close()}}
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
var fairCnt = 1;
$(document).ready(function(){
    $("#button_confirm").click(function(){
        $('#edit_form').submit();
    });
    $("#button_reflection").click(function(){
        if(window.confirm('一度総合の内容を仮保存します。よろしいですか？')) {
            $('#only_total').val(true);
            $('#edit_form').submit();
        }
    });
    $('.site_flg').click(function(){
        view = $(this).attr('view');
        if ($(this).is(':checked')) {
            $('#page_tab_'+view).removeClass('disabled');
        } else {
            $('#page_tab_'+view).addClass('disabled')
            if($('#page_tab_'+view).hasClass('selected')) {
                $('#page_tab_total').click();
            }
        }
    });
    $('.header_tab').click(function(){
        if($(this).hasClass('disabled')||$(this).hasClass('selected')){
            return;
        }
        $selected = $('.header_tab.selected').first();
        $selected.removeClass('selected');
        $('#'+$selected.attr('id').replace('tab_','')).hide();
        $(this).addClass('selected');
        $('#'+$(this).attr('id').replace('tab_','')).show();
    });
    
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
    $('input.views[type="checkbox"]').click(function(){
        view = $(this).attr('view');
        if ($(this).is(':checked')) {
            $('#'+view).show();
        } else {
            $('#'+view).hide();
        }
    });
    $('input.views[type="radio"]').click(function(){
        view = $(this).attr('view');
        viewList = $(this).attr('view_list');
        $('input.views[type="radio"][view_list="'+viewList+'"]').each(function(){
            $('#'+$(this).attr('view')).hide();
        });
        if ($(this).is(':checked')) {
            $('#'+view).show();
        }
    });
    // 総合画面
    $('#tour_count').bind('change',function(){
        $('.tours').hide();
        var max = $(this).val();
        for(var i=1;i<=max;i++) {
            $('#tours_'+i).show();
        }
    });
});
</script>
@stop