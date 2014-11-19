@extends('layout')
@section('style')
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
                                <i class="icon-tags"></i>
                                <h3 id="page-title"> 画像カテゴリ管理</h3>
                            </div>
                            <div class="header-buttons">
                                <a href='{{URL::to('image/')}}'>
                                    {{Form::button('戻る',array('class'=>'btn btn-primary'))}}
                                </a>
                            </div>
                        </div><!-- /widget-header -->
                        <div class="widget-content">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-right">No</th>
                                        <th>カテゴリ名</th>
                                        <th>登録枚数</th>
                                        <th>編集</th>
                                        <th>削除</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categorys as $category)
                                    <tr>
                                        {{Form::open(array('url'=>array('image/category'),'method'=>'post'))}}
                                        {{Form::hidden('id',$category->id)}}
                                        <td class="text-right">{{ $category->id }}</td>
                                        <td class="text-right">{{Form::text('name',$category->name,array('class'=>'w450','maxlength'=>'100'))}}</td>
                                        <td class="text-right-i">{{$category->images()->count()}}</td>
                                        <td class="text-center-i">{{Form::submit('修正',array('class'=>'btn btn-primary','style'=>'width:90px;'))}}</td>
                                        <td class="text-center-i">{{Form::button('削除',array('class'=>'btn btn-danger btn-delete','category_id'=>$category->id,'style'=>'width:90px;'))}}</td>
                                        {{Form::close()}}
                                    </tr>
                                    @endforeach
                                    <tr>
                                        {{Form::open(array('url'=>array('image/category'),'method'=>'post'))}}
                                        <td class="text-right">新規追加</td>
                                        <td class="text-right">{{Form::text('name','',array('class'=>'w450','maxlength'=>'100','placeholder'=>'追加するカテゴリ名'))}}</td>
                                        <td class="text-right-i">-</td>
                                        <td class="text-center-i">{{Form::submit('登録',array('class'=>'btn btn-primary','style'=>'width:90px;'))}}</td>
                                        <td class="text-center-i"></td>
                                        {{Form::close()}}
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-right">No</th>
                                        <th>カテゴリ名</th>
                                        <th>登録枚数</th>
                                        <th>編集</th>
                                        <th>削除</th>
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
$('.btn-delete').click(function(){
    if($(this).hasClass('disabled')) {
        return;
    }
    if(!window.confirm('この画像カテゴリを削除します。よろしいですか？')) {
        return;
    }
    var id = $(this).attr('category_id');
    var url = '{{URL::to('image/category/delete')}}/'+id;
    var data = {'_token':'{{csrf_token()}}'}
    $(this).addClass('disabled');
    $(this).removeClass('btn-primary');
    $(this).html('削除中');
    $.post(
        url,
        data,
        function(data){
            alert(data.message);
            location.reload();
        },
        'json'
    );
});
</script>
@stop
