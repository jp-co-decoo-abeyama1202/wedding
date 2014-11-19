@extends('layout')
@section('style')
<style>
fieldset > h3 {
    border-bottom:1px solid #dddddd;
    padding-bottom:5px;
    padding-left:5px;
    margin-bottom:5px;
}
ul#edit_status {
    border-bottom:1px solid #dddddd;
    margin:0;
    padding:8px 0 8px 10px;
}
ul#edit_status li {
    display:inline;
    padding:5px 2px;
    color:black;
}
ul#edit_status li.disabled {
    color:#dddddd;
}
ul#edit_status li.disabled.back:hover {
    color:black;
    cursor:pointer;
}
ul#edit_status li:not(:last-child):after {
    content:">>";
    margin-left:5px;
    color:black;
}
.gnavis,.mweds,.mynavis,.parks,.rakutens,.sugukons,.zexys {
    display:none;
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
                            <div class="header_tab selected" id="page_tab_total">
                                <i class="icon-edit"></i>
                                <h3 id="page-title"> 総合</h3>
                            </div>
                            <div class="header_tab {{$fair->flg_gnavi?'':'disabled'}}" id="page_tab_gnavis">
                                <i class="icon-edit"></i>
                                <h3 id="page-title"> ぐるナビ</h3>
                            </div>
                            <div class="header_tab {{$fair->flg_mwed?'':'disabled'}}" id="page_tab_mweds">
                                <i class="icon-edit"></i>
                                <h3 id="page-title"> みんなの</h3>
                            </div>
                            <div class="header_tab {{$fair->flg_mynavi?'':'disabled'}}" id="page_tab_mynavis">
                                <i class="icon-edit"></i>
                                <h3 id="page-title"> マイナビ</h3>
                            </div>
                            <div class="header_tab {{$fair->flg_park?'':'disabled'}}" id="page_tab_parks">
                                <i class="icon-edit"></i>
                                <h3 id="page-title"> パーク</h3>
                            </div>
                            <div class="header_tab {{$fair->flg_rakuten?'':'disabled'}}" id="page_tab_rakutens">
                                <i class="icon-edit"></i>
                                <h3 id="page-title"> 楽天</h3>
                            </div>
                            <div class="header_tab {{$fair->flg_sugukon?'':'disabled'}}" id="page_tab_sugukons">
                                <i class="icon-edit"></i>
                                <h3 id="page-title"> すぐ婚</h3>
                            </div>
                            <div class="header_tab {{$fair->flg_zexy?'':'disabled'}}" id="page_tab_zexys">
                                <i class="icon-edit"></i>
                                <h3 id="page-title"> ゼクシィ</h3>
                            </div>
                            <div class="clear"></div>
                        </div><!-- /widget-header -->
                        <div class="widget-content">
                            <ul id="edit_status">
                                <li class="disabled" page="1">1.初期選択</li>
                                <li class="disabled" page="2">2.基本情報入力</li>
                                <li class="disabled" page="3">3.基本フェア構成作成</li>
                                <li class="disabled" page="4">4.画像選択</li>
                                <li class="disabled" page="5">5.特典入力</li>
                                <li class="disabled" page="6">6.掲載期間及び受付方法</li>
                                <li class="disabled" page="7">7.アクセスデータ</li>
                                <li class="disabled" page="8">8.個別設定項目</li>
                            </ul>
                            <div id="fair-edit-error" class="alert alert-danger alert-block hide" style="margin: 15px 23px 10px;">
                                <h4>エラー</h4>
                                <span id="fair-edit-error-body"></span>
                            </div>
                            {{Form::open(array('url'=>'fair/confirm','method'=>'post','id'=>'edit_form','class'=>'form-horizontal'))}}
                                {{Form::hidden('id',$fair->id)}}
                                {{Form::hidden('only_total',false,array('id'=>'only_total'))}}
                                @for($i=1;$i<=9;$i++)
                                    @include('fair.edit.page'.$i)
                                @endfor
                            {{Form::close()}}
                        </div>
                    </div><!-- /widget -->
                    <!-- imageModal -->
                    @include('fair.edit._contents')
                    @include('image._modal')
                </div><!-- /span10 -->
            </div><!-- /row -->
        </div><!-- container -->
    </div><!-- /main-inner -->
</div><!-- /main -->
@stop
@section('scripts')
{{ HTML::script('assets/js/pages/fair.edit.js')}}
<script>
function page_validate(next) {
    loading(true);
    var url = '{{URL::to('fair/page/validation').'/'}}'+page;
    var data = {'_token':'{{csrf_token()}}'}
    $('input,select,textarea').map(function() {
        if(($(this).attr('type')=='checkbox'||$(this).attr('type')=='radio')) {
            if($(this).is(':checked')) {
                data[$(this).attr('name')] = $(this).val();
            }
        } else {
            data[$(this).attr('name')] = $(this).val();
        }
    });
    $.post(
        url,
        data,
        function(data){
            loading(false);
            if(data.result == 'failed') {
                $('#fair-edit-error').show();
                $('#fair-edit-error-body').html(data.message);
                var p = $(".widget-content").offset().top;
                $('html,body').animate({ scrollTop: p }, 'fast');
            } else {
                $('#fair-edit-error').hide();
                if(next) {
                    page++;
                    if(page === max_page) {
                        page_last();
                    } else {
                        page_move(page);
                    }
                }
            }
        },
        'json'
    );
}
function page_last(){
    loading(true);
    var url = '{{URL::to('fair/page/last')}}';
    var data = {'_token':'{{csrf_token()}}'}
    $('input,select,textarea').map(function() {
        if(($(this).attr('type')=='checkbox'||$(this).attr('type')=='radio')) {
            if($(this).is(':checked')) {
                data[$(this).attr('name')] = $(this).val();
            }
        } else {
            data[$(this).attr('name')] = $(this).val();
        }
    });
    $.post(
        url,
        data,
        function(data){
            loading(false);
            $('#last-check-table').html(data);
            page_move(max_page);
        },
        'html'
    );
}
//開催会場選択
$(document).ready(function(){
    $('#holl_id').change(function(){
        if($(this).val() != 1) {
            return;
        }
        //開催会場=会場
        var url = '{{URL::to('admin/data/holl')}}';
        var data = {'_token':'{{csrf_token()}}'}
        $.post(
            url,
            data,
            function(data){
                if(data.result == 'success') {
                    $.each(data.params , function(key,value){ 
                        $('#'+key).val(value);
                        if(key=='tel1_syubetsu'||key=='tel2_syubetsu') {
                            $('input[name="'+key+'"][value="'+value+'"]').attr('checked',true);
                        }
                    });
                } else {
                    alert(data.message);
                }
            },
            'json'
        );
    });
    $('#gnavi_freeword_get').click(function(){
        if($(this).hasClass('disabled')||!window.confirm('検索キーワードの内容を自動取得します。現在入力している内容は破棄されますがよろしいですか？')){
            return;
        }
        var url = '{{URL::to('fair/page/gnavi/freeword')}}';
        var data = {'_token':'{{csrf_token()}}'};
        $('input,select,textarea').map(function() {
            if(($(this).attr('type')=='checkbox'||$(this).attr('type')=='radio')) {
                if($(this).is(':checked')) {
                    data[$(this).attr('name')] = $(this).val();
                }
            } else {
                data[$(this).attr('name')] = $(this).val();
            }
        });
        $(this).addClass('disabled');
        $.post(
            url,
            data,
            function(data){
                $('#gnavi_freeword_get').removeClass('disabled');
                if(data.result === 'success') {
                    $('#gnavi_freeword_search').val(data.message);
                    alert('検索キーワードを取得しました。');
                } else {
                    alert(data.message);
                }
            },
            'json'
        );
    });
});
</script>
@stop