	@extends('layouts.new_master')
	@section('styles')
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
                  <h5 class="breadcrumbs-title">Sender ID Request</h5>
                  <ol class="breadcrumbs">
                    <li><a href="/">Dashboard</a></li>
                    
                    <li class="active">Sender ID Request</li>
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
			     <div class="col s12">
				    <div class="card-panel" id="addformdiv">
                    <h4 class="header2">Sender ID Request </h4>
                    <div class="row">
					<form role="form" method="post" action="<?php echo URL::route('sender_id_form') ?>" id="sender_id_form" enctype="multipart/form-data">
					{{ csrf_field() }}
                     
                        <!--<div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">account_circle</i>
                            <input type="text" class="form-control" name="name">
                            <label for="name">Company Name</label>
                          </div>
                        </div>
                        <div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">email</i>
                            <input type="email" class="form-control" name="email">
                            <label for="email">Company Email</label>
                          </div>
                        </div>
                        <div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">add_location</i>
                           <textarea id="address" name="address" class="materialize-textarea" data-length="50"></textarea>
                            <label for="address">Company Address</label>
                          </div>
                        </div>-->
					    <div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">account_circle</i>
                            <input type="text" class="form-control" name="sender_id">
                            <label for="sender_id">Desired Sender ID</label>
                          </div>
                        </div>
                        <div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">message</i>
                           <textarea id="message" name="message" class="materialize-textarea" data-length="120"></textarea>
                            <label for="message">Sender ID Usage(What the sender ID will be used for)</label>
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
                            <div class="input-field col s12">
                              <button id="sender_id_form_btn" class="btn cyan waves-effect waves-light right" type="submit">
                                <i class="material-icons left">send</i>  Request
                              </button>
                            </div>
                         </div>
                      </form>
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
	<script src="{{ url('/assets/js/sender_id.js') }}"></script>
@endsection