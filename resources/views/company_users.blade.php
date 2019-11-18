
@extends('layouts.master')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="font-weight:normal">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
	  {{$users->name }} Users
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

        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-12 connectedSortable">

          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Registered Users</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
				<table class="table table-bordered table-condensed table-hover table-striped table-vertical-center" id="dataTable">
                <thead>
                <tr>
				  <th>#</th>
                  <th>Username</th>
                  <th>Email</th>
				  <th>Telephone No</th>
				  <th>Address</th>
				  <th>User type</th>
				  <th>Status</th>
				  <th>Action</th>
                </tr>
                </thead>
                <tbody>
				@if (count($users->users) > 0)
					
					@foreach($users->users as $user)
						<tr>
						<td>{{ $loop->iteration }}</td>
						<td>{{ $user->name }}</td>
						<td>{{ $user->email }}</td>
						<td>
						@if(empty($user->phone))
						-
						@else
						{{ $user->phone }}
						@endif
						</td>
						<td>
						@if(empty($user->address))
						-
						@else
						{{ $user->address }}
						@endif
						</td>

						<td><?php if($user->admin == 1) { echo 'Admin'; }else{ echo 'Agent'; } ?></td>
						<td><?php if($user->active == 1) { echo 'Active'; }else{ echo 'Inactive'; } ?></td>
						<td>

						<?php 
							$url = '/login/'.$user->id;
					
						?>
						<a data-toggle="tooltip" data-placement="top" title="" data-original-title="Login as User" href="<?php echo url($url);?>" class="btn btn-xs btn-info"> <i class="fa fa-sign-in" aria-hidden="true"></i></a>	
						
						</td>
						</tr>
                    @endforeach
                  

                @endif
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </section>
        <!-- right col -->
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