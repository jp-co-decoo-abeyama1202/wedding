<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container"> 
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </a>
            <a class="brand" href="{{ URL::to('fair/') }}">Wedding Site Controller</a>
            <div class="nav-collapse">
                <ul class="nav pull-right">
                    <a href="{{URL::to('/logout')}}">{{Form::button('Logout',array('class'=>'btn btn-danger'))}}</a>
                </ul>
            </div><!--/.nav-collapse --> 
        </div><!-- /container --> 
    </div><!-- /navbar-inner --> 
</div><!-- /navbar -->
<div class="subnavbar">
    <div class="subnavbar-inner">
        <div class="container">
            <ul class="mainnav">
                <?php
                //ヘッダのどこをアクティブにするか
                $url = URL::current();
                $top = $list = $image = $tokuten = $admin = $info = false;
                if(preg_match('/fair$/',$url)) {
                    $top = true;
                } else if(preg_match('/fair\//',$url)) {
                    $list = true;
                }
                if(preg_match('/image/',$url)) {
                    $image = true;
                }
                if(preg_match('/special/',$url)) {
                    $image = true;
                }
                if(preg_match('/admin\/infomation/',$url)) {
                    $info = true;
                } else if(preg_match('/admin/',$url)) {
                    $admin = true;
                }
                ?>
                <li class="{{$top ? 'active':''}}">
                    <a href="{{ URL::to('fair/') }}"><i class="icon-calendar"></i><span>トップページ</span></a>
                </li>
                <li class="dropdown {{$list ? 'active':''}}">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-list-alt"></i><span>フェア管理</span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{URL::to('fair/new')}}">新規登録</a></li>
                        <li><a href="{{URL::to('fair/list')}}">一覧</a></li>
                    </ul>
                </li>
                <li class="dropdown {{$image ? 'active':''}}">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-picture"></i><span>画像管理</span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{URL::to('image/upload')}}">アップロード</a></li>
                        <li><a href="{{URL::to('image/list')}}">一覧</a></li>
                        <li><a href="{{URL::to('image/get')}}">各サイトから取得</a></li>
                    </ul>
                </li>
                <li class="dropdown {{$tokuten ? 'active':''}}">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-star-empty"></i><span>特典管理</span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{URL::to('special/list')}}">一覧</a></li>
                        <li><a href="{{URL::to('special/get')}}">楽天から取得</a></li>
                    </ul>
                </li>
                <li class="dropdown {{$admin ? 'active':''}}">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-group"></i><span>ユーザ管理</span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{URL::to('admin/password')}}">パスワード変更</a>
                        <li><a href="{{URL::to('admin/new')}}">新規登録</a></li>
                        <li><a href="{{URL::to('admin/list')}}">一覧</a></li>
                    </ul>
                </li>
                <li class="{{$info ? 'active':''}}">
                    <a href="{{ URL::to('admin/infomation') }}"><i class="icon-briefcase"></i><span>基本情報</span></a>
                </li>
            </ul>
        </div><!-- /container --> 
    </div><!-- /subnavbar-inner --> 
</div><!-- /subnavbar -->