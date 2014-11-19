<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container"> 
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </a>
            <a class="brand" href="{{ URL::to('fair/') }}">Wedding Site Controller</a>
            <div class="nav-collapse">
                <ul class="nav pull-right">
                    <a href="{{URL::to('/logout')}}">{{Form::button('<i class="icon-signout"></i>&nbsp;Logout',array('class'=>'btn btn-danger btn-box'))}}</a>
                </ul>
            </div><!--/.nav-collapse --> 
        </div><!-- /container --> 
    </div><!-- /navbar-inner --> 
</div><!-- /navbar -->
<div class="subnavbar">
    <div class="subnavbar-inner">
        <div class="container">
            <ul class="mainnav">
                <li class="{{URL::current() === Config::get('app.url') ? 'active':''}}">
                    <a href="{{ URL::to('/') }}"><i class="icon-calendar"></i><span>トップページ</span></a>
                </li>
                <li class="dropdown {{preg_match('/fair/',URL::current()) ? 'active':''}}">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-list-alt"></i><span>フェア管理</span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{URL::to('fair/')}}">フェア管理TOP</a></li>
                        <li><a href="{{URL::to('fair/control')}}">稼働中フェア管理</a></li>
                        <li><a href="{{URL::to('fair/new')}}">テンプレート作成</a></li>
                        <li><a href="{{URL::to('fair/list')}}">テンプレート管理</a></li>
                    </ul>
                </li>
                <li class="dropdown {{preg_match('/image/',URL::current()) ? 'active':''}}">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-picture"></i><span>画像管理</span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{URL::to('image/')}}">画像管理TOP</a></li>
                        <li><a href="{{URL::to('image/upload')}}">画像アップロード</a></li>
                        <li><a href="{{URL::to('image/list')}}">SC画像管理</a></li>
                        <li><a href="{{URL::to('image/category')}}">画像カテゴリ管理</a></li>
                        <li><a href="{{URL::to('image/download')}}">画像ダウンロード</a></li>
                        <li><a href="{{URL::to('image/linking')}}">ダウンロード画像紐付</a></li>
                    </ul>
                </li>
                <li class="dropdown {{preg_match('/special/',URL::current()) ? 'active':''}}">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-star-empty"></i><span>特典管理</span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{URL::to('special/')}}">特典管理TOP</a></li>
                        <li><a href="{{URL::to('special/list')}}">SC特典管理</a></li>
                        <li><a href="{{URL::to('special/download')}}">特典ダウンロード</a></li>
                    </ul>
                </li>
                <li class="dropdown {{preg_match('/user/',URL::current()) ? 'active':''}}">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-group"></i><span>ログイン管理</span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{URL::to('user/')}}">ログイン管理TOP</a>
                        <li><a href="{{URL::to('user/password')}}">パスワード変更</a>
                        <li><a href="{{URL::to('user/new')}}">新規登録</a></li>
                        <li><a href="{{URL::to('user/list')}}">一覧</a></li>
                    </ul>
                </li>
                <li class="dropdown {{preg_match('/admin/',URL::current()) ? 'active':''}}">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-briefcase"></i><span>基本情報管理</span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{URL::to('admin/')}}">基本情報管理TOP</a>
                        <li><a href="{{URL::to('admin/company')}}">会社情報管理</a>
                        <li><a href="{{URL::to('admin/holl')}}">会場情報管理</a></li>
                        <li><a href="{{URL::to('admin/infomation')}}">ID・PASSWORD管理</a></li>
                        <li><a href="{{URL::to('admin/infoupdate')}}">情報更新管理</a></li>
                        <li><a href="{{URL::to('admin/format')}}">初期化</a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /container --> 
    </div><!-- /subnavbar-inner --> 
</div><!-- /subnavbar -->