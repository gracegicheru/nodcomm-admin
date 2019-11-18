	@extends('layouts.new_master')
	@section('styles')
	<link rel="stylesheet" href="{{ url('assets/css/paymentstyles.css')}}">
	<link rel="stylesheet" href="{{ url('assets/css/custom-styles.css')}}">
	<style>
	 /* label color */
   .input-field label {
     color: #fff;
   }
   /* label focus color */
   .input-field input[type=text]:focus + label {
     color: #fff;
   }
   /* label underline focus color */
   .input-field input[type=text]:focus {
     border-bottom: 1px solid #fff;
     box-shadow: 0 1px 0 0 #fff;
   }
   /* valid color */
   .input-field input[type=text].valid {
     border-bottom: 1px solid #fff;
     box-shadow: 0 1px 0 0 #fff;
   }
   /* invalid color */
   .input-field input[type=text].invalid {
     border-bottom: 1px solid #fff;
     box-shadow: 0 1px 0 0 #fff;
   }
   /* icon prefix focus color */
   .input-field .prefix.active {
     color: #fff;
   }
	</style>
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
                  <h5 class="breadcrumbs-title">Users</h5>
                  <ol class="breadcrumbs">
                    <li><a href="index.html">Dashboard</a></li>
                    <li><a href="#">Users</a></li>
                    <li class="active">Users</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <!--breadcrumbs end-->
          <!--start container-->
          <div class="container">
            <div class="section">
                <div class="col s12">
                    <!--<form enctype="multipart/form-data" id="senderIDForm">-->
					<form>
                        <div class="centerStich ">
                            <div class="login-widget animation-delay1">
                                <div class="content-section content-section-transparent">
                                    <div class="custom-heading added-padding">
                                        <div class="def-header green-header">
                                            <h2 class="panel-title">
                                                <i class="fa custom-icon fa-paper-plane fa-lg"></i> Sender ID
                                            </h2>
                                        </div>
                                    </div>
                                    <div class="stich" style="padding-top:0px !important;padding-bottom:0px !important;">
                                        <div id="step1" class="stich-inner" >
                                            <div id="interface1" class="interface ">
												<div class="row">
												  <div class="input-field col s12" >
													<i class="material-icons prefix">account_circle</i>
													<input type="text" class="form-control" name="sender_id" style="color:#fff">
													<label for="sender_id">Sender ID</label>
												  </div>
												</div>
												<div class="row" style="margin-bottom:15px;">
												  <div class="input-field col s12">
													<i class="material-icons prefix">account_circle</i>
													<input type="file" class="form-control" name="sender_id">
												  </div>
												</div>
                                            </div>
                                            <div class="text-center" style="margin: 0px auto; max-width: 335px;">
                                                <span class="help-block" style=" color: #fff !important;" >Uploaded document must be a filled copy of the draft below. The document must be correctly filled, signed and scanned.</span>
                                                <a target="_blank" class="btn btn-xs btn-default" href="#" style="margin-bottom: 30px;"><i class="fa fa-file-word-o fa-lg"></i> Sample</a>
                                                <br/>
                                            </div>
                                        </div>
                                        <div id="step2" class="stich-inner" style="display: none;">
                                            <p style="text-align: center; font-size: 14px;" class="alert alert-success">Your request has been submitted successfully we will contact you once the processing is finished. </p
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="padding-top: 20px;" id="step2Verification" class="login-widget interface animation-delay1">
                                <div class="content-section content-section-transparent">
                                    <div class="custom-heading added-padding">
                                        <div class="def-header green-header">
                                            <span class="panel-title small-header">
                                                Summary
                                            </span>
                                        </div>
                                    </div>
                                    <div class="stich">
                                        <div class="stich-inner">
                                            <div class="display-table bigger-words">
                                                <div class="display-tr" id="afterwallet">
                                                    <div class="display-td left-td" style="font-size: 14px;">Sender ID Cost</div>
                                                    <div class="display-td right-td bigger-words">: KSh <span id="wallet-balance"> cost </span>  </div>
                                                </div>
                                                <div class="display-tr">
                                                    <div class="display-td left-td" style="font-size: 14px;">Account Balance </div>
                                                    <div class="display-td right-td bigger-words">: KSh <span id="send-amount"> bal </span> </div>
                                                </div>
                                                <div class="display-tr">
                                                    <div class="display-td left-td" style="font-size: 14px;">Remaining Balance</div>
                                                    <div class="display-td right-td bigger-words">: KSh <span id="pay-amount"> rm_bal </span>  </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="btn1" style="text-align: center;">
                                <button style="width:80%; border-radius:50px;" type="submit" class="btn  btn-success black-send btn-lg bounceIn round animation-delay2 " id="submitRequest">Request </button>
                            </div>
                            <div id="btn2" style="text-align: center;display: none;" >
                                <button style="width:80%; border-radius:50px;" type="reset"  class="btn  btn-success black-send btn-lg bounceIn round animation-delay2" id="reSubmitRequest">Request Again</button>
                            </div>
                        </div>
                    </form>
                </div>


            </div>

          </div>
          <!--end container-->
        </section>
        <!-- END CONTENT -->
    @endsection

