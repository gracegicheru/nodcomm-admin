@extends('layouts.master')
@section('styles')
<link rel="stylesheet" href="{{ url('/assets/css/custom.css') }}">
@endsection('styles')
@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
	  {{ ucwords($agents->department_name)}} Agents
      </h1>
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>

        <li class="active"> {{ ucwords($agents->department_name)}} Agents</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">

		<div class="col-md-12">
			<!-- /.box -->
		    <div class="box box-primary ">

            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-striped" id="dataTable">
                <thead>
				<tr>
                  <th style="width: 10px">#</th>
                  <th>Agent Name</th>
				  <th>Email</th>
				  <th>Status</th>       
                </tr>
				</thead>
                <tbody>

				@if (count($agents) > 0)
					@foreach($agents->users as $user)
						<tr>
						<td>{{ $loop->iteration }}</td>
						<td>{{ $user->name }}</td>
						<td>{{ $user->email }}</td>
						<td><?php if($user->active == 1) { echo 'Active'; }else{ echo 'Inactive'; } ?></td>

						</tr>
					@endforeach
                 @endif
                </tbody>
              </table>
           

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        </div>
        <!-- /.col -->
		

      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>

  <!-- /.content-wrapper -->
 @endsection
 @section('scripts')

<script src="/assets/js/department.js"></script>

@endsection