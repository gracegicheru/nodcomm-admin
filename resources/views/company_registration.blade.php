@extends('layouts.app1')
@section('styles')
<link rel="stylesheet" href="/int-tel/css/intlTelInput.css">
<link rel="stylesheet" href="/assets/css/custom.css">
@endsection('styles')
@section('content')
					<div id="companydiv" >
					<p class="login-box-msg">Register</p>
                    <form class="form-horizontal" role="form" method="POST" action="<?php echo URL::route('addcompany') ?>" id="companyregisterform">
                        {{ csrf_field() }}

						
					   <div class="form-group">
					   <label>Company Name <span style="color:red;">*</span></label>
						<input name="name" type="text" class="form-control" placeholder="Company Name">
					  </div>
					  <div class="form-group">
					   <label>Company Website <span style="color:red;">*</span></label>
						<input name="website" type="text" class="form-control" placeholder="Company Website">
					  </div>

					  <div class="form-group">
						<label>Company Size <span style="color:red;">*</span></label>
						<select class="form-control" name="company_size" style="width: 100%;">
						<option value="">Number of Employees</option>
						<option value="1">1-5</option>
						<option value="2">5-10</option>
					    <option value="3">11-20</option>
						<option value="4">21-30</option>
						<option value="5">31-40</option>
					    <option value="6">41-50</option>
						<option value="7">50-100</option>
						<option value="8">100+</option>
						</select>
					 </div>
					  <div class="form-group">
					   <label>First Name <span style="color:red;">*</span></label>
						<input name="fname" type="text" class="form-control" placeholder="First Name">
					  </div>
					  <div class="form-group">
					   <label>Last Name <span style="color:red;">*</span></label>
						<input name="lname" type="text" class="form-control" placeholder="Last Name">
					  </div>
					  <div class="form-group">
					    <label>Email <span style="color:red;">*</span></label>
						<input name="email" type="email" class="form-control" placeholder="Email">
					  </div>

					  	<div class="form-group" >
							<label>Phone <span style="color:red;">*</span></label>
							<br/>
							<input type="tel"  name="telno" id="tel" class="form-control">
							<span id="valid-msg" class="hide"> <i class="fa fa-check" aria-hidden="true"></i> Valid</span>
							<span id="error-msg" class="hide">Invalid number</span>

						</div>
					  <div class="form-group">
					   <label>Address</label>
						<textarea class="form-control" name="address"  placeholder="Address"></textarea>
					  </div>
					  <div class="form-group">
					    <label>Password <span style="color:red;">*</span></label>
						<input name="password" type="password" class="form-control" placeholder="Password">
					  </div>
					  <div class="form-group">
					    <label>Confirm Password <span style="color:red;">*</span></label>
						<input name="password1" type="password" class="form-control" placeholder="Confirm Password">
					  </div>
				    <div class="row">
					<div class="col-xs-7" style="padding-left:0px;">
					  <div class="checkbox icheck">
						<label>
						  <input name="agree" type="checkbox"> I agree to the <a href="#">terms</a>
						</label>
					  </div>
					</div>
					<!-- /.col -->
					<div class="col-xs-5" style="padding-right:0px;">
					  <button type="submit" id="registercompanybtn" class="btn btn-primary btn-block btn-flat"> <i class="fa fa-sign-in" aria-hidden="true"></i> Register</button>
					</div>
					<!-- /.col -->
				        </div>

                    <div class="form-group" id="errors" style="margin-top:10px;"> </div>
                    </form>
					</div>
					<div class="hidden" id="confirmemaildiv">
					<p class="login-box-msg">Enter confirmation code </p>
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('confirmemail') }}" id="completeregistrationform">
                        {{ csrf_field() }}

						<div class="form-group" id="errors1"> </div>
                        <div class="form-group has-feedback">
							<label>Confirmation Code </label>
                            <input id="code" type="text" class="form-control" name="code">
							<span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>


						  <div class="row">

							<!-- /.col -->
							<div class="col-xs-12" style="padding-right: 0px;padding-left: 0px;">
							  <button type="submit" id="completeregistrationbtn" class="btn btn-primary btn-block btn-flat"><i class="fa fa-sign-in" aria-hidden="true"></i> Complete Registration</button>
							</div>
							<!-- /.col -->
						  </div>
       
                    </form>
					</div>
					<div class="login-wrapper login-success hidden" id="loginsuccessdiv">
						<div class="login-widget animation-delay1">
							<div class="text-center">

								<div class="panel panel-default" style="padding: 35px;">
									<div class="alert alert-success">Authentication Successful</div>
									<div><span>Redirecting...</span><span style="margin-left: 10px;"><i class="fa fa-spinner fa-spin fa-lg"></i></span></div>
								</div>
							</div>
						</div>
						</div>	
        
@endsection

@section('scripts')

	<script src="/assets/js/register.js"></script>
	<script src="/int-tel/js/intlTelInput.js"></script>
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

@endsection
					
					
					
					
					