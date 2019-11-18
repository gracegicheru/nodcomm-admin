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
                  <h5 class="breadcrumbs-title">Advert</h5>
                  <ol class="breadcrumbs">
                    <li><a href="/">Dashboard</a></li>
                    <li class="active">Advert</li>
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
					@if(empty($advert))
				    <div class="card-panel" id="addadvertdiv">
                    <h4 class="header2">Add Advert</h4>
                    <div class="row">
					<form role="form" method="post" action="<?php echo URL::route('addadvert') ?>" id="addadvertform">{{ csrf_field() }}
                     
                        <div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">add_shopping_cart</i>
                            <input type="text" class="form-control" name="name">
                            <label for="name">Advert Name</label>
                          </div>
                        </div>
                        <div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">email</i>
                           <textarea id="message" name="message" class="materialize-textarea" data-length="120"></textarea>
                            <label for="message">Advert Message</label>
							<div style="float: left;color: #a5a5a5;margin-top: 4px;"><span id="msg-count">0</span>/70</div>
                          </div>
                        </div>

						<div class="row">
                          <div class="row">
                            <div class="input-field col s12">
                              <button id="addadvertbtn" class="btn cyan waves-effect waves-light right" type="submit">
                                <i class="material-icons right">add</i>  Add
                              </button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                  <div class="card-panel hide" id="editadvertdiv">
                    <h4 class="header2"><i class="fa fa-chevron-left fa-lg agent-edit-back1" data-toggle="tooltip" data-original-title="Go back to add admin" style="margin-right:10px;cursor:pointer;"></i> Edit User</h4>
                    <div class="row">
					 <form role="form" method="post" action="<?php echo URL::route('editadvert') ?>" id="editadvertform">
                       {{ csrf_field() }}
                        <div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">add_shopping_cart</i>
                            <input type="text" class="form-control" id="name" name="name">
                            <label for="name">Advert Name</label>
                          </div>
                        </div>
                        <div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">email</i>
                           <textarea id="message1" name="message" class="materialize-textarea" data-length="120"></textarea>
                            <label for="message">Advert Message</label>
							<div style="float: left;color: #a5a5a5;margin-top: 4px;"><span id="msg-count">0</span>/70</div>
                          </div>
                        </div>
					   
					   
						<div class="row">
                          <div class="row">
                            <div class="input-field col s12">
							<input type="hidden" class="form-control" name="id" id="id">
                              <button  class="btn cyan waves-effect waves-light right" type="submit" id="editadvertbtn">Edit
                                <i class="material-icons right">edit</i>
                              </button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
				  @else
					<div class="card-panel " id="editadvertdiv">
                    <h4 class="header2"> Edit Advert</h4>
                    <div class="row">
					 <form role="form" method="post" action="<?php echo URL::route('editadvert') ?>" id="editadvertform">
                       {{ csrf_field() }}
                        <div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">add_shopping_cart</i>
                            <input type="text" class="form-control" id="name" name="name" value="{{$advert->name}}">
                            <label for="name">Advert Name</label>
                          </div>
                        </div>
                        <div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">email</i>
                           <textarea id="message1" name="message" class="materialize-textarea" data-length="120">{{$advert->message}}</textarea>
                            <label for="message">Advert Message</label>
							<div style="float: left;color: #a5a5a5;margin-top: 4px;"><span id="msg-count">0</span>/70</div>
                          </div>
                        </div>
					   
					   
						<div class="row">
                          <div class="row">
                            <div class="input-field col s12">
							<input type="hidden" class="form-control" name="id" id="id" value="{{$advert->id}}">
                              <button  class="btn cyan waves-effect waves-light right" type="submit" id="editadvertbtn">Edit
                                <i class="material-icons right">edit</i>
                              </button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
				  @endif
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

<script src="{{ url('assets/js/adverts.js') }}"></script>
@endsection