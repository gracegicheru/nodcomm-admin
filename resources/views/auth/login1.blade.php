@extends('layouts.app1')
@section('styles')
	<style type="text/css">
		.inputs {
			text-align: center !important;
			font-size: 16px !important;
			width: 50px !important;
			display: inline-block;
		}

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
@endsection('styles')
@section('content')
<div class="se-pre-con"></div>
					<div class="" id="logindiv">
					<p class="login-box-msg">Sign in to start your session</p>
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('login.custom') }}" id="loginform">
                        {{ csrf_field() }}

						<div class="form-group" id="errors"> </div>
                        <div class="form-group has-feedback">
                            <input id="email" type="email" class="form-control" name="email">
							<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        </div>

                        <div class="form-group has-feedback">
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                <input id="password" type="password" class="form-control" name="password">
                        </div>
						  <div class="row">
							<div class="col-xs-6" style="padding-left: 0px;">
								<a href="{{ url('/forgotpassword') }}" >Forgot your password?</a><br>
								<a href="{{ url('/register') }}" >Register Here</a>
							</div>
							<!-- /.col -->
							<div class="col-xs-6" style="padding-right: 0px;">
							  <button type="submit" id="loginbtn" class="btn btn-primary btn-block btn-flat"><i class="fa fa-sign-in" aria-hidden="true"></i> Sign In</button>
							</div>
							<!-- /.col -->
						  </div>
       
                    </form>
					  </div>
      					<div class="login-wrapper login-success hidden" id="loginsuccessdiv">
						<div class="login-widget animation-delay1">
							<div class="text-center">

								<div class="panel panel-default " style="padding: 35px;padding-bottom:0px;">
									<div class="alert alert-success">Authentication Successful</div>
									<div><span>Redirecting...</span><span style="margin-left: 10px;"><i class="fa fa-spinner fa-spin fa-lg"></i></span></div>
								</div>
							</div>
						</div>
						</div>	        
@endsection
@section('scripts')
	<script>

		// Wait for window load
		$(window).on('load', function(){
			// Animate loader off screen
			$(".se-pre-con").fadeOut("slow");;
			});
	</script>
@endsection				
					
					
					
					