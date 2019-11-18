	@extends('layouts.new_master')
	@section('styles')
	<link rel="stylesheet" href="{{ url('assets/css/custom.css')}}">
	<link rel="stylesheet" href="{{ url('int-tel/css/intlTelInput.css')}}">
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
                  <ol class="breadcrumbs">
                    <li><a href="/">Dashboard</a></li>
                    
                    <li class="active">SEND SMS</li>
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
				    <div style="
">
    <h4 class="header2 left">Send SMS</h4>
    <div class="right2" style="float: right;">
	<a class="btn light-green black-text lighten-4 waves-effect waves-light right2 modal-trigger" href="#modal" ><i class="material-icons left"  > add</i> Create contact group</a>					  
	</div>
</div>
<div style="clear: both;"></div>
<div class="card-panel">
                    
                    <div class="row">
					<form role="form" method="post" action="<?php echo URL::route('send-test-sms') ?>" id="sendSMSform">
					 {{ csrf_field() }}
					@if(!$sender_ids->isEmpty())
						<div class="row">
                          <div class="col s2">
								<div class="" style="margin-top: 16px;"><i class="material-icons left">assignment_ind</i>Sender ID</div>
						  </div>
						  <div class="input-field2 col s10">
						   <select name="sender_id">
                            <option value="" disabled selected>Please select a Sender ID</option>
                            @foreach($sender_ids as $sender_id)
							<option value="{{ $sender_id->sender_id }}">{{ $sender_id->sender_id }}</option>
                            @endforeach
						  </select>
                          </div>
                        </div>
						@endif
                        <div class="row" style="margin-bottom:15px;" id="mobile_numbers_div">
							<div class="col s2">
							<div class="" style="
							margin-top: 16px;
						"><i class="material-icons left">account_circle</i>To</div>
						</div>
												  
						<div class="input-field2 col s9" style="
							position: relative;
						">
						<input type="tel"  name="telno" id="tel" class="form-control" placeholder="Enter your Mobile Number">
										   
							<div style="width:10px;position:absolute;right: 20px;top: 20px;">
							<span id="valid-msg" class="hide"> <i class="text-center fa fa-check" aria-hidden="true"></i> </span>
							<span id="error-msg" class="hide"><i class="fa fa-times" aria-hidden="true"></i> </span>	
							</div>
						 <div>
						<div class="left grey-text" style="
						font-size: 12px;
					">Press enter to add multiple numbers</div>

						<button class="right waves-effect waves-light btn " style="background-color:#f4d341" ><a style="font-size: 12px;cursor: pointer; color: white;" id="sent_to_group">Send to contact group instead</a></button>

					<div style="clear: both;"></div></div>
					<div class="hide" id="phonesdiv1">

					</div>
					<div class="hide" id="mobilenos1"></div>
					</div>
                        </div>
						
						<div class="row hide" id="contactdiv">
						  @if($contacts->isEmpty())
						  <div class="col s6">
							<div id="card-alert" class="card red">
							<div class="card-content white-text">
							  <p>No contact group : Please create a contact group first</p>
							</div>
							<button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
							  <span aria-hidden="true">×</span>
							</button>
							</div>
							</div>
						  @else
                          <div class="col s2">
								<div class="" style="margin-top: 16px;"><i class="material-icons left">message</i>Contact Group</div>
						  </div>
						  <div class="input-field2 col s10">
                          <select name="contact" id="contact">
                            <option value="" disabled selected>Please select a contact group</option>
                            @foreach($contacts as $contact)
							<option value="{{$contact->phones}}">{{$contact->name}}</option>
							@endforeach
                          </select>
                          
                          </div>
						  @endif
                        </div>
						
                        <div class="row">
                          <div class="col s2">
								<div class="" style="margin-top: 16px;"><i class="material-icons left">message</i>Message</div>
						  </div>
						  <div class="input-field2 col s10">
                            
                           <textarea id="message" name="message" class="materialize-textarea"></textarea>
                            
							<div style="float: left;color: #a5a5a5;margin-top: 4px;"><span id="msg-count">0</span>/80</div>
                          </div>
                        </div>
						<div class="row">
                          <div class="row2">
                            
							<div class="input-field2 col s12">
                              <button id="sendSMSbtn" class="btn green waves-effect waves-light right" type="submit">
                                <i class="material-icons left">send</i>  Send SMS
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


					        <!-- Modal Structure -->
        <div id="modal" class="modal">
        <div class="modal-content">
              <div class="row">
                <div class="col s12">
				<div class="card-panel">
                    
                    <div class="row">
					<form role="form" method="post" action="<?php echo URL::route('addcontactgroup') ?>" id="contactgroupform">
					 {{ csrf_field() }}
                        <div class="row">
                          <div class="col s2">
							<div class="" style="margin-top: 16px;"><i class="material-icons left">message</i>Contact Name</div>
						  </div>
						<div class="input-field2 col s10">
                          <input type="text" class="form-control" id="contact_name" name="contact_name" placeholder="Group Contact Name"/>
						</div>
                        </div>
                        <div class="row" style="margin-bottom:15px;">
						<div class="col s2">
						<div class="" style="
						margin-top: 16px;
					"><i class="material-icons left">account_circle</i>To</div>
					</div>
                          
				<div class="input-field2 col s9" style="
					position: relative;
				">
				<input type="tel"  name="telno" id="tel1" class="form-control" placeholder="Enter your Mobile Number">                      	
				<div style="width:10px;position:absolute;right: 20px;top: 20px;">
				<span id="valid-msg1" class="hide"> <i class="text-center fa fa-check" aria-hidden="true"></i> </span>
				<span id="error-msg1" class="hide"><i class="fa fa-times" aria-hidden="true"></i> </span>	
				</div>
				<div>
					<div class="left grey-text" style="
					font-size: 12px;
				">Press enter to add multiple numbers</div>

				<div style="clear: both;"></div></div>
				<div id="phonesdiv" class="hide">

				</div>
				<div class="hide" id="mobilenos"></div>

				</div>
                                                                                                       
						  
                        </div>
	
						<div class="row">
                          <div class="row2">
                            
						<div class="input-field2 col s12">
                              <button id="contactgroupbtn" class="btn green waves-effect waves-light right" type="submit">
                                <i class="material-icons left">add</i>  Save Group
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
        <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
        </div>
        </div>

        </section>
        <!-- END CONTENT -->
    @endsection
@section('scripts')

<script src="{{ url('assets/js/test_messages.js') }}"></script>
<script src="{{ url('int-tel/js/intlTelInput.js') }}"></script>
<script type="application/javascript">
$("#tel").intlTelInput({
  initialCountry: "auto",
  geoIpLookup: function(callback) {
    $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
      var countryCode = (resp && resp.country) ? resp.country : "";
      callback(countryCode);
    });
  },
  utilsScript: "/int-tel/js/utils.js" // just for formatting/placeholders etc
});

$("#tel1").intlTelInput({
  initialCountry: "auto",
  geoIpLookup: function(callback) {
    $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
      var countryCode = (resp && resp.country) ? resp.country : "";
      callback(countryCode);
    });
  },
  utilsScript: "/int-tel/js/utils.js" // just for formatting/placeholders etc
});


</script>
@endsection