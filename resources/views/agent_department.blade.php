@extends('layouts.master')
@section('styles')
<link rel="stylesheet" href="{{ url('/assets/css/custom.css') }}">
@endsection('styles')
@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Content Header (Page headerw) -->
    <section class="content-header">
      <h1>
    {{ ucwords($departments->name)}} Departments
      </h1>
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>

        <li class="active"> {{ ucwords($departments->name)}} Departments</li>
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
                  <th>Department Name</th>
          <th>Department Description</th>        
                </tr>
        </thead>
                <tbody>

        @if (count($departments) > 0)
          @foreach($departments->departments as $department)
            <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $department->department_name }}</td>
            <td>
            <?php 
            if(strlen($department->description) > 140){
              echo substr(ucfirst($department->description), 0, 140)."...";
              }
            else{
              echo $department->description;
              }
              ?>
            </td>

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