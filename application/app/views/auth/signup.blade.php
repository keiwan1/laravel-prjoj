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

    <script type="text/javascript">
     var RecaptchaOptions = {
        theme : 'white'
     };
     </script>
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

    @if (Session::has('notification'))
        <span class="notification">{{ Session::get('notification') }}</span>
    @endif

    <?php $googleService = OAuth::consumer( 'Google' ); ?>

    <form method="post" action="{{ URL::to('signup') }}" class="form-signin">

    <h2 class="form-login-heading">{{ Lang::get('lang.sign_up_with') }}</h2>
    <div class="social-signup">
        <a class="facebook-signup" href="{{ $loginUrl }}"></a>
        <a class="google-signup" href="{{ URL::to('auth/google') }}"></a>
    </div>
        <!-- check for notifications -->

        <div class="line"></div>
            <h2 class="form-login-heading-second">{{ Lang::get('lang.or_signup_with') }}</h2>
        <div class="line"></div>
        
        <input type="text" class="form-control" id="username" name="username" placeholder="{{ Lang::get('lang.username') }}">
        <input type="text" class="form-control" id="email" name="email" style="-webkit-border-top-left-radius: 0px; -webkit-border-top-right-radius: 0px; -moz-border-radius-topleft: 0px; -moz-border-radius-topright: 0px; border-top-left-radius: 0px; border-top-right-radius: 0px;" placeholder="{{ Lang::get('lang.email_address') }}">
        <input type="password" class="form-control" id="password" name="password" style="margin-bottom:0px; -webkit-border-bottom-left-radius: 0px; -webkit-border-bottom-right-radius: 0px; -moz-border-radius-bottomleft: 0px; -moz-border-radius-bottomright: 0px; border-bottom-left-radius: 0px; border-bottom-right-radius: 0px;" placeholder="{{ Lang::get('lang.password') }}">
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="{{ Lang::get('lang.confirm_password') }}">
        <input type="hidden" class="form-control" id="redirect" name="redirect" value="{{ Input::get('redirect') }}" />
        
        @if($settings->captcha)
            {{ Recaptcha::recaptcha_get_html($settings->captcha_public_key) }}
        @endif


        <button class="btn btn-lg btn-block btn-color" type="submit">{{ Lang::get('lang.sign_up') }}</button>
        

    </form>

</div>
<div id="overlay"></div>

<script type="text/javascript" src="/application/assets/js/jquery.backstretch.min.js"></script>
<script type="text/javascript">

    var images = ['01.jpg', '02.jpg', '03.jpg', '04.jpg', '05.jpg', '06.jpg', '07.jpg', '08.jpg', '09.jpg', '10.jpg'];

    $(document).ready(function(){
        $.backstretch('/content/uploads/backgrounds/' + images[Math.floor(Math.random() * images.length)] );
        position_elements();
    });

    $(window).resize(function(){
        position_elements();
    });

    function position_elements(){
        $('#overlay').css('height', $(window).height());
        $('.form-signin').css('top', ( ($(window).height()/2) - ($('.form-signin').height()/2) ) - $('.navbar').height() + 'px' );
        $('.backstretch, #overlay, .form-signin').fadeIn();
    }
</script>

@stop