
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
				<img src="{{ url('/images/Nodcomm.png') }}"  alt="Company Logo" width="40%" style="position:relative;"/>
			</div>
				<div class="main-login main-center " id="step1div" >

				<h5 class="text-center">Sign up once and  use our platform.</h5>
                    <form class="form-horizontal" role="form" method="POST" action="<?php echo URL::route('step1') ?>" id="step1form">
                        {{ csrf_field() }}
						<div class="form-group" id="errors" style="margin-top:10px;"> </div>
					  	<div class="form-group">
							<label>Mobile Number </label>
						
							<input type="tel"  name="telno" id="tel" class="form-control">
							<span id="valid-msg" class="hide"> <i class="fa fa-check" aria-hidden="true"></i> Valid</span>
							<span id="error-msg" class="hide">Invalid number</span>

						</div>
			
						<div class="form-group ">

						 <button type="submit" id="step1btn" class="btn btn-primary btn-lg btn-block login-button"> <i class="fa fa-sign-in" aria-hidden="true"></i> Proceed</button>
						</div>
					</form>

				</div>
				<div class="main-login main-center hidden" id="step2div">
							<form class="form-horizontal" role="form" method="POST" action="<?php echo URL::route('step2') ?>" id="step2form">
							<div class="form-group inputsL">
							<div class="alert alert-info">
								A verification code was sent to your phone number <span id="phn-code-sent"></span>. Enter it below.
							</div>
							<hr style="width:100%">
							<div id="error_display_field"></div>
							<div class="verify-success text-center hide"><span>Redirecting...</span><span style="margin-left: 10px;"><i class="fa fa-spinner fa-spin fa-lg"></i></span></div>
							<label>Code</label><br/>
							<input maxlength="1" type="text" name="code1" id="code1" class="form-control inputs input-sm bounceIn animation-delay2">
							<input style="" maxlength="1" type="text" name="code2" id="code2" class="form-control inputs input-sm bounceIn animation-delay2">
							<input maxlength="1" type="text" name="code3" id="code3" class="form-control inputs input-sm bounceIn animation-delay2">
							<input maxlength="1" type="text" name="code4" id="code4" class="form-control inputs input-sm bounceIn animation-delay2">
							<input maxlength="1" type="text" name="code5" id="code5" class="form-control inputs input-sm bounceIn animation-delay2">
							<input maxlength="1" type="text" name="code6" id="code6" class="form-control inputs input-sm bounceIn animation-delay2">
						</div>
						<div class="clearfix">
							<div class="pull-left" style="padding-top: 8px;">
								<a style="color:#000;text-decoration:underline;cursor: pointer;" id="login-verify-resend-code">Resend Verification Code</a>
								<span id="login-verify-resend-code-dets"></span>
							</div>
							<button type="submit" id="verifylogin" class="btn pull-right btn-success btn-sm">Verify</button>
						</div>
					</form>
				</div>
				<div class="main-login main-center hidden" id="step3div">

				<h5>You are on the last step of registration.</h5>
					<form class="form-horizontal" role="form" method="POST" action="<?php echo URL::route('step1') ?>" id="step3form">
						
						<div class="form-group">
							<label for="name" class="cols-sm-2 control-label">Company Name</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
									<input type="text" class="form-control" name="name" id="name"  placeholder="Enter your Name"/>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="name" class="cols-sm-2 control-label">Your First Name</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
									<input type="text" class="form-control" name="name" id="name"  placeholder="Enter your Name"/>
								</div>
							</div>
						</div>
					<div class="form-group">
							<label for="name" class="cols-sm-2 control-label">Your Last Name</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
									<input type="text" class="form-control" name="name" id="name"  placeholder="Enter your Name"/>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="email" class="cols-sm-2 control-label">Your Email</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
									<input type="text" class="form-control" name="email" id="email"  placeholder="Enter your Email"/>
								</div>
							</div>
						</div>



						<div class="form-group">
							<label for="password" class="cols-sm-2 control-label">Password</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
									<input type="password" class="form-control" name="password" id="password"  placeholder="Enter your Password"/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="confirm" class="cols-sm-2 control-label">Confirm Password</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
									<input type="password" class="form-control" name="confirm" id="confirm"  placeholder="Confirm your Password"/>
								</div>
							</div>
						</div>

						<div class="form-group ">
						 <button type="submit" id="step3btn" class="btn btn-primary btn-lg btn-block login-button"> <i class="fa fa-sign-in" aria-hidden="true"></i> Finish Registration</button>
						</div>
						
					</form>
				</div>
			</div>
		</div>

		 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script src="{{ url('/assets/js/particles.js') }}"></script>
<script src="{{ url('/assets/js/animation2.js') }}"></script>
<script src="{{ url('/assets/js/register.js') }}"></script>
<script src="{{ url('/int-tel/js/intlTelInput.js') }}"></script>
<script type="application/javascript">
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