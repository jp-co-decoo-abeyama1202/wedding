@extends('layout')
@section('style')
<style>
.text-center
{
    text-align:center!important;
}
</style>
@stop
{{-- Page content --}}
@section('content')
<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <div class="widget widget-table action-table">
                        <div class="widget-header tabs">
                            <div class="header_title">
                                <i class="icon-signin"></i>
                                <h3 id="page-title"> ID・PASSWORD管理</h3>
                            </div>
                            <div class="header-buttons">
                                <a href='{{URL::to('admin/')}}'>
                                    {{Form::button('戻る',array('class'=>'btn btn-primary'))}}
                                </a>
                            </div>
                        </div><!-- /widget-header -->
                        <div class="widget-content">
                            <table id="login_list" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-right">No</th>
                                        <th>サイト名</th>
                                        <th>ログインID</th>
                                        <th>パスワード</th>
                                        <th>更新用パスワード</th>
                                        <th>修正</th>
                                        <th>ログイン可否</th>
                                        <th>最終ログイン日時</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($logins as $login)
                                    <tr>
                                        {{Form::open(array('url'=>array('admin/update/login',$login->id),'role'=>'form'))}}
                                        <td class="text-right">{{ $login->id }}</td>
                                        <td class="text-right">{{ Site::$_site_names[$login->id] }}</td>
                                        <td>{{Form::text('login_id',$login->login_id,array('class'=>'form-control','placeholder'=>'ログインID'))}}</td>
                                        <td>{{Form::password('password','',array('class'=>'form-control','placeholder'=>'新しいパスワードを入力'))}}</td>
                                        <td>
                                            @if($login->id == SiteRakuten::SITE_LOGIN_ID)
                                            {{Form::password('double_password','',array('class'=>'form-control','placeholder'=>'更新用パスワード'))}}
                                            @else
                                            {{Form::hidden('double_password','')}}
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            {{Form::submit('修正',array('class'=>'btn btn-primary'))}}
                                        </td>
                                        <td class="text-center">
                                            {{Form::button('チェック',array('class'=>'btn btn-primary btn-logincheck','site_id'=>$login->id,'id'=>'btn-logincheck-'.$login->id,'style'=>'width:90px;'))}}
                                        </td>
                                        <td id="last-login-at-{{$login->id}}">{{date('Y-m-d H:i:s',$login->last_login_at)}}
                                        </form>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-right">No</th>
                                        <th>サイト名</th>
                                        <th>ログインID</th>
                                        <th>パスワード</th>
                                        <th>更新用パスワード</th>
                                        <th>修正</th>
                                        <th>ログイン可否</th>
                                        <th>最終ログイン日時</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div><!-- /widget-content -->
                    </div><!-- /widget -->
                </div><!-- /span10 -->
            </div><!-- /row -->
        </div><!-- container -->
    </div><!-- /main-inner -->
</div><!-- /main -->
@stop
@section('scripts')
<script>
$('.btn-logincheck').click(function(){
    if($(this).hasClass('disabled')) {
        return;
    }
    if(!window.confirm('ログイン可能か確認します。\nログインは登録された情報で行われます。\n入力途中のデータでは行われませんので、一度修正を確定してから行ってください。\nログイン可能かチェックしますか？')) {
        return;
    }
    var id = $(this).attr('site_id');
    var url = '{{URL::to('admin/check/login')}}/'+id;
    var data = {'_token':'{{csrf_token()}}'}
    $(this).addClass('disabled');
    $(this).removeClass('btn-primary');
    $(this).html('チェック中');
    $.post(
        url,
        data,
        function(data){
            if(data.result == 'success') {
                alert(data.message);
                $('#btn-logincheck-'+id).addClass('btn-success');
                $('#btn-logincheck-'+id).html('OK');
                $('#last-login-at-'+id).html(data.last_login_at);
            } else {
                alert(data.message);
                $('#btn-logincheck-'+id).addClass('btn-danger');
                $('#btn-logincheck-'+id).html('NG');
            }
        },
        'json'
    );
});
</script>
@stop
