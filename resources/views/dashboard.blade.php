@extends('layouts.new_master')
@section('styles')
<link rel="stylesheet" href="{{ url('/assets/css/custom.css') }}">
<style>
.circulardiv{
    border-radius: 50%;
    display: inline-block;
    height: 250px;
    width: 250px;
    text-align: center;
    vertical-align: middle;
    line-height: 250px;
}
</style>
@endsection('styles')
@section('content')
        <!-- START CONTENT -->
        <section id="content">
		          <!--start container-->
          <div class="container">
		  			<div class="row" >
			  <div class="col  s12 timesmsform">
					<div class="card-panel">
						<form role="form" method="post" action="<?php echo URL::route('sms_summary') ?>" id="ApplySMStimefilterform">
						{{ csrf_field() }}
						<div class="row" >
						  <h4 class="header2">Filter SMS by Time</h4>
						</div>
						  <div class="row" style="margin-right: -10px;margin-left: -10px;">
							<div class="col s12">
								  <select name="time_search" id="status-filter1">
								    <option value="1">Today</option>
									<option value="2">This Week </option>
									<option value="3">Last Week </option>
									<option value="4">This Month </option>	
									<option value="5">Last Month</option>
								  </select>

							</div>
							<div class="loading-overlay loading-filters"></div>
							</div>
							<div class="row" style="margin-right: -10px;margin-left: -10px;margin-top: 20px;">
							<div class="col-md-12">
							  <div class="clearfix">
								<div class="pull-right">
								  <button class="btn btn-primary " id="apply-time-filter"><i class="fa fa-check"></i> Search</button>
								</div>
							  </div>
							</div>
						  </div>
						  </form>
				</div>
				</div>
			  </div>
            <div class="section">
              <div class="row">
                <div class=" col s3">
				<p style="text-align:center">Total Traffic</p>
                  <div class="circulardiv card gradient-45deg-light-blue-cyan gradient-shadow min-height-100 white-text">
                    <div class="padding-4" id="total_traffic">
						
                    </div>
                  </div>
                </div>
				
				  <!--Morris Donut Chart-->
				 <div class="col s6">
				 <p style="text-align:center">Delivery Rate</p>
					 <div id="morris-donut-chart">
							<div class="sample-chart-wrapper">
							  <div id="morris-donut" class="graph"></div>
							</div>
					 </div>
				  </div>
                 <div class=" col s3">
				 <p style="text-align:center">Total Cost</p>
                  <div class="circulardiv card gradient-45deg-light-blue-cyan gradient-shadow min-height-100 white-text">
                    <div class="padding-4" id="total_cost">
						
                    </div>
                  </div>
                </div>


			  </div>
            </div>

          </div>
          <!--end container-->
		
          <!--start container-->
          <div class="container">
		              <!--chart dashboard start-->
            <div id="chart-dashboard">
              <div class="row">
                <div class="col s12">
                  <div class="card">
                    <div class="card-move-up waves-effect waves-block waves-light">
                      <div class="move-up cyan darken-1">
					  <div>
                          <span class="chart-title white-text" id="filter_title">SMS Filter</span>
                        </div>
                        <div class="trending-line-chart-wrapper">
                          <canvas id="trending-line-chart" height="70"></canvas>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>

              </div>
            </div>
            <!--chart dashboard end-->
            <!--card stats start-->
            <div id="card-stats">
              <div class="row">
                <div class="col s12 m6 l3">
                  <div class="card gradient-45deg-light-blue-cyan gradient-shadow min-height-100 white-text">
                    <div class="padding-4">
                      <div class="col s7 m7">
                        <i class="material-icons background-round mt-5">add_shopping_cart</i>
                        <p><a style="color:#ffffff" href="{{ url('/admin/companies') }}">Companies</a></p>
                      </div>
                      <div class="col s5 m5 right-align">
                        <h5 class="mb-0" id="newcompanies"></h5>
                        <p class="no-margin">New</p>
                        <p id="companies"></p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col s12 m6 l3">
                  <div class="card gradient-45deg-red-pink gradient-shadow min-height-100 white-text">
                    <div class="padding-4">
                      <div class="col s7 m7">
                        <i class="material-icons background-round mt-5">people</i>
						<p><a style="color:#ffffff" href="{{ url('/visitors/all') }}">Visitors</a></p>
                      </div>
                      <div class="col s5 m5 right-align">
                        <h5 class="mb-0" id="newvisitors"></h5>
                        <p class="no-margin">New</p>
                        <p id="visitors"></p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col s12 m6 l3">
                  <div class="card gradient-45deg-amber-amber gradient-shadow min-height-100 white-text">
                    <div class="padding-4">
                      <div class="col s7 m7">
                        <i class="material-icons background-round mt-5">people</i>
                        <p><a style="color:#ffffff" href="{{ url('/users') }}">Clients</a></p>
                      </div>
                      <div class="col s5 m5 right-align">
                        <h5 class="mb-0" id="newusers"></h5>
                        <p class="no-margin">New</p>
                        <p id="users"></p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col s12 m6 l3">
                  <div class="card gradient-45deg-green-teal gradient-shadow min-height-100 white-text">
                    <div class="padding-4">
                      <div class="col s7 m7">
                        <i class="material-icons background-round mt-5">message</i>
                        <p><a style="color:#ffffff" href="{{ url('/messages/history') }}">Messages</a></p>
                      </div>
                      <div class="col s5 m5 right-align">
                        <h5 class="mb-0" id="newmessages"></h5>
                        <p class="no-margin">New</p>
                        <p id="messages"></p> 
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--card stats end-->

			   <div id="table-datatables">
                <h4 class="header">Registered Companies</h4>
                <div class="row">
                  <div class="col s12">
                    <table id="data-table-simple" class="responsive-table display centered" cellspacing="0">
                      <thead>
                        <tr>
						  <th>#</th>
						  <th>Company Name</th>
						  <th>Company Website</th>
						  <th>Messages</th>
						  <th>Linked Websites</th>
						  <th>Clients</th>
						  <th>Visitors</th>
						  <th>Status</th>
						  <th>Action</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
							  <th>#</th>
							  <th>Company Name</th>
							  <th>Company Website</th>
							  <th>Messages</th>
							  <th>Linked Websites</th>
							  <th>Clients</th>
							  <th>Visitors</th>
							  <th>Status</th>
							  <th>Action</th>
                        </tr>
                      </tfoot>
                      <tbody>
							@if (count($companies) > 0)
								
								
								@foreach($companies as $company)
										
										<tr>
										<td>{{ $loop->iteration }}</td>
										<td>{{ $company->name }}</td>
										<td>{{ $company->website }}</td>
										<td> 
											<?php 
												$msgsurl = '/company/messages/'.$company->id;
												if(count($company->messages)>0){
											?>
											<a style="text-decoration: underline;" href="<?php echo url($msgsurl);?>">{{ count($company->messages)}}</a> 
											<?php }else {?>
												{{ count($company->messages)}}
											<?php } ?>
										</td>
										<td> 
											<?php 
												$sitesurl = '/company/websites/'.$company->id;
												if(count($company->sites)>0){
											?>
											<a style="text-decoration: underline;" href="<?php echo url($sitesurl);?>">{{ count($company->sites)}}</a> 
											<?php }else {?>
												{{ count($company->sites)}}
											<?php } ?>
										</td>
										<td> 
											<?php 
												$usersurl = '/company/users/'.$company->id;
												if(count($company->users)>0){
											?>
											<a style="text-decoration: underline;" href="<?php echo url($usersurl);?>">{{ count($company->users)}}</a> 
											<?php }else {?>
												{{ count($company->users)}}
											<?php } ?>
										</td>
										<td> 
											<?php 
												$visitorsurl = '/company/visitors/'.$company->id;
												if($company->totalvisitors>0){
											?>
											<a style="text-decoration: underline;" href="<?php echo url($visitorsurl);?>">{{ $company->totalvisitors}}</a> 
											<?php }else {?>
												{{ $company->totalvisitors}}
											<?php } ?>
										</td>
										<td><?php if($company->active == 1) { echo 'Active'; }else{ echo 'Inactive'; } ?></td>
										<td>
										<?php 
											$url = '/admin/login/'.$company->id;
										?>
											<a data-toggle="tooltip" data-placement="top" title="" data-original-title="Login as Company" href="<?php echo url($url);?>" class="btn btn-xs btn-info" style="vertical-align: middle"> <i  class="fa fa-sign-in" aria-hidden="true"></i></a>	
										</td>
										</tr>
										
								
								@endforeach
							  

							@endif
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
			  <div class="row">
			  <div class="col  s12 namesenderidsmsform">
					<div class="card-panel">
						<form role="form" method="post" action="<?php echo URL::route('search_company_by_name') ?>" id="ApplyCompanynamefilterform">
						{{ csrf_field() }}
						<div class="row" >
						  <h4 class="header2">Search Company  by Name</h4>
						</div>
						  <div class="row" style="margin-right: -10px;margin-left: -10px;">
							<div class="col s12">
								<input type="text" name="search" class="header-search-input z-depth-2" placeholder="Search Company by name" id="company-search-term"/>

							</div>
							<div class="loading-overlay loading-filters"></div>
							</div>
							<div class="row" style="margin-right: -10px;margin-left: -10px;margin-top: 20px;">
							<div class="col-md-12">
							  <div class="clearfix">
								<div class="pull-right">
								  <button class="btn btn-primary " id="apply-company-name-filter"><i class="fa fa-check"></i> Search</button>
								</div>
							  </div>
							</div>
						  </div>
						  </form>
				</div>
				</div>
			  </div>
			  <div class=" hide col s12 CompanyNametable">
						<div class="card-panel">
						<div class="row" >
						  <h4 class="header2">Found Companies</h4>
						</div>
						<div class="row" >
						<table class="striped responsive-table" id="dataTable7">
						  <thead>
							<tr>
							  <th>Name</th>
							  <th>Website</th>
							  <th>Status</th>
							  <th>Action</th>
							</tr>
						  </thead>
						  <tbody id="msg-history3" class="search-results">

						  </tbody>
						</table>
					  </div>
					  <div class="row" style="margin-top:15px;">
					  	<div class="center">
							  <button class="btn btn-default" id="load-more3" style="width: 30%;">Load more</button>
						</div>
					 </div>
					  </div>

			</div>
			<div class="row" >
			  <div class="col  s12 timesmsform">
					<div class="card-panel">
						<form role="form" method="post" action="<?php echo URL::route('search_sms_by_phone') ?>" id="ApplySMSphonefilterform">
						{{ csrf_field() }}
						<div class="row" >
						  <h4 class="header2">Search SMS by Mobile Number</h4>
						</div>
						  <div class="row" style="margin-right: -10px;margin-left: -10px;">
							<div class="col s12">
								<input type="text" name="search" class="header-search-input z-depth-2" placeholder="Search SMS by Mobile Number" id="phone-search-term"/>
							</div>
							<div class="loading-overlay loading-filters"></div>
							</div>
							<div class="row" style="margin-right: -10px;margin-left: -10px;margin-top: 20px;">
							<div class="col-md-12">
							  <div class="clearfix">
								<div class="pull-right">
								  <button class="btn btn-primary " id="apply-phone-filter"><i class="fa fa-check"></i> Search</button>
								</div>
							  </div>
							</div>
						  </div>
						  </form>
				</div>
				</div>
			  </div>
			  <div class=" hide col s12 phonesmstable">
						<div class="card-panel">
						<div class="row" >
						  <h4 class="header2">Found sms</h4>
						</div>
						<div class="row" >
						<table class="striped responsive-table" id="dataTable7">
						  <thead>
							<tr>
							  <th>Date</th>
							  <th>Message</th>
							  <th>To</th>
							  <th>Status</th>
							</tr>
						  </thead>
						  <tbody id="msg-history1" class="search-results">

						  </tbody>
						</table>
					  </div>
					  <div class="row" style="margin-top:15px;">
					  	<div class="center">
							  <button class="btn btn-default" id="load-more1" style="width: 30%;">Load more</button>
						</div>
					 </div>
					  </div>

			</div>  
            <!--end container-->
			<div class="row" >
			  <div class="col  s12">
			  <div class="card-panel" style="background-color:#383f47;">
				<h4 class="white-text header2">Companies</h4>
				<p class="grey-text text-lighten-4">A map displaying companies spread in the world.</p>
				<div id="world-map-markers" style="width:100%!important; height:430px"></div>
			  </div>
			  </div>
			</div>
        </section>
        <!-- END CONTENT -->
		  <!-- push permission UI -->
		<div class="push-ui-wrapper ">
		<meta name="csrf-token" content="{{ csrf_token() }}">
			<div class="push-ui-header">
				Get Notifications 
			</div>
			<div class="push-ui-body">
				Get a push notification on your device .
			</div>
			<div class="push-ui-footer">
				<div class="clearfix">
					<div class="pull-right">
						<button class="btn btn-info push-allow">Allow</button>
						<a class="push-close">Close</a>
					</div>
				</div>
			</div>
			
		</div>
		<!-- /push permission UI -->
            <div id="modal1" class="modal">
              <div class="modal-content">
			  
			                <!--Bordered Table-->
              <div id="bordered-table">
                <h4 class="header">Earning</h4>
                <div class="row">
                  <div class="col s12">
                    <table class="bordered">
                      <thead>
                        <tr>
                          <th data-field="id">Week</th>
                          <th data-field="name">Earning</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td id="week1"></td>
                          <td id="earning"></td>
						</tr>
						<tr>
						  <td id="week2"></td>
                          <td id="earning1"></td>
						</tr>
						<tr>
						  <td id="week3"></td>
                          <td id="earning2"></td>
						</tr>
						<tr>
						  <td id="week4"></td>
                          <td id="earning3"></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
               </div>
              <div class="modal-footer">
                <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat ">Close</a>
              </div>
            </div>
  @endsection
  @section('scripts')
      <!-- morris -->
    <script type="text/javascript" src="{{ url('vendors/raphael/raphael-min.js') }}"></script>
    <script type="text/javascript" src="{{ url('vendors/morris-chart/morris.min.js') }}"></script>
      <!--jvectormap-->
    <script type="text/javascript" src="{{ url('vendors/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('vendors/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
	<script type="text/javascript" src="{{ url('js/scripts/dashboard-ecommerce.js')}}"></script>
	<script src="{{ url('/assets/js/supe_admin_dashboard.js') }}"></script>
	<script src="{{ url('/assets/js/push_ui.js') }}"></script>
  @endsection