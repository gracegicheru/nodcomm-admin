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
    <link rel="apple-touch-icon-precomposed" href="../../images/favicon/apple-touch-icon-152x152.png">
    <!-- For iPhone -->
    <meta name="msapplication-TileColor" content="#00bcd4">
    <meta name="msapplication-TileImage" content="images/favicon/mstile-144x144.png">
    <!-- For Windows Phone -->
    <!-- CORE CSS-->
    <link href="../../css/themes/horizontal-menu/materials.css" type="text/css" rel="stylesheet">
    <link href="../../css/themes/horizontal-menu/style.css" type="text/css" rel="stylesheet">
    <!-- CSS style Horizontal Nav-->

    <link href="../../css/layouts/style-horizontal.css" type="text/css" rel="stylesheet">
    <!-- Custome CSS-->
    <!-- <link href="../../css/custom/custom.css" type="text/css" rel="stylesheet"> -->
    <link href="../../css/layouts/page-center.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('/assets/css/animation2.css') }}">
    <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
    <link href="../../vendors/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Passion+One' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{ url('/int-tel/css/intlTelInput.css') }}">


   </head>
  <body >
    <!-- Start Page Loading -->

 <div id="particles-js"></div>


    <div class="container">

      <div class="row main" >
      <div class="text-center" >
        <img src="{{ url('/images/Nodcomm.png') }}"  alt="Company Logo" width="35%" style="position:relative;"/>
      </div>

      <div class="main-login main-center " id="step1div" >
        <h3 class="text-center title">Get started </h3>
        <div class="wrapper">
        <div class="divider div-transparent"></div>
        </div>

        <form  role="form" method="POST" action="<?php echo URL::route('step1') ?>" id="step1form">
          {{ csrf_field() }}

          <div class="form-group" id="errors" style="margin-top:10px;"> </div>


        <div class="form-group">

                      <div class="row margin">
                      <div class="col-md-12" style="position:relative; margin-top: 10px;">
                        <input type="tel"  name="telno" id="tel" class="form-control" placeholder="Enter your Mobile Number">
                        <div style="width:10px;position:absolute;right: 30px;bottom: 10px;" >
                        <span id="valid-msg" class="hide"> <i class="text-center fa fa-check" aria-hidden="true"></i> </span>
                        <span id="error-msg" class="hide"><i class="fa fa-times" aria-hidden="true"></i> </span>  
                      </div>
                      </div>

                      </div>
            </div>


  <div class="row">
        <div class="input-field col s12">
          <button class="btn waves-effect waves-light border-round gradient-45deg-purple-deep-orange col s12" type="submit" id="step1btn"
          >proceed</button>
        </div>
      </div>


        </form>

      </div>
{{--          <div class="status" style="display: none;">--}}

{{--          <div id="step1success" class="card green lighten-5 main-login main-center success" style="padding:0px; display: none;" >--}}
{{--              style="display: none;"--}}
{{--              <div class="card-content green-text">--}}
{{--                  <p style="width:100%">Step 1 is complete. Taking you to the next step...</p>--}}
{{--                  <div class="preloader-wrapper small active">--}}
{{--                      <div class="spinner-layer spinner-green-only">--}}
{{--                          <div class="circle-clipper left">--}}
{{--                              <div class="circle"></div>--}}
{{--                          </div><div class="gap-patch">--}}
{{--                              <div class="circle"></div>--}}
{{--                          </div><div class="circle-clipper right">--}}
{{--                              <div class="circle"></div>--}}
{{--                          </div>--}}
{{--                      </div>--}}
{{--                  </div>--}}
{{--              </div>--}}
{{--          </div>--}}


{{--          <div id="account_exists" class="card green lighten-5 main-login main-center exists"style="padding:0px; display: none;"  >--}}
{{--              style="display: none;"--}}
{{--              <div class="card-content green-text">--}}
{{--                  <p style="width:100%">Mobile number exist, <a style="color:red;text-decoration:underline;cursor: pointer;" href="{{ url('/register/step1') }}" >Click Here</a> to login</p>--}}
{{--              </div>--}}

{{--          </div>--}}
{{--          </div>--}}
          
  <!--         <div class="main-login main-center hidden" id="step1success" style="padding:0px; " >
              <div class="alert alert-success" style="width:100%">Mobile number exist, redirecting to login page. Use a different number?<span style="margin-left: 10px;"><i class="fa fa-spinner fa-spin fa-lg"></i></span></div>
          </div>
          <div class="main-login main-center hidden" id="account_exists" style="padding:0px; " >
              <div class="alert alert-success" style="width:100%">Mobile number exist, redirecting to login page. Use a different number? <a style="color:red;text-decoration:underline;cursor: pointer;" href="{{ url('/register/step1') }}" >Click Here</a><span style="margin-left: 10px;"><i class="fa fa-spinner fa-spin fa-lg"></i></span></div>

          </div> -->
        
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
    <script src="https://www.gstatic.com/firebasejs/3.3.0/firebase.js"></script>
    <script src="{{ url('/assets/js/particles.js') }}"></script>
    <script src="{{ url('/assets/js/animation2.js') }}"></script>
    <script src="{{ url('assets/js/userip.js') }}"></script>
    <script src="{{ url('/assets/js/register.js') }}"></script>
    <script src="{{ url('/int-tel/js/intlTelInput.js') }}"></script>
    <script type="application/javascript">
  // Initialize Firebase
  var config = {
    apiKey: "AIzaSyDitTJQdOz2nSprnMPZZA00D3_cxEd467E",
    authDomain: "fir-f4d5c.firebaseapp.com",
    databaseURL: "https://fir-f4d5c.firebaseio.com",
    projectId: "fir-f4d5c",
    storageBucket: "fir-f4d5c.appspot.com",
    messagingSenderId: "662814691860"
  };
  firebase.initializeApp(config);

$("#tel").intlTelInput({
  initialCountry: "auto",
  geoIpLookup: function(callback) {
    $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
      var countryCode = (resp && resp.country) ? resp.country : "";
      callback(countryCode);
    
    });
  },
  utilsScript: "/int-tel/js/utils.js" // just for formatting/placeholders etc
});
</script>

  </body>
</html>