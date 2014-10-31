<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        {{ HTML::style('assets/css/bootstrap.min.css'); }}
        {{ HTML::style('assets/css/bootstrap-responsive.min.css'); }}
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
        {{ HTML::style('assets/css/style.css'); }}
        {{ HTML::style('assets/css/pages/signin.css'); }}
        {{ HTML::style('assets/css/original.css'); }}
    </head>
    <body>
    <div class="account-container">
	<div class="content clearfix">
            {{Form::open()}}
                <h1>Login</h1>		
                <div class="login-fields">
                    <div class="field">
                        <label for="username">Username</label>
                        <input type="text" id="email" name="email" value="" placeholder="メールアドレス" class="login username-field" />
                    </div> <!-- /field -->
                    <div class="field">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" value="" placeholder="パスワード" class="login password-field"/>
                    </div> <!-- /password -->
                </div> <!-- /login-fields -->

                <div class="login-actions">
                    <button class="button btn btn-success btn-large">ログイン</button>
                </div> <!-- /login-actions -->
	    {{Form::close()}}
	</div> <!-- /content -->
    </div> <!-- /account-container -->
        
    {{ HTML::script('assets/js/jquery-1.7.2.min.js')}}
    {{ HTML::script('assets/js/bootstrap.js')}}
    {{ HTML::script('assets/js/signin.js')}}
    </body>
</html>