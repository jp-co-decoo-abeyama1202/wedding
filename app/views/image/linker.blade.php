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
                        <div class="widget-header tabs">
                            <div class="header_title">
                                <i class="icon-pushpin"></i>
                                <h3> ダウンロード画像紐付</h3>
                            </div>
                            <div class="header-buttons">
                                <a href='{{URL::to('image/linking')}}'>
                                    {{Form::button('戻る',array('class'=>'btn btn-primary'))}}
                                </a>
                            </div>
                        </div><!-- /widget-header -->
                        <div class="widget-content">
                            <table class='table table-bordered' style='margin-bottom:10px;'>
                                <tr>
                                    <th colspan='3'><h3>選択中の画像</h3></th>
                                </tr>
                                <tr>
                                    <td rowspan='4' style='text-align:center;'>{{HTML::image($image->getFilePath(true),$image->photo_caption,array('style'=>'width:200px;height:200px'))}}</td>
                                    <th>タイトル</th>
                                    <td>{{$image->photo_title.$image->name}}</td>
                                </tr>
                                <tr>
                                    <th>キャプション</th>
                                    <td>{{$image->photo_caption.$image->title}}</td>
                                </tr>
                                <tr>
                                    <th>紐付有無</th>
                                    <td>{{$image->image_id ? '紐付済み' : '未紐付'}}</td>
                                </tr>
                                <tr>
                                    <td colspan='2'>
                                        @if(false)
                                        {{Form::button('この画像をSCに登録する',array('class'=> 'btn btn-large btn-primary','style'=>'width:230px;'))}}
                                        @endif
                                    </td>
                                </tr>
                            </table>
                            @include('image._search')
                            <table class='table table-striped table-bordered'>
                                <tr>
                                    <th colspan='5'><h3>紐付先の選択</h3></th>
                                </tr>
                                <?php $cnt = 0 ?>
                                @foreach($images as $img)
                                @if($cnt % 5 === 0)
                                <tr>
                                @endif
                                    <td style='text-align:center;width:20%;'>
                                        <div>
                                            {{HTML::image($img->getFilePath(true),$image->caption,array('style'=>'width:150px;height:150px'))}}
                                            <div style='margin-top:10px;'>
                                            @if($img->fairs()->whereState(Fair::STATE_UPLOAD_NOW)->count())
                                            {{Form::button('出稿済フェア登録中',array('class'=>'btn btn-large disabled','style'=>'width:180px;'))}}
                                            @else
                                            {{Form::open(array('url'=>'image/linked','method'=>'post'))}}
                                                <?php
                                                $btnClass = 'btn btn-large btn-primary';
                                                $btnText = '紐付する';
                                                if($img->$checkId) {
                                                    if($img->$checkId == $image->id) {
                                                        $btnClass = 'btn btn-large btn-warning';
                                                        $btnText = 'この画像との紐付解除';
                                                    } else {
                                                        $btnClass = 'btn btn-large btn-danger';
                                                        $btnText = '他画像と紐付中';
                                                    }
                                                }   
                                                ?>
                                                {{Form::submit($btnText,array('class'=> $btnClass,'style'=>'width:180px;'))}}
                                                {{Form::hidden('image_id',$img->id)}}
                                                {{Form::hidden('work_image_id',$image->id)}}
                                                {{Form::hidden('site_id',$siteId)}}
                                            {{Form::close()}}
                                            @endif
                                            </div>
                                        </div>
                                    </td>
                                <?php $cnt++; ?>
                                @if($cnt % 5 === 0)
                                </tr>
                                @endif
                                @endforeach
                                @while($cnt % 5 !== 0)
                                <td style='text-align:center;width:20%;'></td>
                                <?php $cnt++;?>
                                @if($cnt % 5 === 0)
                                </tr>
                                @endif
                                @endwhile
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
