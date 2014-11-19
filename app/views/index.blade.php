@extends('layout')
{{-- Page content --}}
@section('style')
<style>
</style>
@stop
@section('content')
<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <div class="widget widget-nopad">
                        <div class="widget-header"> <i class="icon-calendar"></i>
                            <h3> トップページ</h3>
                        </div><!-- /widget-header -->
                        <div class="widget-content">
                            <fieldset class="button-set">
                                <div class="button-group">
                                    <div class="buttons">
                                        <a href="{{URL::to('fair/')}}">
                                            <button class="btn btn-large btn-info btn-box" id="button_reflection">
                                                <div><i class="icon-list-alt"></i>フェア管理</div>
                                            </button>
                                        </a>
                                    </div>
                                    <div class="buttons">
                                        <a href="{{URL::to('image/')}}">
                                            <button class="btn btn-large btn-info btn-box" id="button_reflection">
                                                <div><i class="icon-picture"></i>画像管理</div>
                                            </button>
                                        </a>
                                    </div>
                                    <div class="buttons">
                                        <a href="{{URL::to('special/')}}">
                                            <button class="btn btn-large btn-info btn-box" id="button_reflection">
                                                <div><i class="icon-star-empty"></i>特典管理</div>
                                            </button>
                                        </a>
                                    </div>
                                    <div class="buttons">
                                        <a href="{{URL::to('user/')}}">
                                            <button class="btn btn-large btn-info btn-box" id="button_reflection">
                                                <div><i class="icon-group"></i>ユーザ管理</div>
                                            </button>
                                        </a>
                                    </div>
                                    <div class="buttons">
                                        <a href="{{URL::to('admin/')}}">
                                            <button class="btn btn-large btn-info btn-box" id="button_reflection">
                                                <div><i class="icon-briefcase"></i>基本情報管理</div>
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
