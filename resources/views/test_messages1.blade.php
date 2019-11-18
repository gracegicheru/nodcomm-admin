	@extends('layouts.new_master')
	@section('styles')
	<link rel="stylesheet" href="{{ url('int-tel/css/intlTelInput.css')}}">
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
			  <div>
              <div class="row">
			     <div class="col s4">
				    <div class="card-panel">
                    <h4 class="header2">SMS</h4>
                    <div class="row">
					<form role="form" method="post" action="<?php echo URL::route('send-test-sms') ?>" id="sendSMSform">
					{{ csrf_field() }}
					@if(!empty($sender_ids))
						<div class="row">
                        <div class="input-field col s12">
						<i class="material-icons prefix">assignment_ind</i>
                          <select name="sender_id">
                            <option value="" disabled selected>Please select a Sender ID</option>
                            @foreach($sender_ids as $sender_id)
							<option value="{{ $sender_id->sender_id }}">{{ $sender_id->sender_id }}</option>
                            @endforeach
						  </select>
                          <label>Select a Sender ID</label>
                        </div>
						</div>
						@endif
                        <div class="row" style="margin-bottom:15px;">
                          <div class="input-field col s10">
                            <!--<i class="material-icons prefix">call</i>-->
                            <input type="tel"  name="telno" id="tel" class="form-control" placeholder="Enter your Mobile Number">
                         	<div style="width:10px;position:absolute;right: 30px;bottom: 10px;" >
							<span id="valid-msg" class="hide"> <i class="text-center fa fa-check" aria-hidden="true"></i> </span>
							<span id="error-msg" class="hide"><i class="fa fa-times" aria-hidden="true"></i> </span>	
							</div>
						 </div>
						  
                        </div>
                        <div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">message</i>
                           <textarea id="message" name="message" class="materialize-textarea"></textarea>
                            <label for="message">SMS</label>
							<div style="float: left;color: #a5a5a5;margin-top: 4px;"><span id="msg-count">0</span>/80</div>
                          </div>
                        </div>
						<div class="row">
                          <div class="row">
                            <div class="input-field col s12">
                              <button id="sendSMSbtn" class="btn cyan waves-effect waves-light right" type="submit">
                                <i class="material-icons right">send</i>  Send SMS
                              </button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>

                </div>
                <div class="col s8">
              <!--DataTables example-->
              <div id="table-datatables">
                <h4 class="header">SMS</h4>
                <div class="row">
					  <div class="col s12">
						<table id="data-table-simple" class="responsive-table display" cellspacing="0">
						  <thead>
							<tr>
							  <th>#</th>
							  <th>Mobile Number</th>
							  <th>Messsage</th>
							  <th>Sent By</th>
							</tr>
						  </thead>
						  <tfoot>
							<tr>
							  <th>#</th>
							  <th>Mobile Number</th>
							  <th>Messsage</th>
							  <th>Sent By</th>
							</tr>
						  </tfoot>
						  <tbody>
							@if (count($messages) > 0)
								
								@foreach($messages as $message)
									<tr>
									<td>{{ $loop->iteration }}</td>
									<td>{{ $message->phone }}</td>
									<td>

										   @if(strlen($message->message) > 30)
											
												<p>{{substr($message->message,0,30)}}<a class="read-more-show hide" href="#"> Read More</a> <span class="read-more-content">{{substr($message->message,30,strlen($message->message))}} <a class="read-more-hide hide" href="#"> Read Less</a></span></p>
											@else
											{{$message->message}}
											@endif
									  </td>
									<td>{{ $message->company }}</td>
									</tr>
								@endforeach
							  

							@endif
						  </tbody>
						</table>
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