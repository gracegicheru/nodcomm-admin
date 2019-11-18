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
                  <ol class="breadcrumbs">
                    <li><a href="/">Dashboard</a></li>
                    <li class="active">Purchase Credits</li>
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
				    <div class="card-panel">
					
                    <div class="row">
					 <div class="col m4">
					   <div class="card-panel" style="text-align: center;">
						<h5 style="text-align: center;margin-bottom: 40px;">Pay By Card or MPESA</h5>
						<div class="payment-option-btn">
										<form role="form" method="post" action="<?php echo URL::route('smspayment') ?>" id="smspaymentform">
											
									      <script
											id="paymentscript"
									        src="https://api.mambowallet.com/static/js/wallet.pay.checkout.1.0.js?v=ht56"
									        data-class="wallet-button"
									        data-key="wallet_Os07qIC8uafJdgKqOs07qIC8uafJdgKq"
									        data-amount="{{$amount}}"
									        data-name="SMS Credit"
									        data-description="Sms credit top up"
									        data-image="{{ url('/images/Nodcomm.png') }}"
									        data-locale="auto"
									        data-mobile=""
									        data-currency="KES"
									        data-email='{{Auth::user()->email}}'
											data-ref='<?php echo time() ?>'
									        data-label='Pay Now'
									        data-zip="true">
									      </script>
									    </form>
						</div>
					   </div>
					</div>
				   <div class="col m4">
					   <div class="card-panel" style="
				   text-align: center;
				">
				   <h5 style="
				   text-align: center;
				   margin-bottom: 40px;
				">Pay By Paypal</h5>
				   <div id="paypal-button1"></div>
				</div>
				   </div>
	   <div class="col m4"></div>

                    </div>
                  </div>
                </div>
				<div class="col s12">
				
					<div class="card-panel">
					<h4 class="header2">My Payment History</h4>
                    <div class="row">
					<div class="col s12">
						<table id="data-table-simple" class="responsive-table display" cellspacing="0">
						  <thead>
							<tr>
							  <th>Transaction ID</th>
							  <th>Amount Paid</th>
							  <th>Credit</th>
							  <th>Payment Method</th>
							  <th>Date</th>
							</tr>
						  </thead>
						  <tfoot>
							<tr>
							  <th>Transaction ID</th>
							  <th>Amount Paid</th>
							  <th>Credit</th>
							  <th>Payment Method</th>
							  <th>Date</th>
							</tr>
						  </tfoot>
						  <tbody>
				@if (isset($payments) && count($payments) > 0)
					
					@foreach($payments as $payment)
						<tr>
						<td>{{ $payment['reference'] }}</td>
						<td>{{ $payment['currency'] }} {{ $payment['amount'] }}</td>
						<td>{{ $payment['credit'] }}</td>
						<td>{{ $payment['method'] }}</td>
						<td>{{ $payment['created_at'] }}</td>
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
<script type="text/javascript">
  var URL = '{{ url('/') }}';
  var csrf = "{{ csrf_token() }}";
  var paymentemail = "{{ Auth::user()->email }}";
  var paypalamount="{{Session::get('amount_payed')/100}}";
  var env= "<?php echo $paypal_mode; ?>";
  var paypal_client_ID="<?php echo $paypal_client_ID; ?>";
  var csrf_token = "{{ csrf_token() }}";
</script>
<script src="{{ url('/assets/js/messages.js') }}"></script>
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script src="{{ url('/assets/js/paypal1.js') }}"></script>
@endsection