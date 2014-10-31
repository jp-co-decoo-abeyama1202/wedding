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
                        <div class="widget-header"> <i class="icon-briefcase"></i>
                            <h3> 基本情報管理</h3>
                        </div><!-- /widget-header -->
                        <div class="widget-content">
                            <fieldset class="button-set">
                                <div class="button-group">
                                    <div class="buttons">
                                        <a href="{{URL::to('admin/company')}}">
                                            <button class="btn btn-large btn-info btn-box" id="button_reflection">
                                                <i class="icon-info-sign"></i>&nbsp;会社情報管理
                                            </button>
                                        </a>
                                    </div>
                                    <div class="buttons">
                                        <a href="{{URL::to('admin/holl')}}">
                                            <button class="btn btn-large btn-info btn-box" id="button_reflection">
                                                <i class="icon-flag"></i>&nbsp;会場情報管理
                                            </button>
                                        </a>
                                    </div>
                                    <div class="buttons">
                                        <a href="{{URL::to('admin/infomation')}}">
                                            <button class="btn btn-large btn-info btn-box" id="button_reflection">
                                                <i class="icon-signin"></i>&nbsp;ID・PASSWORD管理
                                            </button>
                                        </a>
                                    </div>
                                    <div class="buttons">
                                        <a href="{{URL::to('fair/infoupdate')}}">
                                            <button class="btn btn-large btn-info btn-box" id="button_reflection">
                                                <i class="icon-cog"></i>&nbsp;情報更新管理
                                            </button>
                                        </a>
                                    </div>
                                    <div class="buttons">
                                        <a href="{{URL::to('fair/format')}}">
                                            <button class="btn btn-large btn-info btn-box" id="button_reflection">
                                                <i class="icon-trash"></i>&nbsp;初期化
                                            </button>
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
