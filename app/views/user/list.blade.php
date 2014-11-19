@extends('layout')
{{-- Page content --}}
@section('style')
<style>
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
                                <h3> ログインユーザ一覧</h3>
                            </div>
                        </div><!-- /widget-header -->
                        <div class="widget-content">
                            <table class='table table-bordered'>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>表示名</th>
                                        <th>メールアドレス</th>
                                        <th>権限</th>
                                        <th>登録日</th>
                                        <th>更新日</th>
                                        <th>削除日</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                @foreach($users as $user)
                                <tbody>
                                    <tr>
                                        <td>#{{$user->id}}</td>
                                        <td>{{{$user->nickname}}}</td>
                                        <td>{{{$user->email}}}</td>
                                        <td>{{Administrator::$roleList[$user->role]}}</td>
                                        <td>{{$user->created_at}}</td>
                                        <td>{{$user->updated_at}}</td>
                                        <td id='deleted_{{$user->id}}'>{{$user->deleted_at}}</td>
                                        <td class='text-center-i'>
                                            {{Form::button('修正',array('class'=>'btn btn-primary btn-edit','user_id'=>$user->id))}}&nbsp;
                                            @if($user->deleted_at)
                                            {{Form::button('削除',array('class'=>'btn disabled'))}}
                                            @else
                                            {{Form::button('削除',array('class'=>'btn btn-danger btn-delete','user_id'=>$user->id,'id'=>'btn-delete-'.$user->id))}}
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
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
$('button.btn-edit').click(function(){
    if($(this).hasClass('disabled')) {
        return;
    }
    var id = $(this).attr('user_id');
    var url = '{{URL::to('user/edit')}}/'+id;
    window.location.href = url;
});
$('button.btn-delete').click(function(){
    if($(this).hasClass('disabled')) {
        return;
    }
    if(!window.confirm('このユーザを削除しても宜しいですか？')) {
        return;
    }
    var url = '{{URL::to('user/delete')}}';
    var id = $(this).attr('user_id');
    var data = {'id':id,'_token':'{{csrf_token()}}'}
    $.post(
        url,
        data,
        function(data){
            if(data.result==='success') {
                $('#btn-delete-'+id).addClass('disabled');
                $('#btn-delete-'+id).removeClass('btn-danger btn-delete');
                $('#deleted_'+id).html(data.deleted_at);
            } else {
                alert(data.message);
            }
        },
        'json'
    );
});
</script>
@stop
