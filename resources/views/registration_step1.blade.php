
<html lang="en">
    <head> 
		<meta name="viewport" content="width=device-width, initial-scale=1">


		<!-- Website CSS style -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!-- Website Font style -->
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
		<link rel="stylesheet" href="{{ url('/assets/css/style.css') }}">
		<!-- Google Fonts -->
		<link href='https://fonts.googleapis.com/css?family=Passion+One' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="{{ url('/assets/css/animation2.css') }}">
		<link rel="stylesheet" href="{{ url('/int-tel/css/intlTelInput.css') }}">
		<link rel="stylesheet" href="{{ url('/assets/css/custom.css') }}">
		<style type="text/css">
		.inputs {
			text-align: center !important;
			font-size: 16px !important;
			width: 50px !important;
			display: inline-block;
		}


	</style>
		<title>Nodcomm</title>
	</head>
	<body>
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

											<div class="row">
											<div class="col-md-12" style="position:relative;">
												<input type="tel"  name="telno" id="tel" class="form-control" placeholder="Enter your Mobile Number">
												<div style="width:10px;position:absolute;right: 30px;bottom: 10px;" >
												<span id="valid-msg" class="hide"> <i class="text-center fa fa-check" aria-hidden="true"></i> </span>
												<span id="error-msg" class="hide"><i class="fa fa-times" aria-hidden="true"></i> </span>	
											</div>
											</div>

											</div>
						</div>
			
						<div class="form-group ">
						 <button type="submit" id="step1btn" class="btn btn-primary btn-md btn-block login-button"> <i class="fa fa-sign-in" aria-hidden="true"></i> Proceed</button>
						</div>
					</form>
				</div>
				<div class="main-login main-center hidden" id="step1success" style="padding:0px; " >
					<div class="alert alert-success" style="width:100%">Step 1 is complete. Taking you to the next step...<span style="margin-left: 10px;"><i class="fa fa-spinner fa-spin fa-lg"></i></span></div>
				</div>
				<div class="main-login main-center hidden" id="account_exists" style="padding:0px; " >
					<div class="alert alert-success" style="width:100%">Mobile number exist, redirecting to login page. Use a different number? <a style="color:red;text-decoration:underline;cursor: pointer;" href="{{ url('/register/step1') }}" >Click Here</a><span style="margin-left: 10px;"><i class="fa fa-spinner fa-spin fa-lg"></i></span></div>
				</div>
			</div>
		</div>

		 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
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