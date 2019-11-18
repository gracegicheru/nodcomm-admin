	@extends('layouts.new_master')
	@section('styles')
	<link rel="stylesheet" href="{{ url('int-tel/css/intlTelInput.css')}}">
	<link rel="stylesheet" href="{{ url('assets/css/custom.css')}}">
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
                  <h5 class="breadcrumbs-title">Users</h5>
                  <ol class="breadcrumbs">
                    <li><a href="/">Dashboard</a></li>
                    
                    <li class="active">Users</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <!--breadcrumbs end-->
          <!--start container-->
          <div class="container">
            <div class="section">
			  <div>
              <div class="row">
			     <div class="col s12">
				    <div class="card-panel" id="addagentdiv">
                    <h4 class="header2">Add User</h4>
                    <div class="row">
					<form role="form" method="post" action="<?php echo URL::route('addagent') ?>" id="registerform">
					{{ csrf_field() }}
                     
                        <div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">account_circle</i>
                            <input type="text" class="form-control" name="username">
                            <label for="username">Username</label>
                          </div>
                        </div>
                        <div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">email</i>
                            <input type="email" class="form-control" name="email">
                            <label for="email">Email</label>
                          </div>
                        </div>
						<div class="row">
                        <div class="input-field col s12">
						<i class="material-icons prefix">assignment_ind</i>
                          <select name="usertype">
                            <option value="" disabled selected>Please select User type</option>
                            <option value="1">Administrator</option>
                            <option value="0">Agent</option>
                          </select>
                          <label>Select user type</label>
                        </div>
						</div>
                        <div class="row">
                          <div class="input-field col s10">
                            <!--<i class="material-icons prefix">call</i>-->
                            <input type="tel"  name="telno" id="tel" class="form-control" placeholder="Enter your Mobile Number">
                         	<div style="width:10px;position:absolute;right: 30px;bottom: 10px;" >
							<span id="valid-msg" class="hide"> <i class="text-center fa fa-check" aria-hidden="true"></i> </span>
							<span id="error-msg" class="hide"><i class="fa fa-times" aria-hidden="true"></i> </span>	
							</div>
						 </div>
						  
                        </div>

						<div class="row">
                          <div class="row">
                            <div class="input-field col s12">
                              <button id="registerbtn" class="btn cyan waves-effect waves-light right" type="submit">
                                <i class="material-icons right">add</i>  Register
                              </button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                  <div class="card-panel hide" id="editagentdiv">
                    <h4 class="header2"><i class="fa fa-chevron-left fa-lg agent-edit-back1" data-toggle="tooltip" data-original-title="Go back to add admin" style="margin-right:10px;cursor:pointer;"></i> Edit User</h4>
                    <div class="row">
					 <form role="form" method="post" action="<?php echo URL::route('editagent') ?>" id="editagentform">
                       {{ csrf_field() }}
					   <div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">account_circle</i>
                            <input type="text" class="form-control" name="username" id="username">
                            <label for="username">Username</label>
                          </div>
                        </div>
                        <div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">email</i>
                            <input type="email" class="form-control" name="email" id="email">
                            <label for="email">Email</label>
                          </div>
                        </div>
						<div class="row">
                        <div class="input-field col s12">
						<i class="material-icons prefix">assignment_ind</i>
                          <select name="usertype" id="usertype">
                            <option value="" disabled selected>Please select User type</option>
                            <option value="1">Administrator</option>
                            <option value="0">Agent</option>
                          </select>
                          <label>Select user type</label>
                        </div>
						</div>
                        <div class="row">
                          <div class="input-field col s10">
                            <!--<i class="material-icons prefix">call</i>-->
                            <input type="tel"  name="telno" id="tel1" class="form-control" placeholder="Enter your Mobile Number">
                         	<div style="width:10px;position:absolute;right: 30px;bottom: 10px;" >
							<span id="valid-msg1" class="hide"> <i class="text-center fa fa-check" aria-hidden="true"></i> </span>
							<span id="error-msg1" class="hide"><i class="fa fa-times" aria-hidden="true"></i> </span>	
							</div>
						 </div>
						  
                        </div>
						<div class="row">
                          <div class="row">
                            <div class="input-field col s12">
							<input type="hidden" class="form-control" name="id" id="id">
                              <button  class="btn cyan waves-effect waves-light right" type="submit" id="editagentbtn">Edit
                                <i class="material-icons right">edit</i>
                              </button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <div class="col s12">
              <!--DataTables example-->
              <div id="table-datatables">
                <h4 class="header">Registered Users</h4>
                <div class="row">
					  <div class="col s12">
						<table id="data-table-simple" class="responsive-table display" cellspacing="0">
						  <thead>
							<tr>
							  <th>#</th>
							  <th>Username</th>
							  <th>Email</th>
							  <th>User type</th>
							  <th>Status</th>
							  <th>Action</th>
							</tr>
						  </thead>
						  <tfoot>
							<tr>
							  <th>#</th>
							  <th>Username</th>
							  <th>Email</th>
							  <th>User type</th>
							  <th>Status</th>
							  <th>Action</th>
							</tr>
						  </tfoot>
						  <tbody>
				@if (count($users) > 0)
					
					@foreach($users as $user)
						<tr>
						<td>{{ $loop->iteration }}</td>
						<td>{{ $user->name }}</td>
						<td>{{ $user->email }}</td>
						<td><?php if($user->admin == 1) { echo 'Admin'; }else{ echo 'Agent'; } ?></td>
						<td><?php if($user->active == 1) { echo 'Active'; }else{ echo 'Inactive'; } ?></td>
						<td width="40%">
							<a  class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Edit" onclick="editagent({{ $user->id }})"  class="btn btn-xs btn-info" style="margin-right:3px;" id="editagentbtn{{ $user->id }}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
							<?php if($user->active == 1) { ?>
							<a  class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Disable" onclick="disableagent({{ $user->id }})"  id="disableagentbtn{{ $user->id }}" class="btn btn-xs btn-danger" style="margin-right:3px;" ><i class="fa fa-times" aria-hidden="true"></i></a>
							<?php }else{ ?>
							<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Enable" onclick="enableagent({{ $user->id }})"  id="enableagentbtn{{ $user->id }}" class="btn btn-xs btn-success" style="margin-right:3px;" ><i class="fa fa-check" aria-hidden="true"></i></a>
							<?php } ?>
							<?php 
								//$url = '/login/'.$user->id;
								$url='/impersonateIn/'.$user->id;
							if($user->admin != 1){
							?>
							<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Login as User" href="<?php echo url($url);?>" class="btn btn-xs btn-info"  target="_blank"> <i class="fa fa-sign-in" aria-hidden="true"></i></a>	
							<?php } ?>
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
            </div>


            </div>

          </div>
          <!--end container-->
        </section>
        <!-- END CONTENT -->
    @endsection
@section('scripts')

<script src="{{ url('assets/js/register.js') }}"></script>
<script src="{{ url('int-tel/js/intlTelInput.js') }}"></script>
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

$("#tel1").intlTelInput({
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