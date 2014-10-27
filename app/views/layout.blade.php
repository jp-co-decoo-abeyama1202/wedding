<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Wedding Site Controller</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        {{ HTML::style('assets/css/bootstrap.min.css'); }}
        {{ HTML::style('assets/css/bootstrap-responsive.min.css'); }}
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
        {{ HTML::style('assets/css/font-awesome.css'); }}
        {{ HTML::style('assets/css/style.css'); }}
        {{ HTML::style('assets/css/original.css'); }}
        @yield('style')
    </head>
    <body>
        @include('navigator')
        <div class="container">

            <!-- Notifications -->
            @include('notifications')

            <!-- Content -->
            @yield('content')

        </div> <!-- /container -->
        
        {{ HTML::script('assets/js/jquery-1.7.2.min.js')}}
        {{ HTML::script('assets/js/bootstrap.js')}}
        <!-- Scripts -->
        @yield('scripts')
    </body>
</html>