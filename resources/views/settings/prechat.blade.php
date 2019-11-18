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
                  <h5 class="breadcrumbs-title">Chat Window Settings</h5>
                  <ol class="breadcrumbs">
                    <li><a href="/">Dashboard</a></li>
                    <li class="active">Chat Window Settings</li>
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
					<div class="col s8">
						@if(empty($prechat))
						<div class="card-panel" id="addprechatdiv">
						<h4 class="header2">Chat Window Settings</h4>
						<div class="row">
						<form role="form" method="post" action="<?php echo URL::route('addprechatsetting') ?>" enctype="multipart/form-data" id="prechatform">
						{{ csrf_field() }}
						 
							<div class="row">
							  <div class="input-field col s12">
								<i class="material-icons prefix">account_circle</i>
								<input type="text" class="form-control" name="teamname" value="">
								<label for="teamname">Team Name</label>
							  </div>
							</div>
							<div class="row">
							  <div class="input-field col s12">
								<i class="material-icons prefix">message</i>
							   <textarea name="onlinemsg"  class="materialize-textarea" data-length="120"></textarea>
								<label for="onlinemsg">Online Greeting Message</label>
							  </div>
							</div>
							 <div class="row">
							  <div class="input-field col s12">
								<i class="material-icons prefix">message</i>
							   <textarea name="offlinemsg"  class="materialize-textarea" data-length="120"></textarea>
								<label for="offlinemsg">Offline Greeting Message</label>
							  </div>
							</div>
					         <div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">account_circle</i>
							 <span style="color:red" id="error"></span>
							 <input type="file" name="photo" id="photo">
                           </div>
                        </div>

							<div class="row">
							  <div class="row">
								<div class="input-field col s12">
								  <button id="addprechatbtn" class="btn cyan waves-effect waves-light right" type="submit">
									<i class="material-icons right">add</i>  Save
								  </button>
								</div>
							  </div>
							</div>
						  </form>
						</div>
					  </div>
					  <div class="card-panel hide" id="updateprechatdiv">
						<h4 class="header2">Chat Window Settings</h4>
						<div class="row">
						<form role="form" method="post" action="<?php echo URL::route('updateprechatsetting') ?>" enctype="multipart/form-data" id="updateprechatform">
						{{ csrf_field() }}
						 
							<div class="row">
							  <div class="input-field col s12">
								<i class="material-icons prefix">account_circle</i>
								<input type="text" class="form-control" name="teamname" id="teamname" value="">
								<label for="teamname">Team Name</label>
							  </div>
							</div>
							<div class="row">
							  <div class="input-field col s12">
								<i class="material-icons prefix">message</i>
							   <textarea name="onlinemsg" id="onlinemsg" class="materialize-textarea" data-length="120"></textarea>
								<label for="onlinemsg">Online Greeting Message</label>
							  </div>
							</div>
							 <div class="row">
							  <div class="input-field col s12">
								<i class="material-icons prefix">message</i>
							   <textarea name="offlinemsg" id="offlinemsg" class="materialize-textarea" data-length="120"></textarea>
								<label for="offlinemsg">Offline Greeting Message</label>
							  </div>
							</div>
					         <div class="row">
							  <div class="input-field col s12">
								<i class="material-icons prefix">account_circle</i>
								 <span style="color:red" id="error1"></span>
								 <input type="file" name="photo" id="photo1">
							   </div>
							  </div>

							<div class="row">
							  <div class="row">
								<div class="input-field col s12">
								<input type="hidden" class="form-control" name="id" id="id"  value="">
								  <button id="updateprechatbtn" class="btn cyan waves-effect waves-light right" type="submit">
									<i class="material-icons right">edit</i>  Update
								  </button>
								</div>
							  </div>
							</div>
						  </form>
						</div>
					  </div>
					  @else
					  <div class="card-panel " id="updateprechatdiv">
						<h4 class="header2">Chat Window Settings</h4>
						<div class="row">
						<form role="form" method="post" action="<?php echo URL::route('updateprechatsetting') ?>" enctype="multipart/form-data" id="updateprechatform">
						{{ csrf_field() }}
						 
							<div class="row">
							  <div class="input-field col s12">
								<i class="material-icons prefix">account_circle</i>
								<input type="text" class="form-control" name="teamname" id="teamname" value="{{ $prechat->team_name }}">
								<label for="teamname">Team Name</label>
							  </div>
							</div>
							<div class="row">
							  <div class="input-field col s12">
								<i class="material-icons prefix">message</i>
							   <textarea name="onlinemsg" id="onlinemsg" class="materialize-textarea" data-length="120">{{ $prechat->online_greeting_msg }}</textarea>
								<label for="onlinemsg">Online Greeting Message</label>
							  </div>
							</div>
							 <div class="row">
							  <div class="input-field col s12">
								<i class="material-icons prefix">message</i>
							   <textarea name="offlinemsg" id="offlinemsg" class="materialize-textarea" data-length="120">{{ $prechat->offline_greeting_msg }}</textarea>
								<label for="offlinemsg">Offline Greeting Message</label>
							  </div>
							</div>
					         <div class="row">
							  <div class="input-field col s12">
								<i class="material-icons prefix">account_circle</i>
								 <span style="color:red" id="error1"></span>
								 <input type="file" name="photo" id="photo1">
							   </div>
							  </div>

							<div class="row">
							  <div class="row">
								<div class="input-field col s12">
								<input type="hidden" class="form-control" name="id" id="id"  value="{{ $prechat->id }}">
								  <button id="updateprechatbtn" class="btn cyan waves-effect waves-light right" type="submit">
									<i class="material-icons right">edit</i>  Update
								  </button>
								</div>
							  </div>
							</div>
						  </form>
						</div>
					  </div>
					  @endif
					  <div class="card-panel ">
					   <table id="data-table-simple" class="responsive-table display" cellspacing="0">
						<thead>
						<tr>
						  <th style="width: 10px">#</th>
						  <th>Field Name</th>
						  <th>Required</th>
						  <th>Visible</th>
						  <th>Action</th>
								  
						</tr>
						</thead>
						<tfoot>
						<tr>
						  <th style="width: 10px">#</th>
						  <th>Field Name</th>
						  <th>Required</th>
						  <th>Visible</th>
						  <th>Action</th>
								  
						</tr>
						</tfoot>
						<tbody>
						@if (count($fields) > 0)
							@foreach($fields as $field)
								<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $field->name }}</td>
								<td>
									@if($field->required==1)
										    <p>
											<input type="checkbox" class="filled-in" id="filled-in-box" checked="checked" />
											<label for="filled-in-box"></label>
											</p>
									@else
										   <p>
											<input type="checkbox" id="test5" />
											<label for="test5"></label>
											</p>
									@endif
								</td>
								<td>
									@if($field->visible==1)
											<p>
											<input type="checkbox" class="filled-in" id="filled-in-box1" checked="checked" />
											<label for="filled-in-box1"></label>
											</p>
									@else
											<p>
											<input type="checkbox" id="test6" />
											<label for="test6"></label>
											</p>
									@endif
								</td>
								<td>
									<a  class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Edit" onclick="editfield({{ $field->id }})"   style="margin-right:3px;" id="editfieldbtn{{ $field->id }}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
								</td>
								</tr>
							@endforeach
						 @endif
						</tbody>
					  </table>
					  </div>
					</div>
					<div class="col s4">
					   <ul id="profile-page-about-feed" class="collection z-depth-1">
						<?php 
						if(!empty($prechat->team_name)){
						?>
						<li class="collection-item avatar ">
						<div class="avatarimg">
						<?php if(empty($prechat->agents_avatar)) {;?>
						  <img src="{{ url('images/avatar/avatar-2.png') }}" alt="" class="circle deep-orange accent-2">
						  <?php }else{ ?>
						  <img src="{{ url('avatar/'.$prechat->agents_avatar) }}" alt="" class="circle deep-orange accent-2">
						  <?php } ?>
						  </div>
						  <span class="title" id="profile-username">{{$prechat->team_name}}</span>
						</li>
						<?php } ?>
						<?php 
						if(!empty($prechat->online_greeting_msg)){
						?>
						<li class="collection-item avatar">
						  <i class="material-icons circle teal accent-4">message</i>
						  <span class="title">Online Greeting Message</span>
						  <p id="onlinemsgtext" >{{ $prechat->online_greeting_msg }}
						  </p>
						</li>
						<?php } ?>
						<?php 
						if(!empty($prechat->offline_greeting_msg)){
						?>
						<li class="collection-item avatar">
						  <i class="material-icons circle cyan">message</i>
						  <span class="title"> Offline Greeting Message</span>
						  <p id="offlinemsgtext">{{ $prechat->offline_greeting_msg }}
						  </p>
						</li>
						<?php } ?>
					  </ul>
					  
					  
					  	<div class="card-panel" id="addfielddiv">
						<h4 class="header2">Add Chat Window Fields</h4>
						<div class="row">
						<form role="form" method="post" action="<?php echo URL::route('addprechatfield') ?>" enctype="multipart/form-data" id="prechatfieldform">
						{{ csrf_field() }}
						 
							<div class="row">
							  <div class="input-field col s12">
								<i class="material-icons prefix">account_circle</i>
								<input type="text" class="form-control" name="fieldname" value="">
								<label for="fieldname">Field Name</label>
							  </div>
							</div>
							<p>
							  <input type="checkbox" class="filled-in" id="field_required"  name="field_required"/>
							  <label for="field_required">Required</label>
							</p>
							<p>
							  <input type="checkbox" class="filled-in" id="field_visible"  name="field_visible"/>
							  <label for="field_visible">Visible</label>
							</p>

							<div class="row">
							  <div class="row">
								<div class="input-field col s12">
								  <button id="addprechatfieldbtn" class="btn cyan waves-effect waves-light right" type="submit">
									<i class="material-icons right">add</i>  Add a new field
								  </button>
								</div>
							  </div>
							</div>
						  </form>
						</div>
					  </div>
					  	<div class="card-panel hide" id="editfielddiv">
						<h4 class="header2"><i class="fa fa-chevron-left fa-lg field-edit-back tooltipped "  data-position="top" data-delay="50" data-tooltip="Go back to add a field" style="margin-right:10px;cursor:pointer;"></i> Edit Chat Window Fields</h4>
						<div class="row">
						<form role="form" method="post" action="<?php echo URL::route('editprechatfield') ?>" enctype="multipart/form-data" id="editprechatfieldform">
						{{ csrf_field() }}
						 
							<div class="row">
							  <div class="input-field col s12">
								<i class="material-icons prefix">account_circle</i>
								<input type="text" class="form-control" name="fieldname" id="fieldname" value="">
								<label for="fieldname">Field Name</label>
							  </div>
							</div>
							<p>
							  <input type="checkbox" class="filled-in" id="field_required1"  name="field_required"/>
							  <label for="field_required1">Required</label>
							</p>
							<p>
							  <input type="checkbox" class="filled-in" id="field_visible1"  name="field_visible"/>
							  <label for="field_visible1">Visible</label>
							</p>


							<div class="row">
							  <div class="row">
								<div class="input-field col s12">
								  <input type="hidden" class="form-control" name="id" id="fieldid">
								  <button id="editprechatfieldbtn" class="btn cyan waves-effect waves-light right" type="submit">
									<i class="material-icons right">edit</i> Edit a field
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
    <!--form-elements.js - Page Specific JS codes-->
   <!-- <script type="text/javascript" src="{{ url('js/scripts/form-elements.js') }}"></script>-->
<script src="{{ url('assets/js/prechat.js') }}"></script>
@endsection