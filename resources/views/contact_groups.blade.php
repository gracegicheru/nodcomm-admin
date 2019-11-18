	@extends('layouts.new_master')
	@section('styles')
	<link rel="stylesheet" href="{{ url('/assets/css/custom.css') }}">
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
                    
                    <li class="active">Contact Groups</li>
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
					<div class="row">
					  <div class="col s12">
						<table class="striped responsive-table" id="dataTable7">
							<meta name="csrf-token" content="{{ csrf_token() }}" />
						  <thead>
							<tr>
							  <th>Group Name</th>
						      <th>Mobile Numbers</th>
							  <th>Edit</th>
								<th>Delete</th>
							</tr>
						  </thead>
						  <tbody id="msg-history" class="search-results">
						    @if (isset($contacts) && count($contacts) > 0)
							@foreach($contacts as $contact)
								<tr id="tr{{ $contact->id}}" class="rowItem">
								<td id="nm{{ $contact->id}}">{{ $contact->name }}</td>
								<td id="ph{{ $contact->id}}">
								{{ $contact->phones }}
								</td>
								<td>
									<a href="#modal" data-toggle="modal" class="btn tooltipped modal-trigger" data-position="top" data-delay="50" data-tooltip="Edit" onclick="return editgroup({{ $contact->id}},'{{$contact->name}}','{{ $contact->phones}}')" style="margin-right:3px;"><i class="fa fa-pencil" aria-hidden="true"></i></a>
								</td>
									<td>
{{--										<a href="#modal1" data-toggle="modal" class="btn tooltipped modal-trigger" data-position="top"--}}
{{--										   data-delay="50" data-tooltip="Delete"--}}
{{--										   onclick="return deletegroup({{ $contact->id}},'{{$contact->name}}','{{ $contact->phones}}')"--}}
{{--										   style="margin-right:3px;"><i class="fa fa-trash-o fa-fw" aria-hidden="true"></i></a>--}}
										<button id="del{{ $contact->id}}" class="delete waves-effect waves-light btn gradient-45deg-red-pink"><i class="fa fa-trash-o fa-fw" aria-hidden="true"></i></button>
									</td>
								</tr>
								@endforeach
						  @else
							 <tr>
								<td colspan="3" style="text-align:center;">You do not have a contact group</td>
							 </tr>						 
						  @endif
						  </tbody>
						</table>
					  </div>
					  @if (isset($contacts) && !$contacts->isEmpty() && count($contacts) > 10)
					  <div class="col s12">
						<div class="center">
							  <button class="btn btn-default" id="load-more" style="width: 30%;">Load more</button>
						</div>
					  </div>
					  @endif
					</div>
				  </div>
                </div>

              </div>
            </div>

          </div>
          <!--end container-->
		<!-- Modal Structure -->
        <div id="modal" class="modal">
        <div class="modal-content">
              <div class="row">
                <div class="col s12">
				<div class="card-panel">
                    
                    <div class="row">
					<form role="form" method="post" action="<?php echo URL::route('editcontactgroup') ?>" id="editcontactgroupform">
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
				<input type="tel"  name="telno" id="tel2" class="form-control" placeholder="Enter your Mobile Number">                      	
				<div style="width:10px;position:absolute;right: 20px;top: 20px;">
				<span id="valid-msg2" class="hide"> <i class="text-center fa fa-check" aria-hidden="true"></i> </span>
				<span id="error-msg2" class="hide"><i class="fa fa-times" aria-hidden="true"></i> </span>	
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
							 <input type="hidden" class="form-control" name="id" id="id">
                              <button id="editcontactgroupbtn" class="btn green waves-effect waves-light right" type="submit">
                                <i class="material-icons left">edit</i>  Update Group
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


			<div id="modal1" class="modal">
				<div class="modal-content">
					<div class="row">
						<div class="col s12">

								<div class="row">
									<form role="form" method="post" >
										{{ csrf_field() }}

										<div class="row">


											<p style="text-align:center;"><b> Are you sure you want to delete?</b></p>

										</div>


										<div class="row">
											<div class="row2">

												<div class="input-field2 col s12">
													<input type="hidden" class="form-control" name="id1" id="id1">
													<button id="yes" class="btn green waves-effect waves-light left" type="submit">
														<i class="material-icons left"></i> Yes
													</button>
													<button id="no" class="btn green waves-effect waves-light right" type="submit">
														<i class="material-icons left"></i> No
													</button>
												</div>
											</div>
										</div>
									</form>
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
<script type="text/javascript">
  var URL = '{{ url('/') }}';
  var csrf = "{{ csrf_token() }}";
  var paymentemail = "{{ Auth::user()->email }}";
</script>

<script src="{{ url('/assets/js/test_messages.js') }}"></script>
<script src="{{ url('int-tel/js/intlTelInput.js') }}"></script>
<script type="application/javascript">
$("#tel2").intlTelInput({
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