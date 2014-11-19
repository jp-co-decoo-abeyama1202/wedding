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
                                                <div><i class="icon-upload-alt"></i>画像アップロード</div>
                                            </button>
                                        </a>
                                    </div><!-- /buttons -->
                                    <div class="buttons">
                                        <a href="{{URL::to('image/list')}}">
                                            <button class="btn btn-large btn-info btn-box" id="button_reflection">
                                                <div><i class="icon-th-list"></i>SC画像管理</div>
                                            </button>
                                        </a>
                                    </div><!-- /buttons -->
                                    <div class="buttons">
                                        <a href="{{URL::to('image/category')}}">
                                            <button class="btn btn-large btn-info btn-box" id="button_reflection">
                                                <div><i class="icon-tags"></i>画像カテゴリ管理</div>
                                            </button>
                                        </a>
                                    </div><!-- /buttons -->
                                    <div class="buttons">
                                        <a href="{{URL::to('image/download')}}">
                                            <button class="btn btn-large btn-info btn-box" id="button_reflection">
                                                <div><i class="icon-download-alt"></i>画像ダウンロード</div>
                                            </button>
                                        </a>
                                    </div><!-- /buttons -->
                                    <div class="buttons">
                                        <a href="{{URL::to('image/linking')}}">
                                            <button class="btn btn-large btn-info btn-box" id="button_reflection">
                                                <div><i class="icon-pushpin"></i>ダウンロード画像紐付</div>
                                            </button>
                                        </a>
                                    </div><!-- /buttons -->
                                </div><!-- /button-group --> 
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
