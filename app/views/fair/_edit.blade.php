@extends('layout')
@section('style')
{{ HTML::style('assets/css/pages/fair.css?t=aaaaaaaas'); }}
<style>
.changes {
    text-align: center;	
}

.changes .page_change { 
    width: 60px;
    display: inline-block;
    padding: 12px 0;
    margin: 0 .9% 1em;
    vertical-align: top;
    text-decoration: none;
    background: #f9f6f1;
    border-radius: 5px;
}

.changes .page_change .change-icon {
    margin-top: .25em;
    margin-bottom: .25em;

    font-size: 32px;
    color: #545454;
}

.changes .page_change.selected {
    background: #00ba8b;
}
.changes .page_change.selected span,
.changes .page_change.selected .change-icon
{
    color: #fff;
}
.changes .page_change.disabled {
    background: #ddd;
}
.changes .page_change.disabled span,
.changes .page_change.disabled .change-icon
{
    color: #eeeeee;
}

.changes .page_change:hover {
    cursor:pointer;
}
.changes .page_change.selected:hover,
.changes .page_change.disabled:hover
{
    cursor:auto!important;
}

.changes .change-label {
    display: block;
    font-weight: 400;
    color: #545454;
}

.widget-header .header-titles {
    float:left;
}
.widget-header .header-buttons {
    float:right;
    margin-right:10px;
}
.clear {
    clear:both;
}
.form-horizontal {
    margin:20px;
}
.form-horizontal .controls
{
    margin-left: 100px!important;
    margin-bottom: 3px;
}
.form-horizontal .control-label {
    width: 85px;
}
.hhmm, 
.w50
{
    width:50px;
}
.w30 {
    width:30px;
}
.w80 {
    width:80px;
}
.w300 {
    width:300px;
}
.w450 {
    width:450px;
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
/* box-color */
.has-warning {
  border-color: #f39c12 !important;
  border-width: 2px;
  box-shadow: none;
}
.has-error {
  border-color: #f56954 !important;
  border-width: 2px;
  box-shadow: none;
}
.badge {
  cursor:auto!important;
}
</style>
@stop
@section('content')
<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span2">
                    <div class="widget">
                        <div class="widget-header"> <i class="icon-bookmark"></i>
                            <h3>切替</h3>
                        </div><!-- /widget-header -->
                        <div class="widget-content">
                            <div class="changes">
                                <a class="page_change selected" id="page_change_total"><i class="change-icon icon-list-alt"></i><span class="change-label">総合</span> </a>
                                <a class="page_change disabled" id="page_change_gnavi"><i class="change-icon icon-list-alt"></i><span class="change-label">ぐるナビ</span> </a>
                                <a class="page_change disabled" id="page_change_mwed"><i class="change-icon icon-bookmark"></i><span class="change-label">みんなの</span> </a>
                                <a class="page_change disabled" id="page_change_mynavi"><i class="change-icon icon-signal"></i> <span class="change-label">マイナビ</span> </a>
                                <a class="page_change disabled" id="page_change_park"><i class="change-icon icon-comment"></i><span class="change-label">パーク</span> </a>
                                <a class="page_change disabled" id="page_change_rakuten"><i class="change-icon icon-user"></i><span class="change-label">楽天</span> </a>
                                <a class="page_change disabled" id="page_change_sugukon"><i class="change-icon icon-file"></i><span class="change-label">すぐ婚</span> </a>
                                <a class="page_change disabled" id="page_change_zexy"><i class="change-icon icon-picture"></i> <span class="change-label">ゼクシィ</span> </a>
                            </div><!-- /changes --> 
                        </div><!-- /widget-content --> 
                    </div><!-- /widget -->
                </div><!-- /span2 -->
                <div class="span10">
                    <div class="widget widget-nopad">
                        <div class="widget-header">
                            <div class="header-titles">
                                <i class="icon-edit"></i>
                                <h3 id="page-title"> 総合</h3>
                            </div>
                            <div class="header-buttons">
                                <button class="btn btn-info">確認</button>
                            </div>
                            <div class="clear"></div>
                        </div><!-- /widget-header -->
                        <div class="widget-content">
                            <form action="" method="post" class="form-horizontal">
                                @include('fair.edit.total')
                                @include('fair.edit.gnavi')
                                @include('fair.edit.mwed')
                                @include('fair.edit.mynavi')
                                @include('fair.edit.park')
                            </form>
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
    $('.site_flg').click(function(){
        view = $(this).attr('view');
        if ($(this).is(':checked')) {
            $('#page_change_'+view).removeClass('disabled');
        } else {
            $('#page_change_'+view).addClass('disabled');
            if($('#page_change_'+view).hasClass('selected')) {
                $('#page_change_total').click();
            }
        }
    });
    $('.page_change').click(function(){
        if($(this).hasClass('disabled')||$(this).hasClass('selected')){
            return;
        }
        
        $selected = $('.page_change.selected').first();
        $selected.removeClass('selected');
        $('#'+$selected.attr('id').replace('change_','')).hide();
        $(this).addClass('selected');
        $('#'+$(this).attr('id').replace('change_','')).show();
        $('#page-title').html($(this).children(':nth-child(2)').html());
    });
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
    $('.park_fair_flag').click(function(){
        view = $(this).attr('view');
        if ($(this).is(':checked')) {
            $('#'+view).show();
        } else {
            $('#'+view).hide();
        }
    });
});
</script>
@stop