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
                    <li class="active">Sender IDs</li>
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
                <div class="row">
					<form role="form" method="post"  id="Verifysenderidform">
						{{ csrf_field() }}
					  <div class="col s12">
						<table class="striped responsive-table">
						  <thead>
							<tr>
							  <th>Sender ID</th>
							  <th>Company</th>
							  <th>Amount Paid</th>
							  <th>Authorisation Document</th>
							  <th>Purchase Date</th>
							  <th>Verified</th>
							  <th>Action</th>
							</tr>
						  </thead>
						 <tbody id="msg-history1" class="search-results">
				@if (isset($payments) && count($payments) > 0)
					
					@foreach($payments as $payment)
						<tr>
					    <td>{{ $payment->sender_id }}</td>
						<td>{{ $payment->company }}</td>
						<td>
							{{ $payment->credit }}
						</td>
						<td>
						@if(!empty($payment->authoriation_document))
						<a target="_blank" class="" href="{{ url('authoriation_documents/'.$payment->authoriation_document) }}" style="margin-bottom: 30px;"><i class="material-icons">file_download</i> Authorisation Document</a>
						@else
							-
						@endif
						</td>
						<td>{{ $payment->created_at }}</td>
						<td>
						@if($payment->verified==0)
							Unverified
						@else
							Verified
						@endif
						</td>
						<td style="width:20%">
							<a style="margin-right:3px;" class="waves-effect waves-light btn tooltipped modal-trigger" href="#modal1" data-position="top" data-delay="50" data-tooltip="Payment Details" onclick="return transaction('{{ $payment->sender_id }}','{{$payment->user->name }}','{{$payment->company }}','{{ $payment->currency }}','{{ $payment->amount }}','{{$payment->authoriation_document}}','{{ $payment->created_at }}','{{ $payment->reference}}','{{$payment->type}}','{{ $payment->card}}','{{ $payment->card_id }}','{{ $payment->charge }}')"><i class="fa fa-eye"></i></a>
							<?php if($payment->verified == 1) { ?>
							<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Unverify" onclick="unverify({{ $payment->id }})" id="unverifybtn{{ $payment->id }}" style="margin-right:3px;"><i class="fa fa-times" aria-hidden="true"></i></a>
							<?php }else{ ?>
							<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Verify" onclick="verify({{ $payment->id }})"  id="verifybtn{{ $payment->id }}" style="margin-right:3px;"><i class="fa fa-check" aria-hidden="true"></i></a>
							<?php } ?>
						</td>
						</tr>
						@endforeach
					  @else
						<tr>
						  <td colspan="7" style="text-align:center;">No sender ids</td>
						</tr>	

					@endif
						  </tbody>
						</table>
					  </div>
					  </form>
					   @if (isset($payments) && count($payments) > 0)
					  <div class="col s12">
						<div class="center">
							  <button class="btn btn-default" id="load-more1" style="width: 30%;">Load more</button>
						</div>
					  </div>
					  @endif
					</div>
				  </div>
                </div>

              </div>
          


            </div>

          </div>
          <!--end container-->
        </section>
        <!-- END CONTENT -->
				<div id="modal1" class="modal">
              <div class="modal-content">
                <h4>Transaction Details</h4>
				    <div class="card-panel">
                    <div class="row">
						<div class="col s6">
						<p> Sender ID</p>
						</div>
						<div class="col s6">
						<p id="sender_id"></p>
						</div>
                    </div>
				    <div class="row">
						<div class="col s6">
						<p> Username</p>
						</div>
						<div class="col s6">
						<p id="name"></p>
						</div>
                    </div>
					<div class="row">
						<div class="col s6">
						<p> Company</p>
						</div>
						<div class="col s6">
						<p id="company"></p>
						</div>
                    </div>
				    <div class="row">
						<div class="col s6">
						<p> Amount Paid</p>
						</div>
						<div class="col s6">
						<p id="amount"></p>
						</div>
                    </div>
					<div class="row">
						<div class="col s6">
						<p>Authoriation Document</p>
						</div>
						<div class="col s6">
						<p id="authoriation_document"></p>
						</div>
                    </div>
				    <div class="row">
						<div class="col s6">
						<p> Purchase Date</p>
						</div>
						<div class="col s6">
						<p id="created_at"></p>
						</div>
                    </div>
					<div class="row">
						<div class="col s6">
						<p> Transaction ID</p>
						</div>
						<div class="col s6">
						<p id="reference"></p>
						</div>
                    </div>
				    <div class="row">
						<div class="col s6">
						<p> Card</p>
						</div>
						<div class="col s6">
						<p id="card"></p>
						</div>
                    </div>
					<div class="row">
						<div class="col s6">
						<p> Card ID</p>
						</div>
						<div class="col s6">
						<p id="card_id"></p>
						</div>
                    </div>
				    <div class="row">
						<div class="col s6">
						<p>Charges</p>
						</div>
						<div class="col s6">
						<p id="charge"></p>
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
<script src="{{ url('/assets/js/sender_ids.js') }}"></script>
@endsection