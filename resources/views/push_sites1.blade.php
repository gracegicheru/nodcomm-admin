	@extends('layouts.new_master')
	@section('styles')

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
                  <h5 class="breadcrumbs-title">Websites</h5>
                  <ol class="breadcrumbs">
                    <li><a href="/">Dashboard</a></li>
                    <li><a href="#">Websites</a></li>
                    <li class="active">Websites</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <!--breadcrumbs end-->
          <!--start container-->
          <div class="container">
            <div class="section">
			  <div class="row addsitewrapper" style="display:none;">
					<div class="card-panel">
						<div class="row" >
						  <h4 class="header2">Add Website</h4>
						    <div class="pull-right">
								<span class="fa fa-times close-filters" style="cursor:pointer;"></span>
							</div>
						</div>
                    <div class="row">
					<form role="form" method="post" action="<?php echo URL::route('addpushsite') ?>" id="addsitefrm">
					{{ csrf_field() }}
                     
                        <div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">account_circle</i>
                            <input type="text" class="form-control" name="name" id="name" >
                            <label for="name">Name</label>
                          </div>
                        </div>
                        <div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">email</i>
                            <input type="text" class="form-control" name="url" id="url">
                            <label for="url">URL</label>
                          </div>
                        </div>
						<div class="row">
                          <div class="row">
                            <div class="input-field col s12">
                              <!--<button id="registerbtn" class="btn cyan waves-effect waves-light right" type="submit">
                                <i class="material-icons right">add</i>  Register
                              </button>-->
							  <div class="pull-right">
								<button class="btn btn-success" id="addsitebtn">Add Site</button>
								<button class="btn btn-default" id="canceladdsite">Cancel</button>
							  </div>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
					</div>
				</div>
				<div class="row hide code">
					<div class="col s12">
						<div class="card-panel">

							<div class="row">

							</div>
						</div>
					</div>
				</div>
				@if(isset($messagesgg))
              <div class="row">
                <div class="col s12">
				  <div id="striped-table">
					<h4 class="header">SMS History</h4>
					<div class="row">
					<div class="col s6 search">
						<form role="form" method="post" action="<?php echo URL::route('search_sms') ?>" id="searchSMSForm">
							{{ csrf_field() }}
						<input type="text" name="search" class="header-search-input z-depth-2" placeholder="Search SMS by number" id="sms-search-term"/>
						</form>
					</div>
					  <div class="col s6">

						   <div class="pull-right">
							  <button class="btn btn-default addfilter" style="margin-right:10px;"><i class="fa fa-plus"></i> Add Filters</button>
							  <a class="btn btn-default" href="{{ url('/test/sms') }}"><i class="fa fa-send"></i> Send a test SMS</a>
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
						  </tbody>
						</table>
					  </div>
					  <div class="col s12">
						<div class="center">
							  <button class="btn btn-default" id="load-more" style="width: 30%;">Load more</button>
							  <button class="btn btn-default hide" id="load-more1" style="width: 30%;">Load more</button>
							  <button class="btn btn-default hide" id="load-more2" style="width: 30%;">Load more</button>
						</div>
					  </div>
					</div>
				  </div>
                </div>

              </div>
			  @endif
            </div>

          </div>
          <!--end container-->
        </section>
        <!-- END CONTENT -->
    @endsection
@section('scripts')
<script type="text/javascript">
  var URL = '{{ url('/') }}';
</script>
<script src="{{ url('assets/js/push_sites.js') }}"></script>
@endsection