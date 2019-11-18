	@extends('layouts.new_master')
	@section('styles')
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
                  <h5 class="breadcrumbs-title">Send a push notification </h5>
                  <ol class="breadcrumbs">
                    <li><a href="/">Dashboard</a></li>
                    
                    <li class="active">Send a push notification </li>
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
			     <div class="col s6">
				    <div class="card-panel">
                    <h4 class="header2">Send a push notification</h4>
                    <div class="row">
					<form role="form" method="post" action="<?php echo URL::route('send_push_campaigns') ?>" id="sendCampaignform">
					{{ csrf_field() }}
                     
                        <div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">title</i>
                            <textarea id="message_title" name="message_title" class="materialize-textarea" data-length="50"></textarea>
                            <label for="message_title">Title</label>
                          </div>
                        </div>
						<div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">notifications</i>
                            <textarea id="message_text" name="message_text" class="materialize-textarea" data-length="125"></textarea>
                            <label for="message_text">Web push text</label>
                          </div>
                        </div>
						
						<div class="row">
                        <div class="input-field col s12">
						<i class="material-icons prefix">web</i>
                          <select class="link" name="website">
                            <option value="" disabled selected>Please select a website</option>
							  @if (count($sites) > 0)
								@foreach($sites as $site)
								  <option value="{{$site->url }}|{{$site->site_id }}">{{ $site->name }}</option>
								@endforeach
							  @endif
                          </select>
                          <label>Select a website</label>
                        </div>
						</div>
						<div class="row">
							<input type="hidden"  name="url" id="urlinput" value="">
							<input type="hidden"  name="site_id" id="site_idinput" value="">
                          <div class="row">
                            <div class="input-field col s12">
                              <button id="sendpushbtn" class="btn cyan waves-effect waves-light right" type="submit">
                                <i class="material-icons right">send</i>  Send
                              </button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>

                </div>
				 <div class="col s6">
				 <div class="card-panel">
                    <div class="row">
						<div class="clearfix"> 
						<div style="margin-bottom:5px;">
						<p id="title"> Your Title </p>
						</div>
						<div>
						<div>
						<img src="{{ url('/images/push-notification.png') }}" class="pull-left " width="20%">
						</div>
						<div style="margin-left:25%;">
						<p id="content1">Your message content </p>
						<p id="url"> Your website url </p>
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
<script src="{{ url('assets/js/push_campaigns.js') }}"></script>
@endsection