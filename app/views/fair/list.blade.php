@extends('layout')
{{-- Page content --}}
@section('style')
{{ HTML::style('assets/css/togglebutton.css'); }}
<style>
.header_title{
    float:left;
}
.widget-header .header_tab_group {
    float:right;
    border-left: 1px solid #ddd;
}
.widget-header .header_tab_group .header_tab{
    width:100px;
    text-align:center;
}
.widget-header .header_tab_group .header_tab h3 {
    left:0;
    margin-right:0;
    padding: 8px 20px 5px;
}
.widget-header .header_tab_group .header_tab.selected {
    background-color:transparent;
    border-top:transparent;
    border-right: 1px solid #ddd;
    cursor:pointer;
}
.widget-header .header_tab_group .header_tab.selected h3 {
    background-color:whitesmoke;
    border-radius: 3px;
    box-shadow: inset 0 2px 3px rgba(0, 0, 0, 0.15), 0 1px 2px rgba(0, 0, 0, 0.05);
    color:blue;
}
#fair_list thead th {
    text-align:center;
    vertical-align: middle;
}
#fair_list thead th select{
    margin-bottom:0;
}
</style>
@stop
@section('content')
<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <div class="widget widget-table action-table">
                        <div class="widget-header">
                            <div class="header_title">
                                <i class="icon-th-list"></i>
                                <h3 id="page-title"> テンプレート管理</h3>
                            </div>
                            <div class="header_tab_group">
                                <div class="header_tab selected" id="page_tab_gnavi">
                                    <h3 id="page-title"> ぐるナビ</h3>
                                </div>
                                <div class="header_tab" id="page_tab_mwed">
                                    <h3 id="page-title"> みんなの</h3>
                                </div>
                                <div class="header_tab" id="page_tab_mynavi">
                                    <h3 id="page-title"> マイナビ</h3>
                                </div>
                                <div class="header_tab" id="page_tab_park">
                                    <h3 id="page-title"> パーク</h3>
                                </div>
                                <div class="header_tab" id="page_tab_rakuten">
                                    <h3 id="page-title"> 楽天</h3>
                                </div>
                                <div class="header_tab" id="page_tab_sugukon">
                                    <h3 id="page-title"> すぐ婚</h3>
                                </div>
                                <div class="header_tab" id="page_tab_zexy">
                                    <h3 id="page-title"> ゼクシィ</h3>
                                </div>
                            </div>
                        </div><!-- /widget-header -->
                        <div class="widget-content">
                            <table id="fair_list" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width:90px;">{{Form::select('search_site',array(null=>'【サイト名】')+Site::$_site_names,'',array('id'=>'search_site','class'=>'w100p'))}}</th>
                                        <th style="width:90px;">{{Form::select('search_state',array(null=>'【状態】')+Fair::$stateList,'',array('id'=>'search_site','class'=>'w100p'))}}</th>
                                        <th>{{Form::select('search_name',array(null=>'フェアタイトル'),null,array('id'=>'search_name','class'=>'w100p'))}}</th>
                                        <th style="width:150px;">{{Form::select('search_created_at',array(null=>'登録日'),null,array('id'=>'search_created_at','class'=>'w100p'))}}</th>
                                        <th style="width:150px;">{{Form::select('search_updated_at',array(null=>'最終更新日'),null,array('id'=>'search_updated_at','class'=>'w100p'))}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($fairs as $fair)
                                    <tr>
                                        <td>{{$fair->siteNames('<br/>')}}</td>
                                        <td>{{Fair::$stateList[$fair->state]}}</td>
                                        <td><a href="{{URL::to('fair/detail',$fair->id)}}">{{str_limit($fair->fair_name,100)}}</a></td>
                                        <td>{{$fair->created_at}}</td>
                                        <td>{{$fair->updated_at}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>サイト名</th>
                                        <th>状態</th>
                                        <th>フェアタイトル</th>
                                        <th>登録日</th>
                                        <th>最終更新日</th>
                                    </tr>
                                </tfoot>
                            </table>
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
