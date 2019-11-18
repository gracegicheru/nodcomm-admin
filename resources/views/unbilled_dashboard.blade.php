
@extends('layouts.unbilledmaster')

@section('content')
  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper" style="font-weight:normal">

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Main row -->
      <div class="row">

        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-12 connectedSortable">
			<div class="box box-primary">
			   <div class="box-body">
			    <form role="form" method="post" action="<?php echo URL::route('extend_trial_days') ?>" id="extend_trial_daysform">
				{{ csrf_field() }}
				<div class="form-group" id="errors"></div>
				<div class="form-group" style="padding:50px;border-style: solid; border-color: coral;">
				 @if (Auth::user()->admin)
				   <h4 style="line-height:30px;"><strong>We're sorry, your free trial has expired. If you would like to continue using Nodcomm services, please <a  href="#">Click Here</a> to subscribe to the services </strong></h4>
				   <p>If you need more time to evaluate the products, you can  <a   id="extend_trial_days" style="cursor:pointer;">Extend Your Trial</a> by {{$days}} days </p>
				 @else
				   <h4 style="line-height:30px;"><strong>We're sorry, you cannot access our services. Please contact your administrator</strong></h4>

				 @endif
				<div>
				</div>
				</div>
				</form>
	   </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@if (Auth::user()->admin)
    <!-- Modal -->
<div id="billingModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center" ><b>Notice</b></h4>
      </div>
      <div class="modal-body">
        
			<div class="row main">
			<section class="col-lg-6 connectedSortable">
			<div>
			<img src="{{ url('/images/expired.jpg') }}" width="50%" height="50%">
			</div>
			</section>
			<section class="col-lg-6 connectedSortable">
			<h5><strong>Your free trial has expired. Buy Now using the Paypal Checkout below</span></h5>
		      <!-- form start -->
			<form role="form" method="post" action="<?php echo URL::route('payment') ?>" id="paymentform">
				{{ csrf_field() }}
				<a id="paypal-button"></a>
			</form>
			</section>
			</div>
			<div class="row main">
			<section class="col-lg-12 connectedSortable">
			<h5><strong>If you want to extend the trial period, Please contact </strong><span style="color:blue;">info@nodcomm.com</span></h5>
			</section>
			</div>
		
		
      </div>

    </div>

  </div>
</div>
@endif
@endsection
@section('scripts')
<script>
var amount="<?php echo $amount; ?>";
var env= "<?php echo $paypal_mode; ?>";
var paypal_client_ID="<?php echo $paypal_client_ID; ?>";
var csrf_token = '{{ csrf_token() }}';

</script>
<script src="/assets/js/billing_modal.js"></script>
<script src="/assets/js/trial_days.js"></script>
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script src="/assets/js/paypal.js"></script>
@endsection