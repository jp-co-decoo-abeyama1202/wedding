@extends('layout')
@section('style')
{{ HTML::style('assets/css/pages/fair.css?t=aaaaaaaas'); }}
<style>
.changes {
    text-align: center;	
}

.changes .change { 
    width: 60px;
    display: inline-block;
    padding: 12px 0;
    margin: 0 .9% 1em;
    vertical-align: top;
    text-decoration: none;
    background: #f9f6f1;
    border-radius: 5px;
}

.changes .change .change-icon {
    margin-top: .25em;
    margin-bottom: .25em;

    font-size: 32px;
    color: #545454;
}

.changes .change:hover {
    background: #00ba8b;
}

.changes .change:hover span{
    color: #fff;
}

.changes .change:hover .change-icon {
    color: #fff;
}

.changes .change-label {
    display: block;
    font-weight: 400;
    color: #545454;
}

.widget-header .header-titles {
    float:left;
}
.widget-header .header-buttons {
    float:right;
    margin-right:10px;
}    
</style>
@stop
@section('content')
<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span2">
                    <div class="widget">
                        <div class="widget-header"> <i class="icon-bookmark"></i>
                            <h3>切替</h3>
                        </div><!-- /widget-header -->
                        <div class="widget-content">
                            <div class="changes">
                                <a class="change"><i class="change-icon icon-list-alt"></i><span class="change-label">総合</span> </a>
                                <a class="change"><i class="change-icon icon-list-alt"></i><span class="change-label">ぐるナビ</span> </a>
                                <a class="change"><i class="change-icon icon-bookmark"></i><span class="change-label">みんなの</span> </a>
                                <a class="change"><i class="change-icon icon-signal"></i> <span class="change-label">マイナビ</span> </a>
                                <a class="change"><i class="change-icon icon-comment"></i><span class="change-label">パーク</span> </a>
                                <a class="change"><i class="change-icon icon-user"></i><span class="change-label">楽天</span> </a>
                                <a class="change"><i class="change-icon icon-file"></i><span class="change-label">すぐ婚</span> </a>
                                <a class="change"><i class="change-icon icon-picture"></i> <span class="change-label">Zexy</span> </a>
                            </div><!-- /changes --> 
                        </div><!-- /widget-content --> 
                    </div><!-- /widget -->
                </div><!-- /span2 -->
                <div class="span10">
                    <div class="widget widget-nopad">
                        <div class="widget-header">
                            <div class="header-titles">
                                <i class="icon-calendar"></i>
                                <h3 id="page-title"> 総合</h3>
                            </div>
                            <div class="header-buttons">
                                <button class="btn btn-primary">編　集</button>
                                <button class="btn btn-info">コピー</button>
                                <button class="btn btn-danger">削　除</button>
                            </div>
                        </div><!-- /widget-header -->
                        <div class="widget-content">
                            <table id="master">
                                @foreach($fair->toArray() as $key => $value)
                                <tr><th>{{$key}}</th><td>{{$value}}</td></tr>
                                @endforeach
                            </table>
                        </div><!-- /widget-content --> 
                    </div><!-- /widget -->
                </div><!-- /span10 -->
            </div><!-- /row -->
        </div><!-- container -->
    </div><!-- /main-inner -->
</div><!-- /main -->
@stop
