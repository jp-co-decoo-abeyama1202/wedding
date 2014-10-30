@extends('layout')
{{-- Page content --}}
@section('style')
<style>
fieldset.button-set {
    margin:20px;
}
.button-group {
    margin-bottom:9px;
    text-align:center;
}
.button-group .buttons button {
    width:300px;
    margin-bottom:10px;
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
                        <div class="widget-header"> <i class="icon-group"></i>
                            <h3> ログイン管理</h3>
                        </div><!-- /widget-header -->
                        <div class="widget-content">
                            <fieldset class="button-set">
                                <div class="button-group">
                                    <div class="buttons">
                                        <a href="{{URL::to('user/password')}}">
                                            <button class="btn btn-large btn-info" id="button_reflection">パスワード変更</button>
                                        </a>
                                    </div>
                                    <div class="buttons">
                                        <a href="{{URL::to('user/new')}}">
                                            <button class="btn btn-large btn-info" id="button_reflection">新規登録</button>
                                        </a>
                                    </div>
                                    <div class="buttons">
                                        <a href="{{URL::to('user/list')}}">
                                            <button class="btn btn-large btn-info" id="button_reflection">一覧</button>
                                        </a>
                                    </div>
                                </div>
                            </fieldset>
                        </div><!-- /widget-content --> 
                    </div><!-- /widget -->
                </div><!-- /span10 -->
            </div><!-- /row -->
        </div><!-- /container -->
    </div><!-- /main-inner -->
</div><!-- /main -->
@stop
@section('scripts')
@stop
