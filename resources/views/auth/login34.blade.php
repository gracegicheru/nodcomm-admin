
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


		.no-js #loader { display: none;  }
		.js #loader { display: block; position: absolute; left: 100px; top: 0; }
		.se-pre-con {
			position: fixed;
			left: 0px;
			top: 0px;
			width: 100%;
			height: 100%;
			z-index: 9999;
			background:  url('/images/preloader.gif') center no-repeat #fff;
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
			<div class="se-pre-con"></div>
				<div class="main-login main-center " id="logindiv" >
				<h3 class="text-center title">Sign in</h3>
				<div class="wrapper">
				<div class="divider div-transparent"></div>
				</div>

                   <form class="form-horizontal" role="form" method="POST" action="{{ route('login.custom') }}" id="loginform">
                        {{ csrf_field() }}
					<!--<div>-->
					<div class="form-group" id="errors" style="margin-top:10px;"> </div>
						<div class="form-group">
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
									<input type="email" id="email" class="form-control" name="email" placeholder="Enter your Email"/>
								</div>
							</div>
						</div>



						<div class="form-group">
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
									<input type="password" id="password" class="form-control" name="password"  placeholder="Enter your Password"/>
								</div>
							</div>
						</div>
						<div class="form-group ">
						 <button type="submit" id="loginbtn" class="btn btn-primary btn-md btn-block login-button"> <i class="fa fa-sign-in" aria-hidden="true"></i> Sign In</button>
						<!--<button type="submit" id="registerbtn" class="btn btn-primary btn-md btn-block login-button"> <i class="fa fa-sign-in" aria-hidden="true"></i> Register</button>
						<button type="submit" id="logoutbtn" class="hide btn btn-primary btn-md btn-block login-button"> <i class="fa fa-sign-in" aria-hidden="true"></i> Logout</button>-->
						</div>

						<div class="clearfix">
							<div class="pull-left" style="padding-top: 8px;">
								<a style="color:#fff;text-decoration:underline;cursor: pointer;" href="{{ url('/forgotpassword') }}" >Forgot your password?</a>
							</div>
							<div class="pull-right" style="padding-top: 8px;">
								<a style="color:#fff;text-decoration:underline;cursor: pointer;" href="{{ url('/register/step1') }}" >Register Here</a>
							</div>
						</div>
						<!--<div>-->
					</form>
				</div>
				<div class="main-login main-center hidden" id="loginsuccessdiv" style="padding:0px; " >
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
<script src="{{ url('/assets/js/login.js') }}"></script>
<script src="https://www.gstatic.com/firebasejs/3.3.0/firebase.js"></script>
<!--<script src="{{ url('/assets/js/firebase_login.js') }}"></script>-->
<script>

		// Wait for window load
		$(window).on('load', function(){
			// Animate loader off screen
			$(".se-pre-con").fadeOut("slow");;
			});
</script>
</body>
</html>