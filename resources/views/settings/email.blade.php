
@extends('layouts.master')
@section('styles')

@endsection('styles')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="font-weight:normal">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Email Setting
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
		  @if(empty($email))
          <div class="box box-primary" id="addemaildiv">
            <!-- form start -->
    		<form role="form" method="post" action="<?php echo URL::route('addemailsetting') ?>" id="addemailform">
             {{ csrf_field() }}
			
			 <div class="box-body">
					  <div class="form-group">
					   <label>Username </label>
						<input name="name" type="text" class="form-control" placeholder="Username">
					  </div>
					  <div class="form-group">
					   <label>Port </label>
						<input name="port" type="text" class="form-control" placeholder="Port">
					  </div>
					  <div class="form-group">
					   <label>Host </label>
						<input name="host" type="text" class="form-control" placeholder="Host">
					  </div>
					   <div class="form-group">
						  <label>Encryption</label>
							<textarea class="form-control" rows="5"  name="encryption" placeholder="Encryption"></textarea>
						</div>
					  <div class="form-group">
					   <label>Password </label>
						<input name="password" type="text" class="form-control" placeholder="Password">
					  </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary" id="addemailbtn"><i class="fa fa-plus" aria-hidden="true"></i> Add</button>
              </div>
            </form>
          </div>
          <!-- /.box -->
		  
          <div class="box box-primary hidden" id="editemaildiv">
            <!-- form start -->
    		<form role="form" method="post" action="<?php echo URL::route('editemailsetting') ?>" id="editemailform">
             {{ csrf_field() }}
			
			 <div class="box-body">
	
					  <div class="form-group">
					   <label>Username </label>
						<input name="name" id="name" type="text" class="form-control" placeholder="Username">
					  </div>
					  <div class="form-group">
					   <label>Port </label>
						<input name="port" id="port" type="text" class="form-control" placeholder="Port">
					  </div>
					  <div class="form-group">
					   <label>Host </label>
						<input name="host" id="host" type="text" class="form-control" placeholder="Host">
					  </div>
					   <div class="form-group">
						  <label>Encryption</label>
							<textarea class="form-control" rows="5"  name="encryption" id="encryption" placeholder="Encryption"></textarea>
						</div>
					  <div class="form-group">
					   <label>Password </label>
						<input name="password" id="password" type="text" class="form-control" placeholder="Password">
					  </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
			   <input type="hidden" class="form-control" name="id" id="id">
                <button type="submit" class="btn btn-primary" id="editemailbtn"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button>
              </div>
            </form>
          </div>
          <!-- /.box -->
		@else
          <div class="box box-primary " id="editemaildiv">
            <!-- form start -->
    		<form role="form" method="post" action="<?php echo URL::route('editemailsetting') ?>" id="editemailform">
             {{ csrf_field() }}
			
			 <div class="box-body">
	
					  <div class="form-group">
					   <label>Username </label>
						<input name="name" id="name" type="text" class="form-control" placeholder="Username" value="{{$email->username}}">
					  </div>
					  <div class="form-group">
					   <label>Port </label>
						<input name="port" id="port" type="text" class="form-control" placeholder="Port" value="{{$email->port}}">
					  </div>
					  <div class="form-group">
					   <label>Host </label>
						<input name="host" id="host" type="text" class="form-control" placeholder="Host" value="{{$email->host}}">
					  </div>
					   <div class="form-group">
						  <label>Encryption</label>
							<textarea class="form-control" rows="5"  name="encryption" id="encryption" placeholder="Encryption">{{$email->encryption}}</textarea>
						</div>
					  <div class="form-group">
					   <label>Password </label>
						<input name="password" id="password" type="text" class="form-control" placeholder="Password" value="{{$email->password}}">
					  </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
			   <input type="hidden" class="form-control" name="id" id="id" value="{{$email->id}}">
                <button type="submit" class="btn btn-primary" id="editemailbtn"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button>
              </div>
            </form>
          </div>
          <!-- /.box -->
		@endif
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

<script src="/assets/js/email.js"></script>

@endsection