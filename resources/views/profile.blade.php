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
              <!-- profile-page-header -->
              <div id="profile-page-header" class="card">
                <div class="card-image waves-effect waves-block waves-light">
                  <img class="activator" src="../../images/gallary/23.png" alt="user background">
                </div>
                <figure class="card-profile-image" id="profileimage">
                  <img src="{{ url('profile_photos/'.Auth::user()->photo) }}" alt="profile image" class="circle z-depth-2 responsive-img activator gradient-45deg-light-blue-cyan gradient-shadow">
                </figure>
                <div class="card-content">
                  <div class="row pt-2">
                    <div class="col s12 m3 offset-m2">
                      <h4 class="card-title grey-text text-darken-4">{{Auth::user()->name}}</h4>
                      <p class="medium-small grey-text">          <?php
          if(Auth::user()->admin==1 && Auth::user()->company_id==0){
           echo ' Super Administrator'; 
          }elseif(Auth::user()->admin==1 && Auth::user()->company_id!=0){
            echo ' Administrator'; 
          }else{
            echo ' (Agent)'; 
          }
          ?></p>
                    </div>
                    <div class="col s12 m2 center-align">
                      <h4 class="card-title grey-text text-darken-4">993</h4>
                      <p class="medium-small grey-text">Total Sms</p>                    </div>
                    <div class="col s12 m2 center-align">
                      <h4 class="card-title grey-text text-darken-4">993</h4>
                      <p class="medium-small grey-text">Credit Purchases</p>
                    </div>
                    <div class="col s12 m2 center-align">
                      <h4 class="card-title grey-text text-darken-4">3</h4>
                      <p class="medium-small grey-text">No of Groups Created</p>
                    </div>
                    <div class="col s12 m1 right-align">
                      <a class="btn-floating activator waves-effect waves-light rec accent-2 right">
                        <i class="material-icons">perm_identity</i>
                      </a>
                    </div>
                  </div>
                </div>
                <div class="card-reveal">
                  <p>
                    <span class="card-title grey-text text-darken-4">{{ Auth::user()->name }}
                      <i class="material-icons right">close</i>
                    </span>
                    <span>
                      <i class="material-icons cyan-text text-darken-2">perm_identity</i>           <?php
                      if(Auth::user()->admin==1 && Auth::user()->company_id==0){
                        echo ' Super Administrator';
                      }elseif(Auth::user()->admin==1 && Auth::user()->company_id!=0){
                        echo ' Administrator';
                      }else{
                        echo ' (Agent)';
                      }
                      ?></span>
                  </p>
                  <p>This is your information.</p>
                  <p>
                    <i class="material-icons cyan-text text-darken-2">perm_phone_msg</i> {{ Auth::user()->phone }}</p>
                  <p>
                    <i class="material-icons cyan-text text-darken-2">email</i> {{ Auth::user()->email }}</p>

                  <p>
                    <i class="material-icons cyan-text text-darken-2">airplanemode_active</i> {{ Auth::user()->address }}</p>
                </div>
              </div>
              <!--/ profile-page-header -->
              <!-- profile-page-content -->
              <div id="profile-page-content" class="row">
                <!-- profile-page-sidebar-->
                <div id="profile-page-sidebar" class="col s12 m4">
                  <?php 
            if(!empty(Auth::user()->about)){
          ?>
          <!-- Profile About  -->
                  <div class="card cyan">
                    <div class="card-content white-text">
                      <span class="card-title">About Me!</span>
                      <p id="abouttext">{{ Auth::user()->about }}</p>
                    </div>
                  </div>
                  <!-- Profile About  -->
          <?php } ?>
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
                    <h4 class="header2">Basic Information</h4>
                    <div class="row">
           <form role="form" method="post" action="<?php echo URL::route('editprofile') ?>" enctype="multipart/form-data" id="profileform">
                       {{ csrf_field() }}
             <div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">account_circle</i>
                            <input type="text" class="form-control" name="username" id="username" value="{{ Auth::user()->name }}">
                            <label for="username">Name</label>
                          </div>
                        </div>
                        <div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">email</i>
                            <input type="email" class="form-control" name="email" id="email" value="{{ Auth::user()->email }}">
                            <label for="email">Email</label>
                          </div>
                        </div>
            <div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">email</i>
                           <textarea name="address" id="address" class="materialize-textarea" data-length="120">{{ Auth::user()->address }}</textarea>
                            <label for="message">Address</label>
                          </div>
                        </div>
                 <div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">account_circle</i>
                           <textarea name="about" id="about" class="materialize-textarea" data-length="120">{{ Auth::user()->about }}</textarea>
                            <label for="message">About</label>
                          </div>
                        </div>
                        <div class="row">
                          <div class="input-field col s10">
                            <!--<i class="material-icons prefix">call</i>-->
                            <input type="tel"  name="telno" id="tel" class="form-control" placeholder="Enter your Mobile Number"value="{{ Auth::user()->phone }}" >
                          <div style="width:10px;position:absolute;right: 30px;bottom: 10px;" >
              <span id="valid-msg" class="hide"> <i class="text-center fa fa-check" aria-hidden="true"></i> </span>
              <span id="error-msg" class="hide"><i class="fa fa-times" aria-hidden="true"></i> </span>  
              </div>
             </div>
              
                        </div>
                 <div class="row" style="margin-top:15px">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">account_circle</i>
               <span style="color:red" id="error"></span>
               <input type="file" name="photo" id="photo">
                           </div>
                        </div>
            <div class="row">
                          <div class="row">
                            <div class="input-field col s12">
                <input type="hidden" class="form-control" name="id" id="id"  value="{{ Auth::user()->id }}">
                              <button  class="btn cyan waves-effect waves-light right" type="submit" id="updateprofilebtn">Update
                                <i class="material-icons right">edit</i>
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