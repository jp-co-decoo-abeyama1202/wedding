@extends('layout')
@section('style')
<style>
.form-horizontal .control-label {
    width: 140px;
}
.form-horizontal .controls
{
    margin-left: 150px!important;
    margin-bottom: 5px;
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
                        <div class="widget-header tabs">
                            <div class="header_title">
                                <i class="icon-pencil"></i>
                                <h3 id="page-title"> 画像編集</h3>
                            </div>
                            <div class="header-buttons">
                                <a href='{{URL::to('image/list')}}'>
                                    {{Form::button('戻る',array('class'=>'btn btn-primary'))}}
                                </a>
                            </div>
                            <div class="clear"></div>
                        </div><!-- /widget-header -->
                        <div class="widget-content">
                            {{Form::open(array('url'=>'image/edit','method'=>'post','id'=>'upload_form','class'=>'form-horizontal','files'=>true))}}
                            {{Form::hidden('id',$image->id)}}
                            <div class='control-group'>
                                <label class="control-label"></label>
                                <div class="controls">
                                    {{HTML::image($image->getFilePath(true),$image->title,array('width'=>'200px','height'=>'200px'))}}
                                </div><!-- /controls -->
                            </div><!-- /control-group -->
                            <div class="control-group">
                                <label class="control-label">画像変更</label>
                                <div class="controls">
                                    {{Form::file('image')}}
                                </div><!-- /controls -->
                            </div><!-- /control-group -->
                            <div class="control-group">
                                <label class="control-label">管理名</label>
                                <div class="controls">
                                    {{Form::text('title',$image->title,array('id'=>'title','maxlength'=>100))}}&nbsp;<span class="text-inline">(30文字まで)</span>
                                </div><!-- /controls -->
                            </div><!-- /control-group -->
                            <div class="control-group">
                                <label class="control-label">キャプション</label>
                                <div class="controls">
                                    {{Form::text('caption',$image->caption,array('id'=>'caption','maxlength'=>14))}}&nbsp;<span class="text-inline">(14文字まで)</span>
                                </div><!-- /controls -->
                            </div><!-- /control-group -->
                            <div class="control-group">
                                <label class="control-label">カテゴリ</label>
                                <div class="controls">
                                    {{Form::select('image_category_id',ImageCategory::getList(),$image->image_category_id,array('id'=>'image_category_id','class'=>'w150'))}}
                                </div><!-- /controls -->
                            </div><!-- /control-group -->
                            <hr/>
                            <div class="control-group control-group-head">
                                <h3>ゼクシィ設定項目</h3>
                            </div><!-- /controls -->
                            <div class="control-group">
                                <label class="control-label">同期</label>
                                <div class="controls">
                                    <label class='radio inline'>{{Form::radio('upload_zexy',Image::UPLOADED,$image->upload_zexy==Image::UPLOADED)}}する</label>
                                    <label class='radio inline'>{{Form::radio('upload_zexy',Image::NOT_UPLOAD,$image->upload_zexy==Image::NOT_UPLOAD)}}しない</label>
                                </div><!-- /controls -->
                            </div><!-- /control-group -->
                            <div class="control-group">
                                <label class="control-label">フォト区分</label>
                                <div class="controls">
                                    {{Form::select('zexy_photo_kbn',WorkZexyImage::$photoCategoryCdList,$image->zexy_photo_kbn,array('id'=>'zexy_photo_kbn','class'=>'w150'))}}
                                </div><!-- /controls -->
                            </div><!-- /control-group -->
                            <hr/>
                            <div class="control-group control-group-head">
                                <h3>マイナビ設定項目</h3>
                            </div><!-- /controls -->
                            <div class="control-group">
                                <label class="control-label">同期</label>
                                <div class="controls">
                                    <label class='radio inline'>{{Form::radio('upload_mynavi',Image::UPLOADED,$image->upload_mynavi==Image::UPLOADED)}}する</label>
                                    <label class='radio inline'>{{Form::radio('upload_mynavi',Image::NOT_UPLOAD,$image->upload_mynavi==Image::NOT_UPLOAD)}}しない</label>
                                </div><!-- /controls -->
                            </div><!-- /control-group -->
                            <div class="control-group">
                                <label class="control-label">フォトギャラリーに表示</label>
                                <div class="controls">
                                    表示できる枚数&nbsp;<span>{{count(WorkMynaviImage::photoShow()->get())}}</span>/<span>{{WorkMynaviImage::PHOTO_SHOW_MAX}}</span>枚<br/>
                                    @if(count(WorkMynaviImage::photoShow()->get()) >= WorkMynaviImage::PHOTO_SHOW_MAX)
                                    {{Form::hidden('mynavi_photo_show_flg',Fair::FLG_OFF)}}
                                    <label class="inline radio">{{Form::radio('mynavi_photo_show_flg',Fair::FLG_ON,$image->mynavi_photo_show_flg==Fair::FLG_ON,array('disabled'=>'disabled'))}}表示する</label>
                                    <label class="inline radio">{{Form::radio('mynavi_photo_show_flg',Fair::FLG_OFF,$image->mynavi_photo_show_flg==Fair::FLG_OFF,array('disabled'=>'disabled'))}}表示しない</label>
                                    @else
                                    <label class="inline radio">{{Form::radio('mynavi_photo_show_flg',$image->mynavi_photo_show_flg==Fair::FLG_ON,true)}}表示する</label>
                                    <label class="inline radio">{{Form::radio('mynavi_photo_show_flg',$image->mynavi_photo_show_flg==Fair::FLG_OFF,false)}}表示しない</label>
                                    @endif
                                </div><!-- /controls -->
                            </div><!-- /control-group -->
                            <div class="control-group">
                                <label class="control-label">ウェディングフォト診断</label>
                                <div class="controls">
                                    対象とできる枚数&nbsp;<span>{{count(WorkMynaviImage::inspirationSearch()->get())}}</span>/<span>{{WorkMynaviImage::INSPIRATION_SEARCH_MAX}}</span>枚<br/>
                                    @if(count(WorkMynaviImage::inspirationSearch()->get()) >= WorkMynaviImage::INSPIRATION_SEARCH_MAX)
                                    {{Form::hidden('mynavi_inspiration_search_flg',Fair::FLG_OFF)}}
                                    <label class="inline radio">{{Form::radio('mynavi_inspiration_search_flg',Fair::FLG_ON,$image->mynavi_inspiration_search_flg==Fair::FLG_ON,array('disabled'=>'disabled'))}}対象</label>
                                    <label class="inline radio">{{Form::radio('mynavi_inspiration_search_flg',Fair::FLG_OFF,$image->mynavi_inspiration_search_flg==Fair::FLG_OFF,array('disabled'=>'disabled'))}}対象外</label>
                                    @else
                                    <label class="inline radio">{{Form::radio('mynavi_inspiration_search_flg',Fair::FLG_ON,$image->mynavi_inspiration_search_flg==Fair::FLG_ON)}}対象</label>
                                    <label class="inline radio">{{Form::radio('mynavi_inspiration_search_flg',Fair::FLG_OFF,$image->mynavi_inspiration_search_flg==Fair::FLG_OFF)}}対象外</label>
                                    @endif
                                </div><!-- /controls -->
                            </div><!-- /control-group -->
                            <div class="control-group">
                                <label class="control-label">カテゴリ</label>
                                <div class="controls">
                                    {{Form::select('mynavi_category_id',WorkMynaviImage::$imageCategoryList,$image->mynavi_category_id,array('class'=>'w150'))}}
                                </div><!-- /controls -->
                            </div><!-- /control-group -->
                            <div class="control-group">
                                <label class="control-label">ウエディングフォト診断<br/>キーワード<br/>(3つまで選択可)</label>
                                <div class="controls">
                                    @foreach(WorkMynaviImage::$imageTagCategoryList as $imageTagCategory)
                                    <h3>{{$imageTagCategory['title']}}</h3>
                                    <table class='table'>
                                    @foreach($imageTagCategory['list'] as $categoryItem)
                                    <tr>
                                        <th>{{$categoryItem['title']}}</th>
                                        <?php $cnt=0;?>
                                        @foreach($categoryItem['ids'] as $categoryItemId)
                                        @if($cnt!==0&&$cnt%3===0)
                                        <th></th>
                                        @endif
                                        <td style='width:30%;'><label class='checkbox inline'>{{Form::checkbox('mynavi_tag_id[]',$categoryItemId,$image->checkTag($categoryItemId),array('class'=>'restricted_check','groups'=>'mynavi_tag_id'))}}{{WorkMynaviImage::$imageTagList[$categoryItemId]}}</label></td>
                                        <?php $cnt++?>
                                        @if($cnt%3===0)
                                        </tr><tr>
                                        @endif
                                        @endforeach
                                        @while($cnt%3!==0)
                                        <td></td>
                                        <?php $cnt++?>
                                        @endwhile
                                    </tr>
                                    @endforeach
                                    </table>
                                    @endforeach
                                </div><!-- /controls -->
                            </div><!-- /control-group -->
                            <hr/>
                            <div class="control-group control-group-head">
                                <h3>楽天設定項目</h3>
                            </div><!-- /controls -->
                            <div class="control-group">
                                <label class="control-label">同期</label>
                                <div class="controls">
                                    <label class='radio inline'>{{Form::radio('upload_rakuten',Image::UPLOADED,$image->upload_rakuten==Image::UPLOADED)}}する</label>
                                    <label class='radio inline'>{{Form::radio('upload_rakuten',Image::NOT_UPLOAD,$image->upload_rakuten==Image::NOT_UPLOAD)}}しない</label>
                                </div><!-- /controls -->
                            </div><!-- /control-group -->
                            <div class="control-group">
                                <label class="control-label">ジャンル</label>
                                <div class="controls">
                                    {{Form::select('rakuten_genre_id',WorkRakutenImage::$genreList,$image->rakuten_genre_id,array('class'=>'w150'))}}
                                </div><!-- /controls -->
                            </div><!-- /control-group -->
                            <hr/>
                            <div class="control-group">
                                {{Form::button('更新する',array('class'=>'btn btn-large btn-primary','style'=>'width:200px;','onclick'=>'submit();'))}}
                            </div><!-- /control-group -->
                            {{Form::close()}}
                            {{Form::hidden('mynavi_tag_id_limit',3,array('id'=>'mynavi_tag_id_limit'))}}
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
$(window).load(function(){
    var max = $('#mynavi_tag_id_limit').val();
    if(max <= $('input.restricted_check[type="checkbox"]:checked').length) {
        $('input.restricted_check[type="checkbox"]:not(:checked)').attr('disabled','disabled');
    } else {
        $('input.restricted_check[type="checkbox"]').removeAttr('disabled');
    }
});
$('input.restricted_check[type="checkbox"]').click(function(){
    var max = $('#'+$(this).attr('groups')+'_limit').val();
    if(max < $('input.restricted_check[type="checkbox"]:checked').length) {
        $(this).attr('checked',false);
    }
    if(max <= $('input.restricted_check[type="checkbox"]:checked').length) {
        $('input.restricted_check[type="checkbox"]:not(:checked)').attr('disabled','disabled');
    } else {
        $('input.restricted_check[type="checkbox"]').removeAttr('disabled');
    }
});

</script>
@stop