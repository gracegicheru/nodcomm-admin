	@extends('layouts.new_master')
	@section('styles')
	<link rel="stylesheet" href="{{ url('assets/css/paymentstyles.css')}}">
	<link rel="stylesheet" href="{{ url('assets/css/custom-styles.css')}}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
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
                  <h5 class="breadcrumbs-title">Sender ID</h5>
                  <ol class="breadcrumbs">
                    <li><a href="/">Dashboard</a></li>
                    <li class="active">Sender ID</li>
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
			@if (isset($payment) && empty($payment->amount))
			 <div class="col s4">
			 		<div class="card-panel">
					<h4 class="header2">Buy {{$sender_id}} Sender ID </h4>
                    <div class="row" style="padding:10px;">
					 <form role="form" method="post" action="<?php echo URL::route('sender_id_file') ?>" id="sender_id_file_form">
						   {{ csrf_field() }}
						   <div class="text-center" style=" max-width: 335px;">
                               <span class="help-block" style=" color: #000 !important;">Download the authorization document below, sign and stamp it</span>
								<div class="collapsible-header active2" style="
								   border: 1px solid #eee;
								   padding: 10px;
								   border-radius: 4px;
								   margin-top: 10px;
										   "><i class="material-icons">file_download</i><span style="/* line-height: 48px; */display: inline-block;/* margin-top: -10px; */"><a href="{{ url('/downloadPDF') }}">Authorization Document</a></span></div><div class="collapsible-header2 active2" style="
								   border: 1px solid #eee;
								   padding: 10px;
								   border-radius: 4px;
								   margin-top: 10px;
								   margin-top: 44px;
								   ">
								   <div>Upload a signed and stamped copy of the authorization document</div>
								<div style="text-align: center;margin: 20px 0 10px;">
								<a id="image1" class="waves-effect waves-light  btn" >
								<input  type="image"  src="{{ url('images/upload.png') }}" width="15px" height="20px" /> Upload 
								</a>
								<input type="file" name="file" id="file" style="display: none;">
								 <p id="file-name"></p>
								</div>

								</div><div style="
								   text-align: center;
								   margin-top: 14px;
								">The cost of the Sender ID is KSh {{$cost}}</div>


								</div>

							<div class="row">
								<div id="btn1" class="input-field col s12">
								  <button  class="btn cyan waves-effect waves-light left" type="submit" id="submitRequest">Request
									<i class="material-icons left">send</i>
								  </button>
								</div>
							</div>
						  </form>
						  </div>
						  </div>
							<div class="payment-option-btn hide"  style="text-align: center;">
										<form role="form" method="post" action="<?php echo URL::route('sender_id_payment') ?>" id="sender_id_payment_form">
											
									      <script
									        src="https://api.mambowallet.com/static/js/wallet.pay.checkout.1.0.js?v=ht56"
									        data-class="wallet-button"
									        data-key="wallet_Os07qIC8uafJdgKqOs07qIC8uafJdgKq"
									        data-amount="{{$cost}}"
									        data-name="Sender ID Payment"
									        data-description="Sms credit top up"
									        data-image="{{ url('/images/Nodcomm.png') }}"
									        data-locale="auto"
									        data-mobile=""
									        data-currency="KES"
									        data-email='{{Auth::user()->email}}'
											data-ref='<?php echo time() ?>'
									        data-label='Pay With Card'
									        data-zip="true">
									      </script>
									    </form>
									</div>
                            <div id="btn2" style="text-align: center;display: none;" >
                                <button style="width:80%; border-radius:50px;" type="reset"  class="btn  btn-success black-send btn-lg bounceIn round animation-delay2" id="reSubmitRequest">Request Again</button>
                            </div>
             </div>
			 
			 <div class="col s8">
					<div class="card-panel">
					<h4 class="header2">My Sender ID Payment</h4>
                    <div class="row">
					<div class="col s12">
						<table id="data-table-simple" class="responsive-table display" cellspacing="0">
						  <thead>
							<tr>
							  <th>Sender ID</th>
							  <!--<th>Transaction ID</th>-->
							  <th>Amount Paid</th>
							  <th>Authorisation Document</th>
							  <th>Purchase Date</th>
							</tr>
						  </thead>
						  <tfoot>
							<tr>
							  <th>Sender ID</th>
							  <!--<th>Transaction ID</th>-->
							  <th>Amount Paid</th>
							  <th>Authorisation Document</th>
							  <th>Purchase Date</th>
							</tr>
						  </tfoot>
						  <tbody>
				@if (isset($payment))
					
					
						<tr>
					    <td>{{ $payment->sender_id }}</td>
						<!--<td>{{ $payment->reference }}</td>-->
						<td>{{ $payment->currency }} {{ $payment->amount }}</td>
						<td>
						@if(!empty($payment->authoriation_document))
						<a target="_blank" class="" href="{{ url('authoriation_documents/'.$payment->authoriation_document) }}" style="margin-bottom: 30px;"><i class="material-icons">file_download</i> Authorisation Document</a>
						@else
							-
						@endif
						</td>
						<td>{{ $payment->created_at }}</td>
						</tr>
						
					  

					@endif
						  </tbody>
						</table>
					  </div>
                    </div>
                  </div>
			 </div>
			 @else
				<div class="col s12">
					<div class="card-panel">
					<h4 class="header2">My Sender ID Payment</h4>
                    <div class="row">
					<div class="col s12">
						<table id="data-table-simple" class="responsive-table display" cellspacing="0">
						  <thead>
							<tr>
							  <th>Sender ID</th>
							  <!--<th>Transaction ID</th>-->
							  <th>Amount Paid</th>
							  <th>Authorisation Document</th>
							  <th>Purchase Date</th>
							</tr>
						  </thead>
						  <tfoot>
							<tr>
							  <th>Sender ID</th>
							  <!--<th>Transaction ID</th>-->
							  <th>Amount Paid</th>
							  <th>Authorisation Document</th>
							  <th>Purchase Date</th>
							</tr>
						  </tfoot>
						  <tbody>
				@if (isset($payment))
					
					
						<tr>
					    <td>{{ $payment->sender_id }}</td>
						<!--<td>{{ $payment->reference }}</td>-->
						<td>{{ $payment->currency }} {{ $payment->amount }}</td>
						<td>
						@if(!empty($payment->authoriation_document))
						<a target="_blank" class="" href="{{ url('authoriation_documents/'.$payment->authoriation_document) }}" style="margin-bottom: 30px;"><i class="material-icons">file_download</i> Authorisation Document</a>
						@else
							-
						@endif
						</td>
						<td>{{ $payment->created_at }}</td>
						</tr>
						
					  

					@endif
						  </tbody>
						</table>
					  </div>
                    </div>
                  </div>
			 </div>	 
			 
			 @endif
			 </div>
			 </div>
            
          </div>
          <!--end container-->
        </section>
        <!-- END CONTENT -->
    @endsection
	@section('scripts')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
	<script src="{{ url('/assets/js/sender_id.js') }}"></script>
	@endsection
