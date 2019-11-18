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

				<div class="col s12">
					<div class="card-panel">
					<h4 class="header2">My Sender ID Payment</h4>
					@if(Session::has('debugMsg'))
					{{Session::get('debugMsg')}}
					@endif
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
						<td>
						@if(!empty($payment->amount))
						{{ $payment->currency }} {{ $payment->amount }}
						@else
							-
						@endif
						</td>
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
