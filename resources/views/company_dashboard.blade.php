@extends('layouts.new_master')
@section('styles')
<style>
header .brand-logo img {
    height: 50px!important;
}
header .brand-logo {
    padding: 5px 20px!important;
}
</style>
@endsection('styles')
@section('content')
 <!-- START CONTENT -->
        <section id="content">
          <!--start container-->
          <div class="container">
            <!--card stats start-->
            <div id="card-stats">
              <div class="row">
                <div class="col s12 m6 l3">
                  <div class="card gradient-45deg-light-blue-cyan gradient-shadow min-height-100 white-text">
                    <div class="padding-4">
                      <div class="col s7 m7">
                        <i class="material-icons background-round mt-5">monetization_on</i>
                        <p>SMS Credit</p>
                      </div>
                      <div class="col s5 m5 right-align">
                        <h5 class="mb-0" id="credit">{{$credit}}</h5>
                        <p class="no-margin"></p>
                        <p></p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col s12 m6 l3">
                  <div class="card gradient-45deg-red-pink gradient-shadow min-height-100 white-text">
                    <div class="padding-4">
                      <div class="col s7 m7">
                        <i class="material-icons background-round mt-5">perm_identity</i>
                        <p>Visitors</p>
                      </div>
                      <div class="col s5 m5 right-align">
                        <h5 class="mb-0"id="newvisitors" ></h5>
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
                        <i class="material-icons background-round mt-5">perm_identity</i>
                        <p><a style="color:#ffffff" href="{{ url('/users') }}">Users</a></p>
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
                        <p>Messages</p>
                      </div>
                      <div class="col s5 m5 right-align">
                        <h5 class="mb-0" id="newmessages" ></h5>
                        <p class="no-margin">New</p>
                        <p id="messages" ></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--card stats end-->
            <!--yearly & weekly revenue chart start-->
            <div id="sales-chart">
              <div class="row">
                <div class="col s12 m8 l8">
                    <div class="card-content  teal">
                      <a class="btn-floating btn-move-up waves-effect waves-light red accent-2 z-depth-4 right">
                        <i class="material-icons activator">done</i>
                      </a>
                      <div class="line-chart-wrapper">
                        <p class="margin white-text">Credit Buying</p>
                        <canvas id="line-chart" height="114"></canvas>
                      </div>
                    </div>
                </div>
                <div class="col s12 m4 l4">
					<p class=" text-lighten-4">SMS payment amount per month in KES</p>
					<div id="polar-chart-holder">
					  <canvas id="polar-chart-country" width="200"></canvas>
					</div>
                </div>
              </div>
            </div>
            <!--yearly & weekly revenue chart end-->
              <!-- ecommerce offers start-->
              <div id="ecommerce-offer">
                <div class="row">
                  <div class="col s12 m3">
                    <div class="card gradient-shadow gradient-45deg-light-blue-cyan border-radius-3">
                      <div class="card-content center">
                        <img src="../../images/icon/apple-watch.png" class="width-40 border-round z-depth-5">
                        <h5 class="white-text lighten-4" id="push_sites"></h5>
                        <p class="white-text lighten-4">Push Notification Websites</p>
                      </div>
                    </div>
                  </div>
                  <div class="col s12 m3">
                    <div class="card gradient-shadow gradient-45deg-red-pink border-radius-3">
                      <div class="card-content center">
                        <img src="../../images/icon/printer.png" class="width-40 border-round z-depth-5">
                        <h5 class="white-text lighten-4" id="Pushnotification"></h5>
                        <p class="white-text lighten-4">Push Notifications Sent</p>
                      </div>
                    </div>
                  </div>
                  <div class="col s12 m3">
                    <div class="card gradient-shadow gradient-45deg-amber-amber border-radius-3">
                      <div class="card-content center">
                        <img src="../../images/icon/laptop.png" class="width-40 border-round z-depth-5">
                        <h5 class="white-text lighten-4" id="chat_sites"></h5>
                        <p class="white-text lighten-4">Chat Websites</p>
                      </div>
                    </div>
                  </div>
                  <div class="col s12 m3">
                    <div class="card gradient-shadow gradient-45deg-green-teal border-radius-3">
                      <div class="card-content center">
                        <img src="../../images/icon/bowling.png" class="width-40 border-round z-depth-5">
                        <h5 class="white-text lighten-4" id="departments"></h5>
                        <p class="white-text lighten-4">Departments</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- ecommerce offers end-->
              <!-- //////////////////////////////////////////////////////////////////////////// -->
              <div id="sales-chart1">
              <div class="row">
                <div class="col s12 m8 l8">
                    <div class="card-content  teal">
                      <a class="btn-floating btn-move-up waves-effect waves-light red accent-2 z-depth-4 right">
                        <i class="material-icons activator">done</i>
                      </a>
                      <div class="line-chart-wrapper">
                        <p class="margin white-text">Visitors</p>
                        <canvas id="visitors_graph" height="114"></canvas>
                      </div>
                    </div>
                </div>
                <div class="col s12 m4 l4">
					<p class=" text-lighten-4">SMS credit usage per month</p>
					<div id="polar-chart-holder">
					  <canvas id="polar-chart-credit" width="200"></canvas>
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
			
			</div>
            <!--end container-->
        </section>

	 @endsection
  @section('scripts')
	
	<script type="text/javascript">
		var company_id = '{{ Auth::user()->company_id }}';
	</script>
	<script src="/assets/js/admin_dashboard.js"></script>
@endsection