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
                        <div class="widget-header"> <i class="icon-picture"></i>
                            <h3> 画像管理</h3>
                        </div><!-- /widget-header -->
                        <div class="widget-content">
                            <fieldset class="button-set">
                                <div class="button-group">
                                    <div class="buttons">
                                        <a href="{{URL::to('image/upload')}}">
                                            <button class="btn btn-large btn-info btn-box" id="button_reflection">
                                                <i class="icon-upload-alt"></i>
                                                &nbsp;画像アップロード
                                            </button>
                                        </a>
                                    </div>
                                    <div class="buttons">
                                        <a href="{{URL::to('image/list')}}">
                                            <button class="btn btn-large btn-info btn-box" id="button_reflection">
                                                <i class="icon-th-list"></i>
                                                &nbsp;SC画像管理
                                            </button>
                                        </a>
                                    </div>
                                    <div class="buttons">
                                        <a href="{{URL::to('image/get')}}">
                                            <button class="btn btn-large btn-info btn-box" id="button_reflection">
                                                <i class="icon-download-alt"></i>
                                                &nbsp;画像ダウンロード
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
