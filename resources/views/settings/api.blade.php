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
                  <h5 class="breadcrumbs-title"> API Center</h5>
                  <ol class="breadcrumbs">
                    <li><a href="/">Dashboard</a></li>
                    <li class="active"> API Center</li>
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
				@if (Auth::user()->admin && Auth::user()->company_id!=0)
					@if($disabled==1)
					<p>This service is coming soon</p>
					 @else
					<div class="card-panel">

                        <!--<div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">account_circle</i>
                            <input type="text" class="form-control" name="username">
                            <label for="username">Username</label>
                          </div>
                        </div>-->
					<div class="row">
				    <div class="form-group">
						<label>API ID : </label>	
						<span> {{ $api->api_id}}</span>
					</div>
					</div>
					<div class="row">
	               	<div class="form-group">
						<label>API Key : </label>	
						<span>{{ $api->api_key}}</span>
					</div>
                    </div>
                  </div>
				  @endif
				@else
              <!--DataTables example-->
              <div id="table-datatables">
                <div class="row">
					  <div class="col s12">
						<table id="data-table-simple" class="responsive-table display" cellspacing="0">
						  <thead>
							<tr>
							  <th>#</th>
							  <th>Company</th>
							  <th>API ID</th>
							  <th>API Key</th>
							</tr>
						  </thead>
						  <tfoot>
							<tr>
							  <th>#</th>
							  <th>Company</th>
							  <th>API ID</th>
							  <th>API Key</th>
							</tr>
						  </tfoot>
						  <tbody>
							@if (count($apis) > 0)
								
								@foreach($apis as $api)
									<tr>
									<td>{{ $loop->iteration }}</td>
									<td>{{ $api->name }}</td>
									<td>{{ $api->api_id }}</td>
									<td>{{ $api->api_key }}</td>
									</tr>
								@endforeach
							  

							@endif
						  </tbody>
						</table>
						
							
						@endif
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