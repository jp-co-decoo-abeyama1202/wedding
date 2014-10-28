@extends('layout')

{{-- Page content --}}
@section('content')
<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <div class="box-body table-responsive">
                        <table id="login_list" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-right">No</th>
                                    <th>サイト名</th>
                                    <th>ログインID</th>
                                    <th>パスワード</th>
                                    <th>更新用パスワード</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($logins as $login)
                                <tr>
                                    {{Form::open(array('url'=>array('admin/update/login/',$login->id),'role'=>'form'))}}
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
                                    <th>その他</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div><!-- /box-body -->
                </div><!-- /span12 -->
            </div><!-- /row -->
        </div><!-- container -->
    </div><!-- /main-inner -->
</div><!-- /main -->

@stop
