@extends('layouts.app1')

@section('content')
					<p class="login-box-msg">Enter your Email </p>
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('resetemail') }}" id="resetemailform">
                        {{ csrf_field() }}

						<div class="form-group" id="errors"> </div>
                        <div class="form-group has-feedback" id="emaildiv">
							<label>Email </label>
                            <input id="email" type="email" class="form-control" name="email">
							<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        </div>


						  <div class="row" id="submitdiv">

							<!-- /.col -->
							<div class="col-xs-12" style="padding-right: 0px;padding-left: 0px;">
							  <button type="submit" id="resetemailbtn" class="btn btn-primary btn-block btn-flat"><i class="fa fa-sign-in" aria-hidden="true"></i> Send Reset Password Email</button>
							</div>
							<!-- /.col -->
						  </div>
       
                    </form>

              
@endsection
