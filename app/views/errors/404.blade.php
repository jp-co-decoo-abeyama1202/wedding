<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>404 - Page Not Found</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes"> 
    {{ HTML::style('assets/css/bootstrap.min.css'); }}
    {{ HTML::style('assets/css/bootstrap-responsive.min.css'); }}
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    {{ HTML::style('assets/css/font-awesome.css'); }}
    {{ HTML::style('assets/css/style.css'); }}
    {{ HTML::style('assets/css/original.css'); }}
</head>
<body>
    <div class="navbar navbar-fixed-top">	
	<div class="navbar-inner">
		<div class="container">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
			</a>
			<a class="brand" href="{{URL::to('/fair')}}">
                            Wedding Site Controller				
			</a>		
			<div class="nav-collapse">
                            <ul class="nav pull-right">
                                <li class="">						
                                    <a href="index.html" class="">
                                        <i class="icon-chevron-left"></i>
                                            Back to Dashboard
                                    </a>
                                </li>
                            </ul>	
			</div><!--/.nav-collapse -->	
		</div> <!-- /container -->
	</div> <!-- /navbar-inner -->
    </div> <!-- /navbar -->
    <div class="container">	
	<div class="row">
            <div class="span12">
                <div class="error-container">
                    <h1>404</h1>
                        <h2>ページが見つかりませんでした</h2>	
                        <div class="error-actions">
                            <a href="{{URL::to('/fair')}}" class="btn btn-large btn-primary">
                                <i class="icon-chevron-left"></i>
                                &nbsp;トップページへ						
                            </a>
			</div> <!-- /error-actions -->			
                    </div> <!-- /error-container -->			
		</div> <!-- /span12 -->
	</div> <!-- /row -->
    </div> <!-- /container -->
    {{ HTML::script('assets/js/jquery-1.7.2.min.js')}}
    {{ HTML::script('assets/js/bootstrap.js')}}
</body>
</html>
