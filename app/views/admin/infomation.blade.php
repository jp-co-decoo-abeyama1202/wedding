@extends('layout')

{{-- Page content --}}
@section('content')
<aside class="right-side">
<!-- Main content -->
    <section class="content-header">
        <h1>基本情報管理</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title"><i class="ion ion-ios7-people"> ログイン情報一覧</i></h3>
                    </div><!-- /.box-header -->
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
                                    <form method="post" role="form" action="{{ URL::to('admin/update/login', $login->id) }}">
                                    <td class="text-right">{{ $login->id }}</td>
                                    <td class="text-right">{{ Site::$_site_names[$login->id] }}</td>
                                    <td><input type="text" name="login_id" class="form-control" value="{{ $login->login_id }}" /></td>
                                    <td><input type="password" name="password" class="form-control" placeholder="新しいパスワードを入力" /></td>
                                    <td>
                                        @if($login->id == SiteRakuten::SITE_LOGIN_ID)
                                        <input type="password" name="double_password" class="form-control" placeholder="更新用パスワード" />
                                        @else
                                        <input type="hidden" name="double_password" value="" />
                                        @endif
                                    </td>
                                    <td class="text-center"><input type="submit" class="btn btn-primary" value="修正" /></td>
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
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>

@stop
