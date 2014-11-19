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
                            <div class="header_title" id="page_tab_total">
                                <i class="icon-pushpin"></i>
                                <h3> ダウンロード画像紐付</h3>
                            </div>
                            <div class='header_tabs'>
                                <div class="header_tab selected" id="table_tab_zexy">
                                    <i class="icon-table"></i>
                                    <h3 id="page-title"> ゼクシィ</h3>
                                </div>
                                <div class="header_tab" id="table_tab_mynavi">
                                    <i class="icon-table"></i>
                                    <h3 id="page-title"> マイナビ</h3>
                                </div>
                                <div class="header_tab" id="table_tab_rakuten">
                                    <i class="icon-table"></i>
                                    <h3 id="page-title"> 楽天</h3>
                                </div>
                            </div>
                            <div class='clear'></div>
                        </div><!-- /widget-header -->
                        <div class="widget-content">
                            {{-- Zexy --}}
                            <table id='table_zexy' class='table table-striped table-bordered' style='margin-top:10px;border-top:1px solid #dddddd;'>
                                <?php $cnt = 0 ?>
                                @foreach($zexyImages as $image)
                                @if($cnt % 5 === 0)
                                <tr>
                                @endif
                                    <td style='text-align:center;width:20%;'>
                                        {{HTML::image($image->getFilePath(true),$image->photo_caption,array('style'=>'width:150px;height:150px'))}}
                                        <?php $btnClass = $image->image_id ? 'btn btn-large btn-warning' : 'btn btn-large btn-primary'; ?>
                                        <div style='margin-top:10px;'>
                                            <a href='{{URL::to('image/linker',array(SiteZexy::SITE_LOGIN_ID,$image->id))}}'>
                                                {{Form::button($image->image_id ? '紐付済み' :'紐付する',array('class'=>$btnClass,'style'=>'width:150px;'))}}
                                            </a>
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
                            {{-- Mynavi --}}
                            <table id='table_mynavi' class='table table-striped table-bordered' style='display:none;margin-top:10px;border-top:1px solid #dddddd;'>
                                <?php $cnt = 0 ?>
                                @foreach($mynaviImages as $image)
                                @if($cnt % 5 === 0)
                                <tr>
                                @endif
                                    <td style='text-align:center;width:20%;'>
                                        {{HTML::image($image->getFilePath(true),$image->title,array('style'=>'width:150px;height:150px'))}}
                                        <?php $btnClass = $image->image_id ? 'btn btn-large btn-warning' : 'btn btn-large btn-primary'; ?>
                                        <div style='margin-top:10px;'>
                                            <a href='{{URL::to('image/linker',array(SiteMynavi::SITE_LOGIN_ID,$image->id))}}'>
                                                {{Form::button($image->image_id ? '紐付済み' :'紐付する',array('class'=>$btnClass,'style'=>'width:150px;'))}}
                                            </a>
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
                            {{-- Rakuten --}}
                            <table id='table_rakuten' class='table table-striped table-bordered' style='display:none;margin-top:10px;border-top:1px solid #dddddd;'>
                                <?php $cnt = 0 ?>
                                @foreach($zexyImages as $image)
                                @if($cnt % 5 === 0)
                                <tr>
                                @endif
                                    <td style='text-align:center;width:20%;'>
                                        {{HTML::image($image->getFilePath(true),$image->photo_caption,array('style'=>'width:150px;height:150px'))}}
                                        <?php $btnClass = $image->image_id ? 'btn btn-large btn-warning' : 'btn btn-large btn-primary'; ?>
                                        <div style='margin-top:10px;'>
                                            <a href='{{URL::to('image/linker',array(SiteRakuten::SITE_LOGIN_ID,$image->id))}}'>
                                                {{Form::button($image->image_id ? '紐付済み' :'紐付する',array('class'=>$btnClass,'style'=>'width:150px;'))}}
                                            </a>
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
</script>
@stop
