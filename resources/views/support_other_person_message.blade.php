	@extends('layouts.new_master')
	@section('styles')
	<link rel="stylesheet" href="{{ url('/assets/css/support_message.css') }}">
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
                  <h5 class="breadcrumbs-title">Support</h5>
                  <ol class="breadcrumbs">
                    <li><a href="/">Dashboard</a></li>
                    <li class="active">Support</li>
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
					<section class="order_payment">
						<div class="chat-holder">
							<div class="row chat-window " id="chat_window_1">
								<div class="col s12 ">
											<div class="card-panel">
											<div class="top-bar">
												<div class="col s6">
													<h6 class="panel-title"><i class="fa fa-comment-o" aria-hidden="true"></i> {{$user->name}} Enquiry</h6>
												</div>
												<div class="col s6" style="text-align: right; font-size: 16px;">
													<strong>Support ID #{{$support_message->id}}</strong>
												</div>
											</div>
											<div class="panel-heading">
											<h6 class="panel-title" style="color:red;"><i class="fa fa-question" aria-hidden="true"></i> Question</h6>
												<p>{{$support_message->support_description}}</p>
											</div>

											<div class="row msg_container_base"  id="chatdiv">
											@if(count($messages)>0)
											@foreach($messages as $message)
											@if($message->company_id==0)
												<div class="row msg_container base_sent">
													<div class="col s10">
														<div class="messages msg_sent">
														<p style="color:blue;">Nodcomm Support #{{$message->user->name}}</p>
														<p>{{$message->description}}</p>
														<p class="time_date"><span>Sent: </span>
														{{date("D M j Y G:i:s",strtotime($message->created_at))}}
														</p>
														</div>
													</div>
													<div class="col s2 avatar">
													<i class="fa fa-user" aria-hidden="true"></i>
													</div>
												</div>
												@elseif($user->id==$message->user_id)
												
												<div class="row msg_container base_sent">
													<div class="col s10">
														<div class="messages msg_sent">
														<p style="color:blue;">User #{{$message->user->name}}</p>
														<p>{{$message->description}}</p>
														<p class="time_date"><span>Sent: </span>
														{{date("D M j Y G:i:s",strtotime($message->created_at))}}
														</p>
														</div>
													</div>
													<div class="col s2 avatar">
													<i class="fa fa-user" aria-hidden="true"></i>
													</div>
												</div>
											@else
												
											  <div class="row msg_container base_receive">
												<div class="col s2 avatar">
												   <i class="fa fa-user" aria-hidden="true"></i>
												</div>
												<div class="col s10">
													<div class="messages msg_receive">
														<p style="color:blue;">Me</p>
														<p>{{$message->description}}</p>
														<p class="time_date"><span>Sent: </span>
														{{date("D M j Y G:i:s",strtotime($message->created_at))}}
														</p>
													</div>
													</div>
												</div>
											@endif
											@endforeach
											@endif
											</div>
										<div class="panel-footer">
											   Messages
										</div>
								   
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
					</section>
				 </div>
			 </div>
			 
			<div class="row" style="margin-top:10px">
			     <div class="col s12">
				 	<div class="card-panel">
                    <div class="row">
					<form role="form" method="post" action="<?php echo URL::route('replymessage') ?>" id="sendmessageform">
					{{ csrf_field() }}
						<div class="row">
						  <div class="input-field col s12">
							<i class="material-icons prefix">message</i>
							<textarea name="message"  class="materialize-textarea" data-length="120"></textarea>
							<label for="message"> Message</label>
						  </div>
						</div>
						<div class="row">
                          <div class="row">
                            <div class="input-field col s12">
							<input type="hidden" class="form-control" name="id" value="{{$support_message->id}}">
                              <button id="sendmessagebtn" class="btn cyan waves-effect waves-light right" type="submit">
                                <i class="material-icons right">send</i>  Send
                              </button>
                            </div>
                          </div>
                        </div>
                      </form>
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

<script src="{{ url('assets/js/support_admin_message.js') }}"></script>

@endsection