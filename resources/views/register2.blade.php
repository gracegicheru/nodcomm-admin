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
{{--    <link rel="icon" href="../../images/favicon/favicon-32x32.png" sizes="32x32">--}}
    <!-- Favicons-->
{{--    <link rel="apple-touch-icon-precomposed" href="../../images/favicon/apple-touch-icon-152x152.png">--}}
    <!-- For iPhone -->
    <meta name="msapplication-TileColor" content="#00bcd4">
    <meta name="msapplication-TileImage" content="images/favicon/mstile-144x144.png">
    <!-- For Windows Phone -->
    <!-- CORE CSS-->
    <link href="../../css/themes/horizontal-menu/materialize.css" type="text/css" rel="stylesheet">
    <link href="../../css/themes/horizontal-menu/style.css" type="text/css" rel="stylesheet">
    <!-- CSS style Horizontal Nav-->

    <link href="../../css/layouts/style-horizontal.css" type="text/css" rel="stylesheet">
    <!-- Custome CSS-->
    <!-- <link href="../../css/custom/custom.css" type="text/css" rel="stylesheet"> -->
    <link href="../../css/layouts/page-center.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('/assets/css/animation2.css') }}">
    <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
    <link href="../../vendors/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet">
<!--    <script src="{{ url('/assets/js/particles.js') }}"></script>
    <script src="{{ url('/assets/js/animation2.js') }}"></script>
 -->  </head>
<body >
<!-- Start Page Loading -->

<div id="particles-js"></div>

<div class="col s6">
    <div class="row">
        <div class="col s12">
            <ul class="tabs tab-demo z-depth-1">
                <li class="tab col s3" id="company" style="color: white;" ><a class="active" >Company</a>
                </li>
                <li class="tab col s3" id="people" style="color: white;">Individual
                </li>
            </ul>
        </div>

    </div>
</div>


<div class="container">
    <div class="row main" >
        <div class="text-center" >

        </div>
        <div class="se-pre-con"></div>
        <div class="main-login main-center " id="logindiv"  style="margin-top: 50px;">
            <h3 class="text-center title">Enter Your Details</h3>
            <div class="wrapper">
                <div class="divider div-transparent"></div>
            </div>

            <form class="form-horizontal" role="form" method="POST" action="<?php echo URL::route('step3') ?>" id="step3form">
                {{ csrf_field() }}
                <div class="form-group" id="errors" style="margin-top:20px; margin-bottom: 10px; margin-left: 50px; color: red;"> </div>

                <div class="row margin">
                    <div class="input-field col s12">
                        <i class="material-icons prefix pt-2">person_outline</i>
                        <input type="text" name="name" id="name">
                        <label for="username" class="center-align" style="color: white;">Enter The Company's Name</label>
                    </div>
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                        <i class="material-icons prefix pt-2">person_outline</i>
                        <input type="text" name="fname" id="fname">
                        <label for="username" class="center-align" style="color: white;">Enter Your First Name</label>
                    </div>
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                        <i class="material-icons prefix pt-2">person_outline</i>
                        <input type="text" id="lname" name="lname" >
                        <label for="username" class="center-align" style="color: white;">Enter Your Last Name</label>
                    </div>
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                        <i class="material-icons prefix pt-2">mail_outline</i>
                        <input type="email" id="email" name="email">
                        <label for="username" class="center-align" style="color: white;">Enter Your Email</label>
                    </div>
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                        <i class="material-icons prefix pt-2">mail_outline</i>
                        <input type="text" id="address" name="address">
                        <label for="username" class="center-align" style="color: white;">Enter Your Address</label>
                    </div>
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                        <i class="material-icons prefix pt-2">lock_outline</i>
                        <input name="password" type="password">
                        <label for="username" class="center-align" style="color: white;">Enter Your Password</label>
                    </div>
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                        <i class="material-icons prefix pt-2">lock_outline</i>
                        <input name="password1" type="password">
                        <label for="password" style="color: white;" >Confirm Your Password</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <button class="btn waves-effect waves-light border-round gradient-45deg-purple-deep-orange col s12" type="submit" id="registercompanybtn"
                        >Sign in</button>
                    </div>
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
<script src="{{ url('/assets/js/register.js') }}"></script>

</body>
</html>