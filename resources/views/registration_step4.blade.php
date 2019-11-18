
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

				<div class="main-login main-center" id="step4div" style="padding:10px;">
							<form class="" role="form" method="POST" action="<?php echo URL::route('step4') ?>" id="step4form">
							 {{ csrf_field() }}
							<div class="form-group inputsL">
							<div class="alert alert-info">
								A verification code was sent to your email (<span id="emailspan">{{$email}}</span>). Enter it below.<br>
								<a class="btn btn-sm " style="color:#3ec291;"  data-toggle="modal" data-target="#myModal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Change Email</a>
							</div>
							<div class="wrapper">
							<div class="divider div-transparent"></div>
							</div>
							<div class="form-group">
							<input type="hidden" name="email" id="email" class="" value="{{$email}}">
							</div>
							<div class="form-group" id="errors"> </div>
							<div class="verify-success text-center hide"><span>Redirecting...</span><span style="margin-left: 10px;"><i class="fa fa-spinner fa-spin fa-lg"></i></span></div>
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
							<button type="submit" id="step4btn" class="btn pull-right btn-success btn-md verify">Verify</button>
						</div>
					</form>
				</div>
				<div class="main-login main-center hidden" id="step4success" style="padding:0px; " >
					<div class="alert alert-success" style="width:100%">Redirecting...<span style="margin-left: 10px;"><i class="fa fa-spinner fa-spin fa-lg"></i></span></div>
				</div>
			</div>
		</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Change Email Address</h4>
      </div>
      <div class="modal-body">
       				<div class="main-login main-center " id="mobilenodiv" style="max-width:100%" >
                    <form  role="form" method="POST" action="<?php echo URL::route('edit-email') ?>" id="emailform">
                        {{ csrf_field() }}
						<div class="form-group" id="errors1" style="margin-top:10px;"> </div>
						<div class="form-group">
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
									<input type="email" class="form-control" name="email" placeholder="Enter your Email"/>
								</div>
							</div>
						</div>
			
						<div class="form-group ">
						 <button type="submit" id="emailbtn" class="btn btn-primary btn-md btn-block login-button"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update</button>
						</div>
					</form>
				</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
		 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script src="{{ url('/assets/js/particles.js') }}"></script>
<script src="{{ url('/assets/js/animation2.js') }}"></script>
<script src="https://www.gstatic.com/firebasejs/3.3.0/firebase.js"></script>
<script type="text/javascript">
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
  var server = '{{ url('/') }}';

</script>
<script src="{{ url('/assets/js/register.js') }}"></script>

</body>
</html>