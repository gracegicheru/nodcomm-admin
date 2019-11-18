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
					<!--<h4 class="header2">Purchase  Credit</h4>-->
                    <div class="">
					<form role="form" method="post" action="<?php echo URL::route('paymentamount') ?>" id="paymentamountform">
					{{ csrf_field() }}
					<div class="row2">
					   <div>Select the number of credits to purchase</div>
					  <div class="input-field col2 s122">
					<i class="material-icons prefix2" style="
					   display: none;
					">monetization_on</i>
					<div class="select-wrapper initialized">
					<span class="caret">▼</span>
					 <input type="text" class="select-dropdown" readonly="true" data-activates="select-options-ce007b51-1c8d-d92e-0960-df993d07a777" value="200 credits @KES  200"><ul id="select-options-ce007b51-1c8d-d92e-0960-df993d07a777" class="dropdown-content select-dropdown" style="width: 1023.81px; position: absolute; top: 0px; left: 0px; display: none; opacity: 1;"><li class=""><span>200 credits @KES  200</span></li><li class=""><span>500 credits @KES  500</span></li><li class=""><span>1000 credits @KES  1,000</span></li><li class="active"><span>3000 credits @KES  3,000</span></li><li class=""><span>5000credits @KES  5,000 </span></li><li class=""><span>10000 credits @KES  10,000</span></li><li class=""><span>20000 credits @KES  20,000</span></li></ul>
					 <select name="amount" data-select-id="ce007b51-1c8d-d92e-0960-df993d07a777" class="initialized">
					  <option value="200">200 credits @KES  200</option>
					  <option value="500">500 credits @KES  500</option>
					  <option value="1000">1000 credits @KES  1,000</option>
					  <option value="3000">3000 credits @KES  3,000</option>	
					  <option value="5000">5000credits @KES  5,000 </option>
					  <option value="10000">10000 credits @KES  10,000</option>	
					  <option value="20000">20000 credits @KES  20,000</option>
					</select>
					</div>
					 <label style="display: none;">Select Credits</label>
					 </div>
					</div>

						<div class="row">
                         <div class="row2">
                           <div class="input-field col s12">
                             <button id="paybtn" class="btn cyan waves-effect waves-light left" type="submit" style="">Continue</button>
                           </div>
                         </div>
                       </div>
                      </form>
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
</script>
<script src="{{ url('/assets/js/messages.js') }}"></script>
@endsection