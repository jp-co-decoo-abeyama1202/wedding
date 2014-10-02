<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        {{ HTML::style('assets/css/bootstrap.min.css'); }}<!-- bootstrap 3.0.2 -->
        {{ HTML::style('assets/css/font-awesome.min.css'); }}<!-- font Awesome -->
        {{ HTML::style('assets/css/ionicons.min.css'); }}<!-- Ionicons -->
        {{ HTML::style('assets/css/AdminLTE.css'); }}<!-- Theme style -->
        {{ HTML::style('assets/css/style.css'); }}<!-- original style -->
        <style>
        .logo{
          width:250px!important;
        }
        body > .header .navbar {
          margin-left:250px!important;
        }
        li.treeview {
          margin: 0;
          padding: 0;
          width:200px;
          border-left: 1px solid #fff;
          /*border-right: 1px solid #dbdbdb;*/
          /*float:right;*/
        }
        li.treeview > a {
          padding: 12px 5px 12px 15px;
          display: block;
        }
        li.treeview > a > .fa,
        li.treeview > a > .glyphicon,
        li.treeview > a > .ion {
          width: 20px;
        }
        .skin-blue .treeview-menu {
          background-color:#6ED25A;
        }
        li.treeview .treeview-menu {
          display: none;
          list-style: none;
          padding: 0;
          margin: 0;
          position:absolute;
          width:100%;
        }
        li.treeview .treeview-menu > li {
          margin: 0!important;
        }
        li.treeview .treeview-menu > li > a {
          padding: 5px 5px 5px 15px;
          margin:0!important;
          display: block;
          font-size: 14px;
          margin: 0px 0px;
        }
        li.treeview .treeview-menu > li > a > .fa,
        li.treeview .treeview-menu > li > a > .glyphicon,
        li.treeview .treeview-menu > li > a > .ion {
          width: 20px;
        }
        </style>
    </head>
    <body class="skin-blue">
        @include('navigator')
        <div class="container">

            <!-- Notifications -->
            @include('notifications')

            <!-- Content -->
            @yield('content')

        </div> <!-- /container -->
        
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script><!-- jQuery 2.0.2 -->
        {{ HTML::script('assets/js/jquery-ui-1.10.3.min.js')}}<!-- jQuery UI 1.10.3 -->
        {{ HTML::script('assets/js/bootstrap.min.js')}}<!-- Bootstrap -->
        {{ HTML::script('assets/js/AdminLTE/app.js')}}<!-- AdminLTE App -->
        <!-- Scripts -->
        @yield('scripts')
    </body>
</html>