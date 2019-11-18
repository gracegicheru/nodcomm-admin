	@extends('layouts.new_master')
	@section('styles')
	<link rel="stylesheet" href="{{ url('/assets/css/docs_styles.css') }}">
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
                  <h5 class="breadcrumbs-title">Docs</h5>
                  <ol class="breadcrumbs">
                    <li><a href="/">Dashboard</a></li>

                    <li class="active">SMS Messaging</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <!--breadcrumbs end-->
          <!--start container-->
          <div class="container">
            <div class="section">
			  <div>
              <div class="row">
				<div class="col s3">
				<div class="card-panel">
                    <h4 class="header2">API reference</h4>
                    <div class="row">
						  <ul class="nav nav-stacked">
							<li>
							  <a href="{{ url('/docs/sms/introduction') }}">Getting Started</a>
							</li>
							<li>
							  <a href="{{ url('/docs/sms/send-sms') }}">Sending an SMS</a>
							</li>
						  </ul>
					</div>
				</div>
				</div>
				<div class="col s9">
				  <div class="card-panel">
                    <h4 class="header2">Getting Started</h4>
                    <div class="row">
					  <div>
						This documentation will provide instructions on how to quickly integrate Nodcomm messaging services into various solutions by using Nodcomm HTTP API. Nodcomm API is based on REST standards. In order to interact with our API, any HTTP client in any programming language can be used.
					  </div>
					  <div>
						<h5>How to get started</h5>
						<div>
						  <h6>1. Add your application to Nodcomm</h6>
						  <div>
							In order to use our API, you will need credentials. Use the secret ID and Key found  <a href="{{ url('api') }}">here</a> .
						  </div>
						</div>
						<div>
						  <h6>2. Get authorization token</h6>
						  <div>
							Requests to Nodcomm API are authenticated using access tokens. To generate an access token, create an HTTP GET request to <code>https://api.nodcomm.com/v1/auth</code> with your application's secret ID and secret key base64 encoded in the request's header.
						  </div>
						  <div>Full JSON request is shown below:</div>
						  <div class="code">
							  GET /v1/auth HTTP/1.1
							  Authorization: Basic QWxhZGRpbnkdsecGVuIHNfgyyhED==
							  Content-Type: application/json
							  Accept: application/json
						  </div>
						</div>
						<div>
						  <h6>3. Send an SMS</h6>
						  <div>
							Now you are ready to send your first SMS. Create an HTTP POST request to <code>https://api.nodcomm.com/v1/messages/send</code> with the access token from step 2 in the header.
						  </div>
						  <div>Full JSON request is shown below:</div>
						  <div class="code">
							  POST /v1/auth HTTP/1.1
							  Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjcwMGMzZWNiNGVlZGNiODY0ZGZmNTk3NjYyNTJhZDVmNzIyNWNhMmExOTg0NjNlN2RiYmIzOTQ0Y2U4YWU0ZGIzMzE5OGFiYTJhOTNmYzRmIn0
							  Content-Type: application/json
							  Accept: application/json

							  {  
								 "alphanumeric":"NodSMS",
								 "msisdn":"5177866374",
								 "message":"My first Nodcomm SMS",
								 "gateway":"infobip"
							  }
						  </div>
						</div>
						<div style="padding: 20px 10px 10px;text-align: center;">
						  <a href="{{ url('/docs/sms/send-sms') }}">Next: Sending an SMS <i class="fa fa-chevron-right"></i> </a>
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
