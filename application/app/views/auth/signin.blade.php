@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="/application/assets/css/login_signup.css" />
    <style type="text/css">
        html, body, #main_container{
            background:none;
        }
        .navbar.gallery-sub-header{
            display:none;
        }
        #footer, .backstretch, #overlay, .form-signin{
            display:none;
        }
    </style>
@stop

<?php

$settings = Setting::first();

$facebook = new Facebook(array(
  'appId'  => $settings->fb_key,
  'secret' => $settings->fb_secret_key,
  'cookie' => true,
  'oauth' => true,
));

$params = array(
  'scope' => 'email',
  'redirect_uri' => URL::to("auth/facebook"),
);

$loginUrl = $facebook->getLoginUrl($params);

?>

@section('content')

<div class="container">

    <form method="post" action="{{ URL::to('signin') }}" class="form-signin">

	<h2 class="form-login-heading">{{ Lang::get('lang.sign_in_with') }}</h2>
    <div class="social-signup">
        <a class="facebook-signup" href="{{ $loginUrl }}"></a>
        <a class="google-signup" href="{{ URL::to('auth/google') }}"></a>
    </div>

    
       
        <div class="line"></div>
            <h2 class="form-login-heading-second">{{ Lang::get('lang.or_sign_in_with') }}</h2>
        <div class="line"></div>

        <input type="text" class="form-control" placeholder="{{ Lang::get('lang.username_or_email') }}" id="email" name="email" autofocus>
        <input type="password" class="form-control" placeholder="{{ Lang::get('lang.password') }}" id="password" name="password">
        <input type="hidden" class="form-control" id="redirect" name="redirect" value="{{ Input::get('redirect') }}" />
        <button class="btn btn-lg btn-block btn-color btn-signin" type="submit">{{ Lang::get('lang.sign_in') }}</button>
        <a href="{{ URL::to('password_reset') }}" style="width:100%; text-align:center; color:#fff; display:block;">{{ Lang::get('lang.forgot_password') }}</a>
    </form>

</div>

<div id="overlay"></div>

<script type="text/javascript" src="/application/assets/js/jquery.backstretch.min.js"></script>
<script type="text/javascript">

    var images = ['01.jpg', '02.jpg', '03.jpg', '04.jpg', '05.jpg', '06.jpg', '07.jpg', '08.jpg', '09.jpg', '10.jpg'];

    $(document).ready(function(){
        //images[Math.floor(Math.random() * images.length)]
        $.backstretch('/content/uploads/backgrounds/' + images[Math.floor(Math.random() * images.length)] );
        position_elements();
    });

    $(window).resize(function(){
        position_elements();
    });

    function position_elements(){
        $('#overlay').css('height', $(window).height());
        if($(window).height() > $('.form-signin').height() + 100){
            $('.form-signin').css('top', ( ($(window).height()/2) - ($('.form-signin').height()/2) ) - $('.navbar').height() + 'px' );
        } else {
            $('.form-signin').css('top', '0px');
        }
        $('.backstretch, #overlay, .form-signin').fadeIn();
    }
</script>

@stop