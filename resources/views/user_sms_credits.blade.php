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
                  <h5 class="breadcrumbs-title">{{$user->name}} Credit Payments History</h5>
                  <ol class="breadcrumbs">
                    <li><a href="index.html">Dashboard</a></li>
                    <li><a href="#">Payment History</a></li>
                    <li class="active">Payment History</li>
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
                <h4 class="header">Payment History</h4>
                <div class="row">
					  <div class="col s12">
						<table id="data-table-simple" class="responsive-table display" cellspacing="0">
						  <thead>
							<tr>
							  <th>Transaction ID</th>
							  <th>Amount Paid</th>
							  <th>Charges</th>
							  <th>Credit</th>
							  <th>Card</th>
							  <th>Card ID</th>
							  <th>Card Type</th>
							  <th>Payment Date</th>
							</tr>
						  </thead>
						  <tfoot>
							<tr>
							  <th>Transaction ID</th>
							  <th>Amount Paid</th>
							  <th>Charges</th>
							  <th>Credit</th>
							  <th>Card</th>
							  <th>Card ID</th>
							  <th>Card Type</th>
							  <th>Payment Date</th>
							</tr>
						  </tfoot>
						  <tbody>
							@if (isset($payments) && count($payments) > 0)
								
								@foreach($payments as $payment)
									<tr>
									<td>{{ $payment->reference }}</td>
									<td>{{ $payment->currency }} {{ $payment->amount }}</td>
									<td>{{ $payment->currency }} {{ $payment->charge }}</td>
									<td>{{ $payment->credit }}</td>
									<td>{{ $payment->card }}</td>
									<td>{{ $payment->card_id }}</td>
									<td>{{ $payment->type }}</td>
									<td>{{ $payment->created_at }}</td>
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