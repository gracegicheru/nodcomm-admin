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
          <div class="container">
            <div class="section">
			  <div class="row filter-wrapper" style="display:none;">
					<div class="card-panel">
						<div class="row" >
						  <h4 class="header2">Add a filter</h4>
						    <div class="pull-right">
								<span class="fa fa-times close-filters" style="cursor:pointer;"></span>
							</div>
						</div>
						  <div class="row" style="margin-right: -10px;margin-left: -10px;">
						  	<div class="col s12 m4 l4">
								  <select name="gatewaysfilter" id="gateways-filter" class="form-control">

								  </select>
								  <label for="gateways-filter">Gateway</label>
							</div>
							<div class="col s12 m4 l4">
								  <select name="sitesfilter" id="sites-filter">

								  </select>
								  <label for="sites-filter">Company</label>
							</div>
							<div class="col s12 m4 l4">
								  <select name="statusfilter" id="status-filter">
										<option value="all">All</option>
										<option value="success">Sent</option>
										<option value="error">Failed</option>
								  </select>
								  <label for="status-filter">Status</label>
							</div>
							<div class="loading-overlay loading-filters"></div>
							</div>
							<div class="row" style="margin-right: -10px;margin-left: -10px;margin-top: 20px;">
							<div class="col-md-12">
							  <div class="clearfix">
								<div class="pull-right">
								  <button class="btn btn-primary apply-filter"><i class="fa fa-check"></i> Apply Filters</button>
								  <button class="btn btn-default clear-filter"><i class="fa fa-times"></i> Clear Filters</button>
								</div>
							  </div>
							</div>
						  </div>
						</div>
				  </div>

              <div class="row">
                <div class="col s12">
				  <div id="striped-table">
					<h4 class="header">SMS History</h4>
					<div class="row">
					<div class="col s12 search">
						<form role="form" method="post" action="<?php echo URL::route('search_sms') ?>" id="searchSMSForm">
							{{ csrf_field() }}
						<input type="text" name="search" class="header-search-input z-depth-2" placeholder="Search SMS by number" id="sms-search-term"/>
						</form>
					</div>
					  <div class="col s12">

						   <div class="pull-right">
							  <button class="btn btn-default addfilter" style="margin-right:10px;"><i class="fa fa-plus"></i> Add Filters</button>
						   </div>
					  </div>
					  <div class="col s12">
						<table class="striped responsive-table" id="dataTable7">
						  <thead>
							<tr>
							  <th>Date</th>
							  <th>Message</th>
							  <th>To</th>
							  <th>Gateway</th>
							  <th>Company</th>
							  <th>Status</th>
							</tr>
						  </thead>
						  <tbody id="msg-history" class="search-results">
                     @if(!$messages->isEmpty())
					 @foreach($messages as $message)
                        <tr>
                          <td>{{ $message->created_at }}</td>
						  <td>

							   @if(strlen($message->message) > 40)

									<p>{{substr($message->message,0,40)}}<a class="read-more-show hide" href="#"> Read More</a> <span class="read-more-content">{{substr($message->message,40,strlen($message->message))}} <a class="read-more-hide hide" href="#"> Read Less</a></span></p>
								@else
								{{$message->message}}
								@endif
						  </td>
						  <td>{{ $message->msisdn }}</td>
                          <td>{{ $message->smsgateway->name }}</td>
                          <td>{{ $message->site->name }}</td>
                          <td>
                            @if($message->status == "success")
                              <span class=" badge green">Sent</span>
                            @else
                              <span class=" badge red">Failed</span>
                            @endif
                          </td>
                        </tr>
                      @endforeach
					  @else
							 <tr>
								<td colspan="6" style="text-align:center;">You do not have messages</td>
							 </tr>
					  @endif
						  </tbody>
						</table>
					  </div>
					  @if(!$messages->isEmpty())
					  <div class="col s12">
						<div class="center">
							  <button class="btn btn-default" id="load-more" style="width: 30%;">Load more</button>
							  <button class="btn btn-default hide" id="load-more1" style="width: 30%;">Load more</button>
							  <button class="btn btn-default hide" id="load-more2" style="width: 30%;">Load more</button>
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
<script src="{{ url('assets/js/messages.js') }}"></script>
@endsection