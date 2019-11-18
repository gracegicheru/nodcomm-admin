	@extends('layouts.new_master')
	@section('styles')
	<link rel="stylesheet" href="/assets/css/admin.css">
	<link rel="stylesheet" href="{{ url('/assets/css/dashboard.css') }}">
	<link rel="stylesheet" href="{{ url('assets/css/custom.css')}}">
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
                  <h5 class="breadcrumbs-title">Website</h5>
                  <ol class="breadcrumbs">
                    <li><a href="/">Dashboard</a></li>
                    
                    <li class="active">Website</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <!--breadcrumbs end-->
          <!--start container-->
          <div class="container">
            <div class="section">
			   @if(!is_null($site))
				<div class="col s12">
				<h4 class="header2">{{ $site->url }}</h4>
				</div>
				@endif
              <div class="row">
			     <div class="col s12">
					<div id="basic-tabs" class="section">
					  <div class="row">
						
						<div class="col s12">
						  <div class="row">
							<div class="col s12">
							  <ul class="tabs tab-demo z-depth-1">
								<li class="tab col s3"><a class="active" href="#tab_1">Website Settings</a>
								</li>
								<li class="tab col s3"><a href="#tab_2">Statistics</a>
								</li>
								<li class="tab col s3"><a href="#tab_3">Subscribers</a>
								</li>
								<li class="pull-right tab col s3"><a href="{{ url('/push-sites') }}">All Websites</a>
								</li>
							  </ul>
							</div>
							<div class="col s12">
							  <div id="tab_1" class="col s12">
									@if(is_null($site))
									<div class="card-panel">
									   <div class="row no-padding2">
											<div class="text-center" style="padding: 50px;">The linked website was not found</div>
									  </div>
									</div>
									@else
									<div class="card-panel">

										  <div class="row no-padding2">
											<form role="form" method="post" action="<?php echo URL::route('editpushsite') ?>" id="editsitefrm">
											  {{ csrf_field() }}
											  <div class="row padding-top-10">
												<div class="col s4 clearfix">
												  <div class="label-bold pull-left">Domain Name</div>
												  <div class="pull-right label-bold mobile-hide">:</div>
												</div>
												<div class="col s8">
												  <div>{{ $site->name }}</div>
												  <div><input type="text" name="site_name" class="form-control hide" value="{{ $site->name }}"></div>
												</div>
											  </div>
											  <div class="row padding-top-10">
												<div class="col s4 clearfix">
												  <div class="label-bold pull-left">Website URL</div>
												  <div class="pull-right label-bold mobile-hide">:</div>
												</div>
												<div class="col s8">
												  <div>{{ $site->url }}</div>
												  <div>
													<input type="text" name="site_url" class="form-control hide" value="{{ $site->url }}">
													<input type="hidden" name="site_id" class="form-control hide" value="{{ $site->id }}">
												  </div>
												</div>
											  </div>
											  <hr>
											  <div class="row padding-top-10">
												<div class="col s4 clearfix">
												  <div class="label-bold pull-left">Website Identifier</div>
												  <div class="pull-right label-bold mobile-hide">:</div>
												</div>
												<div class="col s8">
												  <div>{{ $site->site_id }}</div>
												</div>
											  </div>
											  <div class="row padding-top-10">
												<div class="col s4 clearfix">
												  <div class="label-bold pull-left">Website Code</div>
												  <div class="pull-right label-bold mobile-hide">:</div>
												</div>
												<div class="col s8">
												  <div><textarea class="form-control code-view-textarea" readonly style="height:100px;">{{ $site->code }}</textarea></div>
												</div>
											  </div>
											  
											
											</form>
											<hr>
											<div class="row">
											  <div class="col-md-12">
												<div class="clearfix">
												  <div class="pull-right">
													<button class="btn btn-primary btn-edit-site"><i class="fa fa-pencil"></i> Edit</button>
													<button class="btn btn-success btn-edit-site-save hide"><i class="fa fa-save"></i> Save</button>
												  </div>
												</div>
											  </div>
											</div>
											
					 
										  </div>
										</div>
									
								@endif
							  </div>
							  <div id="tab_2">
									@if(is_null($site))
									<div class="card-panel">
									   <div class="row no-padding2">
											<div class="text-center" style="padding: 50px;">The linked website was not found</div>
									  </div>
									</div>
									@else
									<div class="card-panel">

										  <div class="row no-padding2">

													<ul class="navbar ">
														<li><p class="paragraph">{{count($subscribers )}}</p><span class=" text-center">@if(count($subscribers)==1) Subscriber @else Subscribers @endif</span></li>
														<li><p class="paragraph">{{count($today_subscribers )}}</p><span class=" text-center">@if(count($today_subscribers)==1) Subscriber for today @else Subscribers for today @endif</span></li>
														<li><p class="paragraph">5</p><span class=" text-center">Unsubscribers</span></li>
														<li><p class="paragraph">{{count($campaigns) }}</p><span class=" text-center"> @if(count($campaigns)==1) Campaign @else Campaigns @endif</span></li>

													</ul>
					 
										  </div>
										</div>
									
								@endif
					
							  </div>
							  <div id="tab_3" class="col s12">
								@if(is_null($site))
									<div class="card-panel">
									   <div class="row no-padding2">
											<div class="text-center" style="padding: 50px;">The linked website was not found</div>
									  </div>
									</div>
									@else
									<div class="card-panel">

										  <div class="row">

											<table id="data-table-simple" class="responsive-table display" cellspacing="0">
											  <thead>
												<tr>
													<th></th>
													<th>Subscriber Info</th>
													<th>Browser, OS</th>
													<th>Region</th>
													<th>Subscription Date</th>
												</tr>
											  </thead>
											  <tbody>
												@if(count($subscribers) > 0)

												  @foreach($subscribers as $visitor)
													  <tr>
														<td><i class="fa fa-user" style="color:green;"></i></td>
														<td>
														  <span style="padding-right: 5px;"><img style="width:20px;height:20px;" src="{{ $visitor->flag }}"></span>
														  <span>{{ $visitor->ip }}</span>
														</td>
														<td>{{$visitor->browser}}, {{$visitor->os}}</td>
														<td>{{ $visitor->country}}, {{$visitor->region }}, {{ $visitor->city}}</td>
														<td>{{ date_format($visitor->created_at,'F d,Y H:i:s') }}</td>
													  </tr>
												  @endforeach

											  @endif
											  </tbody>
											</table>
					 
										  </div>
										</div>
									
								@endif
							 </div>
				
							</div>
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
  <script src="/assets/js/push_sites.js"></script>
@endsection