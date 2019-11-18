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
                  <h5 class="breadcrumbs-title">SMS Credits</h5>
                  <ol class="breadcrumbs">
                    <li><a href="/">Dashboard</a></li>
                    <li class="active">SMS Credits</li>
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
                <div class="col s12">
              <!--DataTables example-->
              <div id="table-datatables">
                <h4 class="header">SMS Credits</h4>
                <div class="row">
					  <div class="col s12">
						<table id="data-table-simple" class="responsive-table display" cellspacing="0">
						  <thead>
							<tr>
							  <th>#</th>
							  <th>Username</th>
							  <th>Email</th>
							  <th>Company</th>
							  <th>Credits</th>
							  <th>Recharge Date</th>
							  <th>Action</th>
							</tr>
						  </thead>
						  <tfoot>
							<tr>
							  <th>#</th>
							  <th>Username</th>
							  <th>Email</th>
							  <th>Company</th>
							  <th>Credit</th>
							  <th>Recharge Date</th>
							  <th>Action</th>
							</tr>
						  </tfoot>
						  <tbody>
				@if (isset($credits) && count($credits) > 0)
					
					@foreach($credits as $credit)
						<tr>
						<td>{{ $loop->iteration }}</td>
						<td>{{ $credit->user->name }}</td>
						<td>{{ $credit->user->email }}</td>
						<td>{{ $credit->company }}</td>
						<td>{{ $credit->credit }}</td>
						<td>{{ $credit->updated_at }}</td>
						<td>
							<?php 
								$url='/credit/'.$credit->user_id;
							
							?>
							<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="View User Payments" href="<?php echo url($url);?>" class="btn btn-xs btn-info"> <i class="fa fa-eye" aria-hidden="true"></i></a>	
							
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