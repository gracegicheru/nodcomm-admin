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
                  <h5 class="breadcrumbs-title">SMS History</h5>
                  <ol class="breadcrumbs">
                    <li><a href="index.html">Dashboard</a></li>
                    <li><a href="#">SMS History</a></li>
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
			 
              <div class="row">
                <div class="col s12">
				  <div id="striped-table">
					<h4 class="header">SMS History</h4>
					<div class="row">
					  <div class="col s12">
						   <div class="pull-right">
							  <!--<button class="btn btn-default addfilter" style="margin-right:10px;"><i class="fa fa-plus"></i> Add Filters</button>-->
							  <a class="btn btn-default" href="{{ url('/test/sms') }}"><i class="fa fa-send"></i> Send a test SMS</a>
						   </div>
					  </div>
					  <div class="col s12">
						<table class="striped responsive-table">
						  <thead>
							<tr>
							  <th>Date</th>
							  <th>Message</th>
							  <th>To</th>
							  <th>Status</th>
							</tr>
						  </thead>
						  <tbody id="msg-history">
                      @foreach($messages as $message)
                        <tr>
                          <td>{{ $message->created_at }}</td>
                          <td>{{ $message->message }}</td>
                          <td>{{ $message->msisdn }}</td>
                          <td>
                            @if($message->status == "success")
                              <span class="new badge green">Sent</span>
                            @else
                              <span class="new badge red">Failed</span>
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
						</div>
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
</script>
<script src="/assets/js/messages.js"></script>
@endsection