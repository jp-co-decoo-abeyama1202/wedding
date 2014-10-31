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
                        <div class="widget-header"> <i class="icon-list-alt"></i>
                            <h3> フェア管理</h3>
                        </div><!-- /widget-header -->
                        <div class="widget-content">
                            <fieldset class="button-set">
                                <div class="button-group">
                                    <div class="buttons">
                                        <a href="{{URL::to('fair/control')}}">
                                            <button class="btn btn-large btn-info btn-box" id="button_reflection">
                                                <i class="icon-calendar"></i>&nbsp;稼働中フェア管理
                                            </button>
                                        </a>
                                    </div>
                                    <div class="buttons">
                                        <a href="{{URL::to('fair/new')}}">
                                            <button class="btn btn-large btn-info btn-box" id="button_reflection">
                                                <i class="icon-pencil"></i>&nbsp;テンプレート作成
                                            </button>
                                        </a>
                                    </div>
                                    <div class="buttons">
                                        <a href="{{URL::to('fair/list')}}">
                                            <button class="btn btn-large btn-info btn-box" id="button_reflection">
                                                <i class="icon-th-list"></i>&nbsp;テンプレート管理
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
