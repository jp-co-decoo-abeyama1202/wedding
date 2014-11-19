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
                    <div class="widget widget-table action-table">
                        <div class="widget-header"> <i class="icon-download-alt"></i>
                            <h3> 画像ダウンロード</h3>
                        </div><!-- /widget-header -->
                        <div class="widget-content">
                            {{Form::open(array('url'=>'image/download','method'=>'post'))}}
                            <table class='table table-striped table-bordered'>
                                <tr>
                                    <th style='width:30px;'>DL</th>
                                    <th>サイト名</th>
                                    <th>状態</th>
                                </tr>
                                <tr>
                                    @if(ImageUpload::checkZexy())
                                    <td>{{Form::checkbox('download_zexy',Fair::FLG_ON,false)}}</td>
                                    @else
                                    <td>{{Form::checkbox('download_zexy',Fair::FLG_ON,false,array('disabled'=>'disabled'))}}</td>
                                    @endif
                                    <td>ゼクシィ</td>
                                    <td>{{ImageUpload::checkZexy() ? '待機中' : '取得中'}}
                                </tr>
                                <tr>
                                    @if(ImageUpload::checkMynavi())
                                    <td>{{Form::checkbox('download_mynavi',Fair::FLG_ON,false)}}</td>
                                    @else
                                    <td>{{Form::checkbox('download_mynavi',Fair::FLG_ON,false,array('disabled'=>'disabled'))}}</td>
                                    @endif
                                    <td>マイナビ</td>
                                    <td>{{ImageUpload::checkMynavi() ? '待機中' : '取得中'}}
                                </tr>
                                <tr>
                                    @if(ImageUpload::checkRakuten())
                                    <td>{{Form::checkbox('download_rakuten',Fair::FLG_ON,false)}}</td>
                                    @else
                                    <td>{{Form::checkbox('download_rakuten',Fair::FLG_ON,false,array('disabled'=>'disabled'))}}</td>
                                    @endif
                                    <td>楽天</td>
                                    <td>{{ImageUpload::checkRakuten() ? '待機中' : '取得中'}}
                                </tr>
                                <tr>
                                    <td colspan='3'>
                                        {{Form::button('画像ダウンロード',array('class'=>'btn btn-large btn-primary','style'=>'width:200px;','onclick'=>'submit();'))}}<br/>
                                        <span class='text-red'>※状態が取得中の場合、該当サイトへの画像ダウンロード処理を実行しています</span>
                                    </td>
                                </tr>
                            </table>
                            {{Form::close()}}
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
