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
.controls i.input-head {
    padding:5px 8px 7px 8px;
    margin-right:0px;
    border:1px solid #dddddd;
    border-radius: 3px 0 0 3px;
    background-color:#f9f6f1;
    float:left;
    display:block;
    width:11px;
    text-align:center;
}
.controls input.input-body {
    margin-left:0px;
    border-radius:0 3px 3px 0;
    height:17px;
    border-left:none;
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
                        <div class="widget-header tabs">
                            <div class="header_title">
                                <i class="icon-pencil"></i>
                                <h3 id="page-title"> ログインユーザ{{$administrator->id ? '修正':'新規登録'}}</h3>
                            </div>
                            <div class="header-buttons">
                                @if($administrator->id)
                                <a href='{{URL::to('user/list')}}'>
                                @else
                                <a href='{{URL::to('user/')}}'>
                                @endif
                                    {{Form::button('戻る',array('class'=>'btn btn-primary'))}}
                                </a>
                            </div>
                            <div class="clear"></div>
                        </div><!-- /widget-header -->
                        <div class="widget-content">
                            {{Form::open(array('url'=>'user/edit','method'=>'post','class'=>'form-horizontal'))}}
                            {{Form::hidden('id',$administrator->id)}}
                            <div class='control-group'>
                                <label class="control-label">表示名</label>
                                <div class="controls">
                                    <i class='icon-user input-head'></i>
                                    {{Form::text('nickname',$administrator->nickname,array('id'=>'nickname','maxlength'=>'50','class'=>'input-body'))}}&nbsp;<span class='text-inline'>50文字以内</span>
                                </div><!-- /controls -->
                            </div><!-- /control-group -->
                            <div class='control-group'>
                                <label class="control-label">メールアドレス</label>
                                <div class="controls">
                                    <i class='icon-envelope input-head'></i>
                                    {{Form::email('email',$administrator->email,array('id'=>'email','maxlength'=>'100','class'=>'input-body'))}}
                                </div><!-- /controls -->
                            </div><!-- /control-group -->
                            <div class='control-group'>
                                <label class="control-label">パスワード</label>
                                @if($administrator->id)
                                <div class="controls">
                                    <label class="checkbox inline">{{Form::checkbox('change_password',Fair::FLG_ON,false,array('id'=>'change_password'))}}変更する</label>
                                </div><!-- /controls -->
                                @else
                                {{Form::hidden('change_password',Fair::FLG_ON,array('id'=>'change_password'))}}
                                @endif
                                <div class="controls">
                                    <i class='icon-key input-head'></i>
                                    {{Form::password('password',array('maxlength'=>'50','class'=>'input-body','placeholder'=>'パスワード'))}}&nbsp;<span class='text-inline'>10文字以上50文字以内</span>
                                </div><!-- /controls -->
                                <div class="controls">
                                    <i class='icon-key input-head'></i>
                                    {{Form::password('confirm',array('maxlength'=>'50','class'=>'input-body','placeholder'=>'確認用パスワード'))}}&nbsp;<span class='text-inline'>10文字以上50文字以内</span>
                                </div><!-- /controls -->
                            </div><!-- /control-group -->
                            <div class='control-group'>
                                <label class="control-label">権限</label>
                                <div class="controls">
                                    {{Form::select('role',Administrator::$roleList,$administrator->role,array('class'=>'w150'))}}
                                </div><!-- /controls -->
                            </div><!-- /control-group -->
                            <hr/>
                            <div class="control-group">
                                {{Form::button($administrator->id?'修正する':'登録する',array('class'=>'btn btn-large btn-primary','style'=>'width:200px;','onclick'=>'submit();'))}}
                            </div><!-- /control-group -->
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
$(window).load(function(){
    $('input#change_password[type="checkbox"]').change();
})
$('input#change_password[type="checkbox"]').change(function(){
    if ($(this).is(':checked')) {
        $('input[type="password"]').removeAttr('disabled');
    } else {
        $('input[type="password"]').attr('disabled','disabled');
    }
});
</script>
@stop