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
                  <h5 class="breadcrumbs-title">Chats</h5>
                  <ol class="breadcrumbs">
                    <li><a href="/">Dashboard</a></li>
                    
                    <li class="active">Chats</li>
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
					<p>This service is coming soon</p>
					</div>
			  </div>
            </div>

          </div>
          <!--end container-->
        </section>
        <!-- END CONTENT -->
    @endsection
