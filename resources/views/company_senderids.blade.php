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
                    
                    <li class="active">Sender IDS</li>
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
				  <div id="striped-table">
					<div class="row">
					  <div class="col s12">

						   <div class="pull-right">
							  <a href="{{url('/sms/senderID')}}" class="btn btn-default addfilter" style="margin-right:10px;"><i class="fa fa-plus"></i> Request Sender ID</a>
						   </div>
					  </div>
					  <div class="col s12">
						<table class="striped responsive-table" id="dataTable7">
						  <thead>
							<tr>
							  <th>Name</th>
						      <th>Description</th>
							  <th>Credits Paid</th>
							  <th>Authorisation Document</th>
							  <th>Purchase Date</th>
							  <th>Status</th>
							  <th>Action</th>
							</tr>
						  </thead>
						  <tbody id="msg-history" class="search-results">
						    @if (isset($payments) && count($payments) > 0)
							@foreach($payments as $payment)
								<tr>
								<td>{{ $payment->sender_id }}</td>
								<td>
							       @if(strlen($payment->usage) > 40)
									
										<p>{{substr($payment->usage,0,40)}}<a class="read-more-show hide" href="#">...</a> <span class="read-more-content">{{substr($payment->usage,40,strlen($payment->usage))}} <a class="read-more-hide hide" href="#"> <i class="material-icons right">arrow_drop_down</i></a></span></p>
									@else
									{{$payment->usage}}
									@endif
								</td>
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
								@if($payment->step == 4 && $payment->verified==0)
								Processing
								@else
								Pending
								@endif
								</td>
								<td >
							   @if($payment->step == 4)
								-
								@else
								<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Complete Payment" href="{{url('/sms/senderID/'.$payment->id)}}" style="margin-right:3px;"><i class="fa fa-check" aria-hidden="true"></i></a>
								@endif
								</td>
								</tr>
								@endforeach
						  @else
							 <tr>
								<td colspan="7" style="text-align:center;">You do not have sender ids</td>
							 </tr>						 
						  @endif
						  </tbody>
						</table>
					  </div>
					  @if (isset($payments) && count($payments) > 0)
					  <div class="col s12">
						<div class="center">
							  <button class="btn btn-default" id="load-more" style="width: 30%;">Load more</button>
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
		
    @endsection
@section('scripts')
<script type="text/javascript">
  var URL = '{{ url('/') }}';
  var csrf = "{{ csrf_token() }}";
  var paymentemail = "{{ Auth::user()->email }}";
</script>

<script src="{{ url('/assets/js/sender_ids.js') }}"></script>
@endsection