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
                        <div class="widget-header"> <i class="icon-star-empty"></i>
                            <h3> 特典管理</h3>
                        </div><!-- /widget-header -->
                        <div class="widget-content">
                            <fieldset class="button-set">
                                <div class="button-group">
                                    <div class="buttons">
                                        <a href="{{URL::to('special/list')}}">
                                            <button class="btn btn-large btn-info btn-box" id="button_reflection">
                                                <div><i class="icon-th-list"></i>SC特典管理</div>
                                            </button>
                                        </a>
                                    </div>
                                    <div class="buttons">
                                        <a href="{{URL::to('special/download')}}">
                                            <button class="btn btn-large btn-info btn-box" id="button_reflection">
                                                <div><i class="icon-download-alt"></i>特典ダウンロード</div>
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
