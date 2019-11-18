	@extends('layouts.new_master')
	@section('styles')
	<link rel="stylesheet" href="{{ url('int-tel/css/intlTelInput.css')}}">
	<link rel="stylesheet" href="{{ url('assets/css/custom.css')}}">
	@endsection('styles')
	@section('content')	
		<!-- START CONTENT -->
        <section id="content">
          <!--start container-->
          <div class="container">
            <div id="profile-page" class="section">
              <!-- profile-page-content -->
              <div id="profile-page-content" class="row">
                <!-- profile-page-sidebar-->
                <div id="profile-page-sidebar" class="col s12 m4">

                  <!-- Profile About Details  -->
                  <ul id="profile-page-about-details" class="collection z-depth-1">
                    <?php 
					if(!empty(Auth::user()->phone)){
					?>
					<li class="collection-item">
                      <div class="row">
                        <div class="col s5">
                          <i class="material-icons left">call</i> Telephone</div>
                        <div class="col s7 right-align" id="phonetext">{{ Auth::user()->phone }}</div>
                      </div>
                    </li>
					<?php } ?>
				    <?php 
					if(!empty(Auth::user()->email)){
					?>
                    <li class="collection-item">
                      <div class="row">
                        <div class="col s5">
                          <i class="material-icons left">email</i> Email</div>
                        <div class="col s7 right-align" id="emailtext">{{ Auth::user()->email }}</div>
                      </div>
                    </li>
					<?php } ?>
					<?php if(!empty(Auth::user()->address)){
					?>
                    <li class="collection-item">
                      <div class="row">
                        <div class="col s5">
                          <i class="material-icons left">domain</i> Address</div>
                        <div class="col s7 right-align" id="addresstext">{{ Auth::user()->address }}</div>
                      </div>
                    </li>
					<?php } ?>

                  </ul>
                  <!--/ Profile About Details  -->

                </div>
                <!-- profile-page-sidebar-->
                <!-- profile-page-wall -->
                <div id="profile-page-wall" class="col s12 m8">
        		    <div class="card-panel">
                    <h4 class="header2">Company Information</h4>
                    <div class="row">
					 <form role="form" method="post" action="<?php echo URL::route('update_company_profile') ?>" enctype="multipart/form-data" id="companyprofileform">
                       {{ csrf_field() }}
					   <div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">account_circle</i>
                            <input type="text" class="form-control" name="username" id="username" value="{{  $company->name }}">
                            <label for="username">Company Name</label>
                          </div>
                        </div>

					    <div>
								<a class="waves-effect waves-light  btn" id="image2">
								<input  type="image"  src="{{ url('images/upload.png') }}" width="15px" height="20px" /> Upload Logo
								</a>
								<input type="file" name="file" id="file2" style="display: none;">
								 <p id="file-name2"></p>
						</div>
						<div class="row">
                          <div class="row">
                            <div class="input-field col s12">
							  <input type="hidden" class="form-control" name="id" id="id"  value="{{ $company->id }}">
                              <button  class="btn cyan waves-effect waves-light left" type="submit" id="updatecompanyprofilebtn">Edit
                                <i class="material-icons left">edit</i>
                              </button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <!--/ profile-page-wall -->
              </div>
            </div>
          </div>
      </div>
      <!--end container-->
      </section>
@endsection
@section('scripts')
    <!-- google map api -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAAZnaZBXLqNBRXjd-82km_NO7GUItyKek"></script>
    <!--google map-->
    <script type="text/javascript" src="{{ url('js/scripts/google-map-script.js') }}"></script>
    <!--profile page js-->
    <script type="text/javascript" src="{{ url('js/scripts/page-profile.js') }}"></script>
<script src="{{ url('assets/js/register.js') }}"></script>
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