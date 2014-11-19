@extends('layout')
@section('style')
{{ HTML::style('assets/css/pages/signin.css'); }}
<style>
.header_tab {
    float:left;
    border-right: 1px solid #ddd;
    border-bottom-color: transparent;
    cursor:pointer;
}
.header_tab.selected
{
    color: #555555;
    background-color: #ffffff;
    border-right: 1px solid #ddd;
    border-top: 1px solid #ddd;
    border-bottom-color: transparent;
    cursor: default;
}
.header_tab.disabled
{
    cursor: default;
}
.header_tab.disabled i,
.header_tab.disabled h3
{
    color:#ddd;
}
.widget-header .header-titles {
    float:left;
}
.widget-header .header-buttons {
    float:right;
    margin-right:10px;
}
.form-horizontal {
    margin:20px;
}
.form-horizontal .controls
{
    margin-left: 0px!important;
    margin-bottom: 5px;
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
.clear {
    clear:both;
}

.form-horizontal .control-label {
    margin-right:5px;
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
                                <i class="icon-key"></i>
                                <h3 id="page-title"> パスワード変更</h3>
                            </div>
                        </div><!-- /widget-header -->
                        <div class="widget-content">
                            {{Form::open(array('url'=>'user/password','method'=>'post','id'=>'edit_form','class'=>'form-horizontal login-fields'))}}
                            <fieldset>
                                <!-- 現在のパスワード -->
                                <div class="control-group">
                                    <div class="controls">
                                        {{Form::password('before_password',array('id'=>'before_password','maxlength'=>'20','class'=>'login password-field','placeholder'=>'現在のパスワード'))}}
                                    </div>
                                </div><!-- /control-group -->
                                <!-- 新しいパスワード -->
                                <div class="control-group">
                                    <label class="control-label">新しいパスワード</label>
                                    <div class="controls">
                                        {{Form::password('new_password',array('id'=>'new_password','maxlength'=>'20','class'=>'login password-field','placeholder'=>'新しいパスワード'))}}
                                    </div>
                                </div><!-- /control-group -->
                                <!-- 確認パスワード -->
                                <div class="control-group">
                                    <label class="control-label">新しいパスワード(確認)</label>
                                    <div class="controls">
                                        {{Form::password('confirm_password',array('id'=>'confirm_password','maxlength'=>'20','class'=>'login password-field','placeholder'=>'新しいパスワード(確認)'))}}
                                    </div>
                                </div><!-- /control-group -->
                                <hr/>
                                <div class="control-group">
                                    {{Form::button('更新',array('class'=>'btn btn-large btn-primary','style'=>'width:200px;','onclick'=>'submit();'))}}
                                </div><!-- /control-group -->
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