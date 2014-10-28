@extends('layout')
@section('style')
<style>
.header_tab {
    float:left;
    border-right: 1px solid #ddd;
    border-bottom-color: transparent;
    cursor:pointer;
}
.header_tab.selected
{
    color: #555555;
    background-color: #ffffff;
    border-right: 1px solid #ddd;
    border-top: 1px solid #ddd;
    border-bottom-color: transparent;
    cursor: default;
}
.header_tab.disabled
{
    cursor: default;
}
.header_tab.disabled i,
.header_tab.disabled h3
{
    color:#ddd;
}
.widget-header .header-titles {
    float:left;
}
.widget-header .header-buttons {
    float:right;
    margin-right:10px;
}
.form-horizontal {
    margin:20px;
}
.form-horizontal .controls
{
    margin-left: 100px!important;
    margin-bottom: 5px;
}
.form-horizontal .control-label {
    width: 85px;
}
.hhmm, 
.w50
{
    width:50px;
}
.w30 {
    width:30px;
}
.w80 {
    width:80px;
}
.w100 {
    width:100px;
}
.w150 {
    width:150px;
}
.w300 {
    width:300px;
}
.w450 {
    width:450px;
}
//control-groupのさらに子要素
.form-horizontal .control-group-group {
    margin-bottom:18px;
}
.form-horizontal .control-group-group .controls {
    margin-bottom:5px;
}
.form-horizontal .controls .control-label {
    width:65px!important;
    margin-right:15px;
}
span.text-inline {
    padding-top:5px;
    display:inline-block;
    vertical-align:middle;
}
.controls .controls-inline {
    margin-top:5px;
    margin-bottom:5px;
}
.controls .controls-inline .controls {
    margin-left: 80px!important;
    padding-bottom:5px;
}
/* box-color */
.has-warning {
  border-color: #f39c12 !important;
  border-width: 2px;
  box-shadow: none;
}
.has-error {
  border-color: #f56954 !important;
  border-width: 2px;
  box-shadow: none;
}
.badge {
  cursor:auto!important;
}
.clear {
    clear:both;
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
                        <div class="widget-header">
                            <div class="header_title">
                                <i class="icon-picture"></i>
                                <h3 id="page-title"> 画像アップロード</h3>
                            </div>
                            <div class="clear"></div>
                        </div><!-- /widget-header -->
                        <div class="widget-content">
                            {{Form::open(array('url'=>'image/upload','method'=>'post','id'=>'upload_form','class'=>'form-horizontal','file'=>true))}}
                            <div class="control-group">
                                <label class="control-label">画像選択</label>
                                <div class="controls">
                                    {{Form::file('image')}}
                                </div><!-- /controls -->
                            </div><!-- /control-group -->
                            <div class="control-group">
                                <label class="control-label">キャプション</label>
                                <div class="controls">
                                    {{Form::text('caption','',array('id'=>'caption','maxlength'=>14))}}<span class="text-inline">(14文字まで)</span>
                                </div><!-- /controls -->
                            </div><!-- /control-group -->
                            <div class="control-group">
                                <label class="control-label">カテゴリ</label>
                                <div class="controls">
                                    {{Form::text('caption','',array('id'=>'caption','maxlength'=>14))}}<span class="text-inline">(14文字まで)</span>
                                </div><!-- /controls -->
                            </div><!-- /control-group -->
                            {{Form::close()}}
                        </div>
                    </div><!-- /widget -->
                </div><!-- /span10 -->
            </div><!-- /row -->
        </div><!-- container -->
    </div><!-- /main-inner -->
</div><!-- /main -->
@stop
@section('scripts')
<script>
</script>
@stop