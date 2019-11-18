@extends('layouts.app1')

@section('content')

					<p class="login-box-msg">Enter your new password </p>
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('updatepassword') }}" id="updatepasswordform">
                        {{ csrf_field() }}

						<div class="form-group" id="errors"> </div>
                        <div class="form-group has-feedback">
							<label>New Password </label>
                            <input id="password" type="password" class="form-control" name="password">
							<span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
							<label>Confirm New Password </label>
                            <input id="confirm_password" type="password" class="form-control" name="confirm_password">
							<span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>

						  <div class="row">

							<!-- /.col -->
							<div class="col-xs-12" style="padding-right: 0px;padding-left: 0px;">
							  <input id="email" type="hidden"  name="email" value="{{ $email }}">
							  <button type="submit" id="updatepasswordbtn" class="btn btn-primary btn-block btn-flat"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update Password</button>
							</div>
							<!-- /.col -->
						  </div>
       
                    </form>

              
@endsection
