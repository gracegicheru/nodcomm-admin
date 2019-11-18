
@extends('layouts.master')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="font-weight:normal">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Change Password
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
					<div class="hidden" id="passdiv" >
					  <div class="box box-primary">
						<div class="form-group" id="errors"> </div>
						<!-- form start -->
						<form role="form" method="post" action="<?php echo URL::route('changepassword') ?>" id="changepasswordform">
						 {{ csrf_field() }}
						
						 <div class="box-body">
						   <div class="form-group">
							  <label>New Password </label>
							 <input id="password" type="password" class="form-control" name="password">
							</div>
						   <div class="form-group">
							  <label>Confirm New Password </label>
							  <input id="confirm_password" type="password" class="form-control" name="confirm_password">
							</div>
						  </div>
						  <!-- /.box-body -->

						  <div class="box-footer">
							<button type="submit" class="btn btn-primary" id="changepasswordbtn"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update Password</button>
						  </div>
						</form>
					  </div>
					  <!-- /.box -->
					</div>
					<div  id="confirmdiv" >
					  <div class="box box-primary">
						<div class="form-group alert alert-success" id="errors1"> Please use the code sent to you to confirm password change request</div>
						<!-- form start -->
						<form role="form" method="post" action="<?php echo URL::route('confirmcode') ?>" id="changepassform">
						 {{ csrf_field() }}
						
						 <div class="box-body">
						   <div class="form-group">
							  <label>Confirmation Code  </label>
							 <input  type="text" class="form-control" name="code">
							</div>
						  </div>
						  <!-- /.box-body -->

						  <div class="box-footer">
							<button type="submit" class="btn btn-primary" id="changepassbtn"><i class="fa fa-check" aria-hidden="true"></i> Confirm Password Change Request</button>
						  </div>
						</form>
					  </div>
					  <!-- /.box -->
					</div>

        </section>
        <!-- /.Left col -->

      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
@section('scripts')

<script src="/assets/js/register.js"></script>

@endsection