	@extends('layouts.new_master1')
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
                  <h5 class="breadcrumbs-title">SMS History</h5>
                  <ol class="breadcrumbs">
                    <li><a href="/">Dashboard</a></li>
                    
                    <li class="active">SMS History</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <!--breadcrumbs end-->
          <!--start container-->
          <div class="container"  style="margin-left: 248px; padding-right: 247px; margin-top:-108px;">
            <div class="section">
			  <div class="row filter-wrapper" style="display:none;">
					<div class="card-panel">
					    <form role="form" method="post" action="<?php echo URL::route('apply_company_filters') ?>" id="ApplyCompanyfilterform">
						{{ csrf_field() }}
						<div class="row" >
						  <h4 class="header2">Add a filter</h4>
						    <div class="pull-right">
								<span class="fa fa-times close-filters" style="cursor:pointer;"></span>
							</div>
						</div>
						  <div class="row" style="margin-right: -10px;margin-left: -10px;">
									<div class="col s12 m4 l4">

								  <label>From</label>
									<div class="input-group date">
									  <div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									  </div>
									  <input type="text" class="form-control pull-right" id="datepicker" name="datepicker" value="<?php
									  echo $date;?>"/>
									 </div>
							</div>
							<div class="col s12 m4 l4">
								<label>To:</label>

								<div class="input-group date">
								  <div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								  </div>
								  <input type="text" class="form-control pull-right" id="datepicker1" name="datepicker1" value="<?php
								  echo $date;?>">
								</div>
							</div>
							<div class="col s12 m4 l4">
							  <label for="status-filter">Status</label>
								<div style="margin-top:21px">
								  <select name="statusfilter" id="status-filter">
										<option value="sent">Sent</option>
										<option value="fail">Failed</option>
								  </select>
								  </div>

							</div>
							<div class="loading-overlay loading-filters"></div>
							</div>
							<div class="row" style="margin-right: -10px;margin-left: -10px;margin-top: 20px;">
							<div class="col-md-12">
							  <div class="clearfix">
								<div class="pull-right">
								  <button class="btn btn-primary" id="apply-filter"><i class="fa fa-check"></i> Apply Filters</button>
								</div>
							  </div>
							</div>
						  </div>
						  </form>
						</div>
				  </div>
				<div id="striped-table"  class="card card card-default scrollspy" style="margin-top: 15px; margin-right: 15px; margin-left: 15px; margin-bottom:15px;">
					<div class="card-content">
              <div class="row">
                <div class="col s12">
				  <div id="striped-table">
					<h4 class="header">SMS History</h4>
					<div class="row">
					<div class="col s12 search">
						<form role="form" method="post" action="<?php echo URL::route('search_sms') ?>" id="searchSMSForm1">
							{{ csrf_field() }}
							<input type="text" name="search" class="header-search-input z-depth-2" placeholder="Search SMS by number"/><button class="btn btn-default " style="margin-right:10px;" id="sms-search-term1"> Search sms</button>
						</form>
					</div>

					  <div class="col s12">

						   <div class="pull-right">
							  <button class="btn btn-default addfilter" style="margin-right:10px;"><i class="fa fa-plus"></i> Add Filters</button>
						   </div>
					  </div>
					  <div class="col s12">
						<table class="striped responsive-table" id="dataTable7" style="margin-top: 25px; margin-right: -10px; margin-left: 5px; margin-bottom: 50px;">
						  <thead>
							<tr id="messages" style= "background-color: #ff6f00; ">
							  <th>Date</th>
							  <th>Message</th>
							  <th>To</th>
							  <th>Status</th>
								<th></th>
							</tr>
						  </thead>
						  <tbody id="msg-history" class="search-results" >

						  @foreach($messages as $message)
							  <tr>
								  <td>{{$message->created_at}}</td>
								  <td>{{$message->message}}</td>
								  <td>{{$message->phone}}</td>
								  <td>{{$message->status}}</td>
								  <td><a style="text-decoration: underline" href="/showDetails/{{$message->id}}">details</a></td>

							  </tr>
							  @endforeach
						  </tbody>
						</table>
						  <div style="text-decoration-color: blue">   {{ $messages->links() }} </div>

					  </div>
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


	<div class="container"  style="margin-left: 248px; padding-right: 247px; margin-top:20px;">

	<div class="row">
		<div class="col s12">
			<div class="card">
				<div class="card-content">
					<h4 class="header">SMS History
					</h4>
					<div class="row">
						<div class="col s12">
							<table id="data-table-simple" class="display nowrap">
								<thead>
								<tr>
									<th>First name</th>
									<th>Last name</th>
									<th>Position</th>
									<th>Office</th>
									<th>Age</th>
									<th>Start date</th>
									<th>Salary</th>
									<th>Extn.</th>
									<th>E-mail</th>

								</tr>
								</thead>
								<tbody>

								<tr>
									<td>Tiger</td>
									<td>Nixon</td>
									<td>System Architect</td>
									<td>Edinburgh</td>
									<td>61</td>
									<td>2011/04/25</td>
									<td>$320,800</td>
									<td>5421</td>
									<td>t.nixon@datatables.net</td>

								</tr>




								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>




	@endsection
@section('scripts')
<script type="text/javascript">
  var URL = '{{ url('/') }}';
  var csrf = "{{ csrf_token() }}";
  var paymentemail = "{{ Auth::user()->email }}";
</script>

<script type="text/javascript">
   $('#datepicker').pickadate({
    selectMonths: true, // Creates a dropdown to control month
    selectYears: 15, // Creates a dropdown of 15 years to control year,
    today: 'Today',
    clear: 'Clear',
    close: 'Ok',
    closeOnSelect: false ,// Close upon selecting a date,
    format: 'yyyy-mm-dd',
    formatSubmit: 'yyyy-mm-dd'
  });
   $('#datepicker1').pickadate({
    selectMonths: true, // Creates a dropdown to control month
    selectYears: 15, // Creates a dropdown of 15 years to control year,
    today: 'Today',
    clear: 'Clear',
    close: 'Ok',
    closeOnSelect: false ,// Close upon selecting a date,
    format: 'yyyy-mm-dd',
    formatSubmit: 'yyyy-mm-dd'
  });
</script>
<script src="../../../app-assets/js/vendors.min.js" type="text/javascript"></script>
<script src="../../../app-assets/vendors/data-tables/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="../../../app-assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js" type="text/javascript"></script>
<script src="../../../app-assets/vendors/data-tables/js/dataTables.select.min.js" type="text/javascript"></script>
<!-- END PAGE VENDOR JS-->
<!-- BEGIN THEME  JS-->
<script src="../../../app-assets/js/plugins.js" type="text/javascript"></script>
<script src="../../../app-assets/js/custom/custom-script.js" type="text/javascript"></script>
<!-- END THEME  JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script src="../../../app-assets/js/scripts/data-tables.js" type="text/javascript"></script>

<script src="{{ url('/assets/js/messages.js') }}"></script>
@endsection