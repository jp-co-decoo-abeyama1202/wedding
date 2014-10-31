@extends('layout')
{{-- Page content --}}
@section('style')
@stop
@section('content')
<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <div class="widget widget-nopad">
                        <div class="widget-header"> <i class="icon-calendar"></i>
                            <h3> TOP</h3>
                        </div><!-- /widget-header -->
                        <div class="widget-content">
                            <fieldset class="button-set">
                                <div class="button-group">
                                    <div class="buttons">
                                        <a href="{{URL::to('fair/')}}">
                                            <button class="btn btn-large btn-info btn-box" id="button_reflection">
                                                <i class="icon-list-alt"></i>&nbsp;フェア管理
                                            </button>
                                        </a>
                                    </div>
                                    <div class="buttons">
                                        <a href="{{URL::to('image/')}}">
                                            <button class="btn btn-large btn-info btn-box" id="button_reflection">
                                                <i class="icon-picture"></i>&nbsp;画像管理
                                            </button>
                                        </a>
                                    </div>
                                    <div class="buttons">
                                        <a href="{{URL::to('special/')}}">
                                            <button class="btn btn-large btn-info btn-box" id="button_reflection">
                                                <i class="icon-star-empty"></i>&nbsp;特典管理
                                            </button>
                                        </a>
                                    </div>
                                    <div class="buttons">
                                        <a href="{{URL::to('user/')}}">
                                            <button class="btn btn-large btn-info btn-box" id="button_reflection">
                                                <i class="icon-group"></i>&nbsp;ユーザ管理
                                            </button>
                                        </a>
                                    </div>
                                    <div class="buttons">
                                        <a href="{{URL::to('admin/')}}">
                                            <button class="btn btn-large btn-info btn-box" id="button_reflection">
                                                <i class="icon-briefcase"></i>&nbsp;基本情報管理
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
