
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
		<style type="text/css">
		.inputs {
			text-align: center !important;
			font-size: 16px !important;
			width: 15% !important;
			display: inline-block;
		}

		.separatoricon{
		text-align: center !important;
		font-size: 16px !important;
		width: 4% !important;
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

				<div class="main-login main-center" id="step2div" style="padding:10px;">
							<form class="" role="form" method="POST" action="<?php echo URL::route('verification-code') ?>" id="verifyform">
							 {{ csrf_field() }}
							<div class="form-group inputsL">
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
						<div class="clearfix">
							<div class="pull-left" style="padding-top: 8px;">
								<a style="color:#fff;text-decoration:underline;cursor: pointer;" id="login-verify-resend-code">Resend Verification Code</a>
								<span id="login-verify-resend-code-dets"></span>
							</div>
							<button type="submit" id="verifybtn" class="btn pull-right btn-success btn-md verify">Verify</button>
						</div>
					</form>
				</div>
				<div class="main-login main-center hidden" id="step2success" style="padding:0px; " >
					<div class="alert alert-success" style="width:100%">Redirecting...<span style="margin-left: 10px;"><i class="fa fa-spinner fa-spin fa-lg"></i></span></div>
				</div>
			</div>
		</div>

		 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script src="{{ url('/assets/js/particles.js') }}"></script>
<script src="{{ url('/assets/js/animation2.js') }}"></script>
<script type="text/javascript">
  var server = '{{ url('/') }}';

</script>
<script src="{{ url('/assets/js/login.js') }}"></script>

</body>
</html>