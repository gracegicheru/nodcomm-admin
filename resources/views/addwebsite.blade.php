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
                  <h5 class="breadcrumbs-title">Companies</h5>
                  <ol class="breadcrumbs">
                    <li><a href="/">Dashboard</a></li>
                    <li class="active">Companies</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <!--breadcrumbs end-->
          <!--start container-->
          <div class="container">
            <div class="section">
			  
              <div class="row company-wrapper" style="display:none;">
		

			     <div class="col s12">
				    <div class="card-panel" id="addwebsitediv">
                    <h4 class="header2">Add Company</h4>
					<div class="pull-right">
					<span class="fa fa-times close-companies" style="cursor:pointer;"></span>
					</div>
                    <div class="row">
					<form role="form" method="post" action="<?php echo URL::route('registercompany') ?>" id="addwebsiteform">
					{{ csrf_field() }}
                     
                        <div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">account_circle</i>
                            <input type="text" class="form-control" name="name" id="name1">
                            <label for="name">Company Name </label>
                          </div>
                        </div>
					    <div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">account_circle</i>
                            <input type="text" class="form-control" name="website" id="website1">
                            <label for="website">Company Website </label>
                          </div>
                        </div>
					    <div class="row">
                        <div class="input-field col s12">
						<i class="material-icons prefix">assignment_ind</i>
                          <select name="company_size" id="company_size1">
                            <option value="" disabled selected>Please select Company Size</option>
							<option value="1">1-5</option>
							<option value="2">5-10</option>
							<option value="3">11-20</option>
							<option value="4">21-30</option>
							<option value="5">31-40</option>
							<option value="6">41-50</option>
							<option value="7">50-100</option>
							<option value="8">100+</option>
                          </select>
                          <label>Select Company Size</label>
                        </div>
						</div>
						<div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">account_circle</i>
                            <input type="text" class="form-control" name="fname" id="fname1">
                            <label for="fname">First Name </label>
                          </div>
                        </div>
					    <div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">account_circle</i>
                            <input type="text" class="form-control" name="lname" id="lname1">
                            <label for="lname">Last Name </label>
                          </div>
                        </div>
                        <div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">email</i>
                            <input type="email" class="form-control" name="email" id="email1" >
                            <label for="email">Email</label>
                          </div>
                        </div>
						<div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">account_circle</i>
                            <input type="text" class="form-control" name="address" id="address1">
                            <label for="address">Address </label>
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
                              <button id="addwebsitebtn" class="btn cyan waves-effect waves-light right" type="submit">
                                <i class="material-icons right">add</i>  Register
                              </button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
				    <div class="card-panel hide" id="editwebsitediv">
					<h4 class="header2"><i class="fa fa-chevron-left fa-lg website-edit-back tooltipped "  data-position="top" data-delay="50" data-tooltip="Go back to add a Company" style="margin-right:10px;cursor:pointer;"></i> Edit Company</h4>
                   <div class="pull-right">
					<span class="fa fa-times close-companies" style="cursor:pointer;"></span>
					</div>
					<div class="row">
					<form role="form" method="post" action="<?php echo URL::route('editcompany') ?>" id="editwebsiteform">
					{{ csrf_field() }}
                     
                        <div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">account_circle</i>
                            <input type="text" class="form-control" name="name" id="name">
                            <label for="name">Company Name </label>
                          </div>
                        </div>
					    <div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">account_circle</i>
                            <input type="text" class="form-control" name="website" id="website">
                            <label for="website">Company Website </label>
                          </div>
                        </div>
					    <div class="row">
                        <div class="input-field col s12">
						<i class="material-icons prefix">assignment_ind</i>
                          <select name="company_size" id="company_size">
                            <option value="" disabled selected>Please select Company Size</option>
							<option value="1">1-5</option>
							<option value="2">5-10</option>
							<option value="3">11-20</option>
							<option value="4">21-30</option>
							<option value="5">31-40</option>
							<option value="6">41-50</option>
							<option value="7">50-100</option>
							<option value="8">100+</option>
                          </select>
                          <label>Select Company Size</label>
                        </div>
						</div>
						<div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">account_circle</i>
                            <input type="text" class="form-control" name="fname" id="fname">
                            <label for="fname">First Name </label>
                          </div>
                        </div>
					    <div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">account_circle</i>
                            <input type="text" class="form-control" name="lname" id="lname">
                            <label for="lname">Last Name </label>
                          </div>
                        </div>
                        <div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">email</i>
                            <input type="email" class="form-control" name="email" id="email" >
                            <label for="email">Email</label>
                          </div>
                        </div>
						<div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">account_circle</i>
                            <input type="text" class="form-control" name="address" id="address">
                            <label for="address">Address </label>
                          </div>
                        </div>
						<div class="row">
                          <div class="input-field col s10">
                            <!--<i class="material-icons prefix">call</i>-->
                            <input type="tel"  name="telno" id="tel1" class="form-control" placeholder="Enter your Mobile Number">
                         	<div style="width:10px;position:absolute;right: 30px;bottom: 10px;" >
							<span id="valid-msg" class="hide"> <i class="text-center fa fa-check" aria-hidden="true"></i> </span>
							<span id="error-msg" class="hide"><i class="fa fa-times" aria-hidden="true"></i> </span>	
							</div>
						 </div>
						  
                        </div>
						<div class="row">
                          <div class="row">
                            <div class="input-field col s12">
                              <input type="hidden" class="form-control" name="id" id="id">
							  <button id="editwebsitebtn" class="btn cyan waves-effect waves-light right" type="submit">
                                <i class="material-icons right">edit</i>  Update
                              </button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
				</div>
				<div class="row">
				 <div class="col s12">

					<div class="pull-right">
						<button class="btn btn-default addcompany" style="margin-right:10px;"><i class="fa fa-plus"></i> Add Company</button>
				   </div>
				</div>
                <div class="col s12">
              <!--DataTables example-->
              <div id="table-datatables">
                <h4 class="header">Registered Companies</h4>
                <div class="row">
					  <div class="col s12">
						<table id="data-table-simple" class="responsive-table display" cellspacing="0">
						  <thead>
							<tr>
							  <th>#</th>
							  <th>Name</th>
							  <th>Website</th>
							  <th>Status</th>
							  <th>Action</th>
							</tr>
						  </thead>
						  <tfoot>
							<tr>
							  <th>#</th>
							  <th>Name</th>
							  <th>Website</th>
							  <th>Status</th>
							  <th>Action</th>
							</tr>
						  </tfoot>
						  <tbody>
							@if (count($websites) > 0)
								
								@foreach($websites as $website)
									<tr>
									<td>{{ $loop->iteration }}</td>
									<td>{{ $website->name }}</td>
									<td>{{ $website->website }}</td>
									<td><?php if($website->active == 1) { echo 'Active'; }else{ echo 'Inactive'; } ?></td>
									<td>
									<a  class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Edit" onclick="editwebsite({{ $website->id }},'{{$website->name}}','{{$website->company_size}}','{{$website->website}}','{{$website->fname}}','{{$website->lname}}','{{$website->email}}','{{$website->phone}}','{{$website->address}}')"   style="margin-right:3px;" id="editwebsitebtn{{ $website->id }}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
									<?php if($website->active == 1) { ?>
									<a   class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Disable" onclick="disablewebsite({{ $website->id }})"  id="disablewebsitebtn{{ $website->id }}"  style="margin-right:3px;" ><i class="fa fa-times" aria-hidden="true"></i></a>
									<?php }else{ ?>
									<a   class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Enable" onclick="enablewebsite({{ $website->id }})"  id="enablewebsitebtn{{ $website->id }}"  style="margin-right:3px;" ><i class="fa fa-check" aria-hidden="true"></i></a>
									<?php } ?>
									<a  class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="View" onclick="viewwebsite({{ $website->id }})"  style="margin-right:3px;" id="viewwebsitebtn{{ $website->id }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
									<?php 
											$url = '/admin/login/'.$website->id;
									?>
									<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Login as Company" href="<?php echo url($url);?>" > <i class="fa fa-sign-in" aria-hidden="true"></i></a>
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
          <!--end container-->
        </section>
        <!-- END CONTENT -->
    @endsection
@section('scripts')
<script src="{{ url('assets/js/userip.js') }}"></script>
<script src="{{ url('assets/js/website.js') }}"></script>
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