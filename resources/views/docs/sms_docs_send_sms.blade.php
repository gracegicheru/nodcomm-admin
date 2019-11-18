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
                    <h2 class="box-title" style="font-size: 36px;"><span class="header-label pst">POST</span> Sending an SMS</h2>
                    <div class="row">
					  <div>
						<h4>Resource</h4>
						<div>
						  https://api.nodcomm.com/v1/messages/send
						</div>
					  </div>
					  <div>
						<h4>Request Body</h4>
						<div>
						  <ul class="list-group list-group-unbordered param-list">
							<li class="list-group-item">
							  <div>
								<span class="param">gateway</span>
								<span class="param-type">enum</span>
								<span class="param-req">required</span>
							  </div>
							  <div>
								The SMS gateway to use to send the SMS.
							  </div>
							  <div>
								For allowed values, see <a href="{{ url('/') }}">Available SMS Gateways</a>
							  </div>
							</li>
							<li class="list-group-item">
							  <div>
								<span class="param">msisdn</span>
								<span class="param-type">array_string</span>
								<span class="param-req">required</span>
							  </div>
							  <div>
								Array of message destination addresses. If you want to send to one destination, a single String is supported instead of an Array. The destination addresses must be in international format e.g 5278466638
							  </div>
							</li>
							<li class="list-group-item">
							  <div>
								<span class="param">message</span>
								<span class="param-type">string</span>
								<span class="param-req">required</span>
							  </div>
							  <div>
								Text of the message that will be sent.
							  </div>
							</li>
							<li class="list-group-item">
							  <div>
								<span class="param">alphanumeric</span>
								<span class="param-type">string</span>
								<span class="param-req">optional</span>
							  </div>
							  <div>
								Represents the sender ID and it can be alphanumeric or numeric.
							  </div>
							  <div>
								<b>Note:</b> This field is required for some SMS gateways. For more information, see <a href="{{ url('/') }}">Available SMS Gateways</a>
							  </div>
							</li>
						  </ul>
						</div>
					  </div>
					  <div>
						<h4>Request Example</h4>
						<div>
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
					  </div>
					  <div>
						<h4>Response Body</h4>
						<div>
						  A successful request returns the HTTP 200 Success status code and a JSON response body that shows the message details and the message will be sent.
						</div>
						<div>
						  <ul class="list-group list-group-unbordered param-list">
							<li class="list-group-item">
							  <div>
								<span class="param">status</span>
								<span class="param-type">string</span>
							  </div>
							  <div>
								Indicates whether the message has been successfully sent or not.
							  </div>
							</li>
							<li class="list-group-item">
							  <div>
								<span class="param">message</span>
								<span class="param-type">string</span>
							  </div>
							  <div>
								A human-readable description of the status.
							  </div>
							</li>
						  </ul>
						</div>
					  </div>
					  <div>
						<h4>Response Example</h4>
						<div>
						  <div class="code">
							  {
								  "status": "success",
								  "message": "The message has been sent successfully"
							  }
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
