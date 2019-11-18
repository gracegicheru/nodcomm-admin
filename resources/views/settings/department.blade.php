	@extends('layouts.new_master')
	@section('styles')
	<link rel="stylesheet" href="{{ url('/assets/css/custom.css') }}">
	@endsection('styles')
	@section('content')
	<!-- START CONTENT -->
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <!-- Search for small screen -->
            <div class="header-search-wrapper grey lighten-2 hide-on-large-only">
              <input type="text" name="Search" class="header-search-input z-depth-2" placeholder="Explore Materialize">
            </div>
            <div class="container">
              <div class="row">
                <div class="col s10 m6 l6">
                  <h5 class="breadcrumbs-title">Department Settings</h5>
                  <ol class="breadcrumbs">
                    <li><a href="/">Dashboard</a></li>
                    <li class="active">Department Settings</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <!--breadcrumbs end-->
          <!--start container-->
          <div class="container">
            <div class="section">
              <div class="row">
					<div class="col s6">
					<div class="card-panel" id="adddepartmentdiv">
						<h4 class="header2">Department Settings</h4>
						<div class="row">
						<form role="form" method="post" action="<?php echo URL::route('adddepartment') ?>" enctype="multipart/form-data" id="departmentform">
						{{ csrf_field() }}
						 
							<div class="row">
							  <div class="input-field col s12">
								<i class="material-icons prefix">account_circle</i>
								<input type="text" class="form-control" name="name" value="">
								<label for="name">Name</label>
							  </div>
							</div>
							<div class="row">
							  <div class="input-field col s12">
								<i class="material-icons prefix">message</i>
							   <textarea name="description"  class="materialize-textarea" data-length="120"></textarea>
								<label for="description">Description</label>
							  </div>
							</div>
                  <div class="row">
                     <div class="col s12">
					 <p>Members</p>
					 </div>
                    <div class="col s12">
                      <div class="card-panel pull-left" style="margin-right: 10px;min-height:200px;">
						  <h4 class="header2">Not Selected Agent (s)</h4>
						  <div class="row">
							<ul class="list-group" id="unselectedagentul">
							 @if (count($users) > 0)
					
					         @foreach($users as $user)
								<li class="list-group-item selectedagent" data-id="{{ $user->id }}" style="cursor: pointer;" onclick="selectagent({{ $user->id }},this)"> 
								{{ ucwords($user->name) }}
								</li>
							@endforeach
                  

							@endif
							<ul>
						  </div>
					  </div>
					  <div class="pull-left" style="margin-right: 10px;min-height:200px;">
					    <div style="padding-top:40px;">
							<i id="selectagentbtn" class="fa fa-arrow-right" aria-hidden="true"></i>
						</div>
					    <div>
							<i id="unselectagentbtn" class="fa fa-arrow-left" aria-hidden="true"></i>
						</div>
					  </div>
					  <div class="pull-left">
                      <div class="card-panel pull-left" style="margin-right: 10px;min-height:200px;">
						   <h4 class="header2">Selected Agent (s)</h4>
						  <div class="row">
							<ul class="list-group" id="selectedagentul">

							<ul>
						  </div>
					  </div>
					  </div>
                    </div>
                  </div>
					        

							<div class="row">
							  <div class="row">
								<div class="input-field col s12">
								  <button id="adddepartmentbtn" class="btn cyan waves-effect waves-light right" type="submit">
									<i class="material-icons right">add</i>  Save
								  </button>
								</div>
							  </div>
							</div>
						  </form>
						</div>
					  </div>
					  <div class="card-panel hide" id="updatedepartmentdiv">
						<h4 class="header2">Department Settings</h4>
						<div class="row">
						<form role="form" method="post" action="<?php echo URL::route('updatedepartment') ?>" enctype="multipart/form-data" id="updatedepartmentform">
						{{ csrf_field() }}
						 
							<div class="row">
							  <div class="input-field col s12">
								<i class="material-icons prefix">account_circle</i>
								<input type="text" class="form-control" name="name" id="name" value="">
								<label for="name"> Name</label>
							  </div>
							</div>
							<div class="row">
							  <div class="input-field col s12">
								<i class="material-icons prefix">message</i>
							   <textarea name="description" id="description" class="materialize-textarea" data-length="120"></textarea>
								<label for="description">Description</label>
							  </div>
							</div>

                  <div class="row">
                     <div class="col s12">
					 <p>Members</p>
					 </div>
                    <div class="col s12">
                      <div class="card-panel pull-left" style="margin-right: 10px;min-height:200px;">
						  <h4 class="header2">Not Selected Agent (s)</h4>
						  <div class="row">
							<ul class="list-group" id="editunselectedagentul">

							<ul>
						  </div>
					  </div>
					  <div class="pull-left" style="margin-right: 10px;min-height:200px;">
					    <div style="padding-top:40px;">
							<i id="editselectagentbtn" class="fa fa-arrow-right" aria-hidden="true"></i>
						</div>
					    <div>
							<i id="editunselectagentbtn" class="fa fa-arrow-left" aria-hidden="true"></i>
						</div>
					  </div>
					  <div class="pull-left">
                      <div class="card-panel pull-left" style="margin-right: 10px;min-height:200px;">
						   <h4 class="header2">Selected Agent (s)</h4>
						  <div class="row">
							<ul class="list-group" id="editselectedagentul">

							<ul>
						  </div>
					  </div>
					  </div>
                    </div>
                  </div>
							<div class="row">
							  <div class="row">
								<div class="input-field col s12">
								<input type="hidden" class="form-control" name="id" id="id"  value="">
								  <button id="updatedepartmentbtn" class="btn cyan waves-effect waves-light right" type="submit">
									<i class="material-icons right">edit</i>  Update
								  </button>
								</div>
							  </div>
							</div>
						  </form>
						</div>
					  </div>
					</div>
					<div class="col s6">
					  <div class="card-panel ">
					   <table id="data-table-simple" class="responsive-table display" cellspacing="0">
						<thead>
						<tr>
						  <th style="width: 10px">#</th>
						  <th>Department Name</th>
						  <th>Action</th>
								  
						</tr>
						</thead>
						<tfoot>
						<tr>
						  <th style="width: 10px">#</th>
						  <th>Department Name</th>
						  <th>Action</th>
								  
						</tr>
						</tfoot>
						<tbody>
							@if (count($departments) > 0)
								@foreach($departments as $department)
									<tr>
									<td>{{ $loop->iteration }}</td>
									<td>{{ $department->department_name }}</td>
									<td>
										<a  class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Edit" onclick="editdepartment({{ $department->id }})"  class="btn btn-xs btn-info" style="margin-right:3px;" id="editdepartmentbtn{{ $department->id }}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
									</td>
									</tr>
								@endforeach
							 @endif
						</tbody>
					  </table>
					  </div>
					</div>
              </div>
			
            </div>

          </div>
          <!--end container-->
        </section>
        <!-- END CONTENT -->
    @endsection
@section('scripts')
<script src="{{ url('assets/js/department.js') }}"></script>
@endsection