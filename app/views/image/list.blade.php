@extends('layout')
{{-- Page content --}}
@section('style')
<style>
    tr.tr-title th{
        vertical-align: middle;
    }
    th.image-buttons {
        text-align:right;
        border-left:none;
    }
    th.image-buttons button {
        width:120px;
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
                                <h3> SC画像管理</h3>
                            </div>
                        </div><!-- /widget-header -->
                        <div class="widget-content">
                            @include('image._search')
                            <table class='table table-bordered' style='margin-top:10px;border-top:1px solid #dddddd;'>
                                @foreach($images as $image)
                                <tr class='tr-title'>
                                    <th colspan='4'>
                                        #{{$image->id}}&nbsp;{{$image->title}}
                                        <div style='float:right'>
                                        <span class='badge {{$image->state == Image::STATE_VALID ? 'badge-success':''}}'>{{Image::$stateList[$image->state]}}</span>
                                        <span class='badge {{$image->is_edit == Image::EDITED ? 'badge-success':''}}'>{{Image::$isEditList[$image->is_edit]}}</span>
                                        <span class='badge {{$image->is_upload == Image::UPLOADED ? 'badge-success':''}}'>{{Image::$isUploadList[$image->is_upload]}}</span>
                                        </div>
                                    </th>
                                    <th colspan='3' class='image-buttons'>
                                        <?php
                                        $stateButtonTitle = $image->state == Image::STATE_VALID ? '無効化' : '有効化';
                                        $stateButtonClass = $image->state == Image::STATE_VALID ? 'btn btn-danger btn-state' : 'btn btn-success btn-state';
                                        $uploadButtonTitle = '同期';
                                        $uploadButtonClass = $image->is_edit == Image::EDITED && $image->state === Image::STATE_VALID ? 'btn btn-primary btn-upload' : 'btn disabled';
                                        $editButtonTitle = '編集';
                                        $editButtonClass = 'btn btn-primary btn-edit';
                                        if($image->is_upload == Image::UPLOAD_REGIST) {
                                            $stateButtonTitle = '変更不可';
                                            $stateButtonClass = 'btn disabled';
                                            $uploadButtonTitle = '同期中';
                                            $uploadButtonClass = 'btn disabled';
                                            $editButtonTitle = '編集不可';
                                            $editButtonClass = 'btn disabled';
                                        }
                                        ?>
                                        {{Form::button($stateButtonTitle,array('class'=>$stateButtonClass,'image_id'=>$image->id,'id'=>'state_button_'.$image->id))}}&nbsp;
                                        {{Form::button($uploadButtonTitle,array('class'=>$uploadButtonClass,'image_id'=>$image->id,'id'=>'upload_button_'.$image->id))}}&nbsp;
                                        {{Form::button($editButtonTitle,array('class'=>$editButtonClass,'image_id'=>$image->id,'id'=>'edit_button_'.$image->id))}}
                                    </th>
                                </tr>
                                <tr>
                                    <td rowspan='3' style='text-align:center;width:160px;'>{{HTML::image($image->getFilePath(true),$image->title,array('style'=>'width:150px;height:150px;'))}}</td>
                                    <th>キャプション</th>
                                    <td colspan='7'>{{{$image->caption}}}</td>
                                </tr>
                                <tr>
                                    <th>画像カテゴリ</th>
                                    <td>{{{$image->category->name or '選択無し'}}}</td>
                                    <th>登録日</th>
                                    <td>{{date('Y/m/d',strtotime($image->created_at))}}</td>
                                    <th>更新日</th>
                                    <td>{{date('Y/m/d',strtotime($image->updated_at))}}</td>
                                </tr>
                                <tr>
                                    <th style='width:16%'>ゼクシィ</th>
                                    <td style='width:16%'>
                                        <span class='badge {{$image->zexy_id ? 'badge-success' : 'badge-error'}}'>{{$image->zexy_id ? '同期済' : '未同期'}}</span>
                                        &nbsp;/&nbsp;
                                        <span class='badge {{$image->upload_zexy === Image::NOT_UPLOAD ? 'badge-error' : 'badge-info'}}'>{{Image::$isUploadBadge[$image->upload_zexy]}}</span>
                                    </td>
                                    <th style='width:16%'>マイナビ</th>
                                    <td style='width:16%'>
                                        <span class='badge {{$image->mynavi_id ? 'badge-success' : 'badge-error'}}'>{{$image->mynavi_id ? '同期済' : '未同期'}}</span>
                                        &nbsp;/&nbsp;
                                        <span class='badge {{$image->upload_mynavi === Image::NOT_UPLOAD ? 'badge-error' : 'badge-info'}}'>{{Image::$isUploadBadge[$image->upload_mynavi]}}</span>
                                    </td>
                                    <th style='width:16%'>楽天</th>
                                    <td style='width:16%'>
                                        <span class='badge {{$image->rakuten_id ? 'badge-success' : 'badge-error'}}'>{{$image->rakuten_id ? '同期済' : '未同期'}}</span>
                                        &nbsp;/&nbsp;
                                        <span class='badge {{$image->upload_rakuten === Image::NOT_UPLOAD ? 'badge-error' : 'badge-info'}}'>{{Image::$isUploadBadge[$image->upload_rakuten]}}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='9'></td>
                                </tr>
                                @endforeach
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
<script>
$('.header_tab').click(function(){
    if($(this).hasClass('disabled')||$(this).hasClass('selected')){
        return;
    }
    $selected = $('.header_tab.selected').first();
    $selected.removeClass('selected');
    $('#'+$selected.attr('id').replace('tab_','')).hide();
    $(this).addClass('selected');
    $('#'+$(this).attr('id').replace('tab_','')).show();
});
$('button.btn-state').click(function(){
    if($(this).hasClass('disabled')) {
        return;
    }
    var url = '{{URL::to('image/change/state')}}';
    var id = $(this).attr('image_id');
    var data = {'id':id,'_token':'{{csrf_token()}}'}
    $.post(
        url,
        data,
        function(data){
            if(data.result==='success') {
                if(data.state == {{Image::STATE_VALID}}) {
                    $('#state_button_'+id).html("無効化");
                    $('#state_button_'+id).removeClass('btn-success');
                    $('#state_button_'+id).addClass('btn-danger');
                    if(data.is_edit=={{Image::EDITED}} && $data.is_upload != {{Image::UPLOAD_REGIST}}) {
                        //アップロードの有効化
                        $('#upload_button_'+id).addClass('btn-upload btn-primary');
                        $('#upload_button_'+id).removeClass('disabled');
                    }
                } else {
                    $('#state_button_'+id).html("有効化");
                    $('#state_button_'+id).removeClass('btn-danger');
                    $('#state_button_'+id).addClass('btn-success');
                    //アップロードの無効化
                    if(data.is_upload != {{Image::UPLOAD_REGIST}}) {
                        $('#upload_button_'+id).removeClass('btn-upload btn-primary');
                        $('#upload_button_'+id).addClass('disabled');
                    }
                }
            } else {
                alert(data.message);
            }
        },
        'json'
    );
});
$('button.btn-upload').click(function(){
    if($(this).hasClass('disabled')) {
        return;
    }
    var url = '{{URL::to('image/change/upload')}}';
    var id = $(this).attr('image_id');
    var data = {'id':id,'_token':'{{csrf_token()}}'}
    $.post(
        url,
        data,
        function(data){
            if(data.result==='success') {
                if(data.is_upload == {{Image::UPLOAD_REGIST}}) {
                    //アップロード登録
                    $('#upload_button_'+id).html('同期中');
                    $('#upload_button_'+id).removeClass('btn-upload btn-primary');
                    $('#upload_button_'+id).addClass('disabled');
                    //状態変更ボタン
                    $('#state_button_'+id).html('変更不可');
                    $('#state_button_'+id).removeClass('btn-state btn-success btn-danger');
                    $('#state_button_'+id).addClass('disabled');
                    //編集ボタン
                    $('#edit_button_'+id).html('編集不可');
                    $('#edit_button_'+id).removeClass('btn-edit btn-primary');
                    $('#edit_button_'+id).addClass('disabled');
                }
            } else {
                alert(data.message);
            }
        },
        'json'
    );
});
$('button.btn-edit').click(function(){
    if($(this).hasClass('disabled')) {
        return;
    }
    var id = $(this).attr('image_id');
    var url = '{{URL::to('image/edit')}}/'+id;
    window.location.href = url;
});
</script>
@stop
