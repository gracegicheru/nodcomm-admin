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
                  <div class="card">
                    <div class="card-content cyan white-text">
                      <p class="card-stats-title">
                        <i class="material-icons">message</i> SMS Sent</p>
                      <h4 class="card-stats-number" id="newsmssent">566</h4>
                      <p class="card-stats-compare" id="smssentpercentage">
                        <i class="material-icons">keyboard_arrow_up</i> 15%
                        <span class="cyan text text-lighten-5">from last month</span>
                      </p>
                    </div>
                    <div class="card-action cyan darken-1">
                      <div id="clients-bar" class="center-align"></div>
                    </div>
                  </div>
                </div>
               <div class="col s12 m6 l3">
                  <div class="card">
                    <div class="card-content red accent-2 white-text">
                      <p class="card-stats-title">
                        <i class="material-icons">monetization_on</i> SMS Credit</p>
                      <h4 class="card-stats-number" id="newcredit"></h4>
                      <p class="card-stats-compare" id="creditpercentage">
                        <i class="material-icons">keyboard_arrow_up</i> 
                        <span class="red-text text-lighten-5">last month</span>
                      </p>
                    </div>
                    <div class="card-action red darken-1">
                      <div id="sales-compositebar" class="center-align"></div>
                    </div>
                  </div>
                </div>
               <div class="col s12 m6 l3">
                  <div class="card">
                    <div class="card-content teal accent-4 white-text">
                      <p class="card-stats-title">
                        <i class="material-icons">trending_up</i> SMS Payment</p>
                      <h4 class="card-stats-number" id="newamount"></h4>
                      <p class="card-stats-compare" id="amountpercentage">
                        <i class="material-icons">keyboard_arrow_up</i> 
                        <span class="teal-text text-lighten-5">last month</span>
                      </p>
                    </div>
                    <div class="card-action teal darken-1">
                      <div id="profit-tristate" class="center-align"></div>
                    </div>
                  </div>
                </div>

                <div class="col s12 m6 l3">
                  <div class="card">
                    <div class="card-content deep-orange accent-2 white-text">
                      <p class="card-stats-title">
                        <i class="material-icons">person_outline</i> New Visitors</p>
                      <h4 class="card-stats-number" id="newvisitors">1806</h4>
                      <p class="card-stats-compare" id="visitorssalespercentage">
                        <i class="material-icons">keyboard_arrow_down</i> 3%
                        <span class="deep-orange-text text-lighten-5">from last month</span>
                      </p>
                    </div>
                    <div class="card-action  deep-orange darken-1">
                      <div id="invoice-line" class="center-align"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--card stats end-->

              <div>
              <div class="row">
                <div class="col s12">
                    <div class="card-content  teal">
                      <a class="btn-floating btn-move-up waves-effect waves-light red accent-2 z-depth-4 right">
                        <i class="material-icons activator">done</i>
                      </a>
                      <div class="line-chart-wrapper">
                        <p class="margin white-text">SMS Sent</p>
                        <canvas id="sent_sms_graph" height="114"></canvas>
                      </div>
                    </div>
                </div>
              </div>
            </div>
			 <!--card stats start-->
            <div id="card-stats">
              <div class="row">
                <div class="col s12 m6 l3">
                  <div class="card">
                    <div class="card-content cyan white-text">
                      <p class="card-stats-title">
                        <i class="material-icons">message</i> Delivered SMS </p>
                      <h4 class="card-stats-number" id="deliveredsms">566</h4>
                      <p class="card-stats-compare" id="deliveredsmspercentage">
                        <i class="material-icons">keyboard_arrow_up</i> 15%
                        <span class="cyan text text-lighten-5">from last month</span>
                      </p>
                    </div>
                    <div class="card-action cyan darken-1">
                      <div id="clients-bar" class="center-align"></div>
                    </div>
                  </div>
                </div>
               <div class="col s12 m6 l3">
                  <div class="card">
                    <div class="card-content red accent-2 white-text">
                      <p class="card-stats-title">
                      <i class="material-icons">message</i> Undelivered SMS </p>
                      <h4 class="card-stats-number" id="undeliveredsms"></h4>
                      <p class="card-stats-compare" id="undeliveredsmspercentage">
                        <i class="material-icons">keyboard_arrow_up</i> 
                        <span class="red-text text-lighten-5">last month</span>
                      </p>
                    </div>
                    <div class="card-action red darken-1">
                      <div id="sales-compositebar" class="center-align"></div>
                    </div>
                  </div>
                </div>
               <div class="col s12 m6 l3">
                  <div class="card">
                    <div class="card-content teal accent-4 white-text">
                      <p class="card-stats-title">
                        <i class="material-icons">trending_up</i> Sender ID Payment</p>
                      <h4 class="card-stats-number" id="sender_id_cost"></h4>
                      <p class="card-stats-compare">
                        <i class="material-icons">keyboard_arrow_up</i> 
                        <span class="teal-text text-lighten-5"></span>
                      </p>
                    </div>
                    <div class="card-action teal darken-1">
                      <div id="profit-tristate" class="center-align"></div>
                    </div>
                  </div>
                </div>

                <div class="col s12 m6 l3">
                  <div class="card">
                    <div class="card-content deep-orange accent-2 white-text">
                      <p class="card-stats-title">
                        <i class="material-icons">person_outline</i> Agents</p>
                      <h4 class="card-stats-number" id="agents">111</h4>
                      <p class="card-stats-compare" >
                        <i class="material-icons">keyboard_arrow_down</i>
                        <span class="deep-orange-text text-lighten-5"></span>
                      </p>
                    </div>
                    <div class="card-action  deep-orange darken-1">
                      <div id="invoice-line" class="center-align"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--card stats end-->
			<div class="row" >
			  <div class="col  s12 timesmsform">
					<div class="card-panel">
						<form role="form" method="post" action="<?php echo URL::route('analytics_search_time_sms') ?>" id="ApplySMStimefilterform">
						{{ csrf_field() }}
						<div class="row" >
						  <h4 class="header2">Search SMS by Time</h4>
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
			  <div class=" hide col s12 Timesmstable">
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
			<div class="row" >
			  <div class="col  s12">
			  <div class="card-panel" style="background-color:#383f47;">
				<h4 class="white-text header2">Visitors</h4>
				<p class="grey-text text-lighten-4">A map displaying visitors spread in the world.</p>
				<div id="world-map-markers" style="width:100%!important; height:430px"></div>
			  </div>
			  </div>
			</div>

		</div>
          <!--end container-->
		 

        </section>
        <!-- END CONTENT -->

        @endsection
	  @section('scripts')

    <!--jvectormap-->
    <script type="text/javascript" src="{{ url('vendors/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('vendors/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets/js/vectormap-script.js') }}"></script>
	 <!--card-advanced.js - Page specific JS-->
	<!--<script type="text/javascript" src="{{ url('js/scripts/dashboard-analytics.js') }}"></script>-->
	<script src="{{ url('assets/js/admin_analytics_dashboard.js') }}"></script>
	@endsection