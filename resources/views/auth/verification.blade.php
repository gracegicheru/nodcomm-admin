<!DOCTYPE html>
<html lang="en">
 
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="description" content="Materialize is a Material Design Admin Template,It's modern, responsive and based on Material Design by Google. ">
    <meta name="keywords" content="materialize, admin template, dashboard template, flat admin template, responsive admin template,">
    <title>Nodcomm</title>
    <!-- Favicons-->
    <link rel="icon" href="../../images/favicon/favicon-32x32.png" sizes="32x32">
    <!-- Favicons-->
    <link rel="apple-touch-icon-precomposed" href="../../images/favicon/apple-touch-icon-152x152.png">
    <!-- For iPhone -->
    <meta name="msapplication-TileColor" content="#00bcd4">
    <meta name="msapplication-TileImage" content="images/favicon/mstile-144x144.png">
    <!-- For Windows Phone -->
    <!-- CORE CSS-->
    
    <!-- <link href="../../css/themes/horizontal-menu/materialize.css" type="text/css" rel="stylesheet"> -->

    <link href="../../css/themes/horizontal-menu/style.css" type="text/css" rel="stylesheet">
    <!-- CSS style Horizontal Nav-->

    <link href="../../css/layouts/style-horizontal.css" type="text/css" rel="stylesheet">
    <!-- Custome CSS-->
    <!-- <link href="../../css/custom/custom.css" type="text/css" rel="stylesheet"> -->
    <link href="../../css/layouts/page-center.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('/assets/css/animation2.css') }}">
    <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
    <link href="../../vendors/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet">
    <link href="../../css/themes/horizontal-menu/material.css" type="text/css" rel="stylesheet">
   </head>
  <body >
    <!-- Start Page Loading -->

 <div id="particles-js"></div>


    <div class="container">

      <div class="row main" >
      <div class="text-center" >
        <img src="{{ url('/images/Nodcomm.png') }}"  alt="Company Logo" width="35%" style="position:relative;"/>
      </div>
   <div class="main-login main-center" id="step2div" style="padding:10px; ">
              <form class="" role="form" method="POST" action="<?php echo URL::route('verification-code') ?>" id="verifyform">
               {{ csrf_field() }}
              <div class="form-group inputsL" >
              <div class="alert alert-info">
                A verification code was sent to your mobile number (<span >{{Session::get('obscured_login_phone')}}</span>). Enter it below.
              </div>
              <div class="wrapper">
              <div class="divider div-transparent"></div>
              </div>
              <div class="form-group" id="errors"> </div>

              <input maxlength="1" type="text" name="code1" id="code1" class="form-control inputs input-sm bounceIn animation-delay2">
              <input style="" maxlength="1" type="text" name="code2" id="code2" class="form-control inputs input-sm bounceIn animation-delay2">
              <input maxlength="1" type="text" name="code3" id="code3" class="form-control inputs input-sm bounceIn animation-delay2">
              <div class="separatoricon">-</div>
              <input maxlength="1" type="text" name="code4" id="code4" class="form-control inputs input-sm bounceIn animation-delay2">
              <input maxlength="1" type="text" name="code5" id="code5" class="form-control inputs input-sm bounceIn animation-delay2">
              <input maxlength="1" type="text" name="code6" id="code6" class="form-control inputs input-sm bounceIn animation-delay2">
              
            </div>

         <div class="row" style="padding-top: 10px;">
        <div class="input-field col s6 m6 l6 " style="text-align: left; position: absolute;">
          <a class="margin medium-small" style="text-decoration: underline; color: white;cursor: pointer;" id="login-verify-resend-code" >Resend Verification Code</a>
        </div>
        <div class="input-field col s6 m6 l0 " style="text-align: right;">
          <button style=" color: white;" type="submit" id="verifybtn" class="btn">Verify</button></div>
      </div>



     
</form>
      </div>


      </div>
    </div>


    <!-- ================================================
    Scripts
    ================================================ -->
    <!-- jQuery Library -->
    <script type="text/javascript" src="../../vendors/jquery-3.2.1.min.js"></script>
    <!--materialize js-->
    <script type="text/javascript" src="../../js/materialize.min.js"></script>
    <!--scrollbar-->
    <script type="text/javascript" src="../../vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <!--plugins.js - Some Specific JS codes for Plugin Settings-->
    <script type="text/javascript" src="../../js/plugins.js"></script>
    <!--custom-script.js - Add your own theme custom JS-->
    <script type="text/javascript" src="../../js/custom-script.js"></script>

    <script src="{{ url('/assets/js/particles.js') }}"></script>
    <script src="{{ url('/assets/js/animation2.js') }}"></script>
    <script src="{{ url('/assets/js/login.js') }}"></script>

  </body>
</html>