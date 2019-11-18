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
                  <h5 class="breadcrumbs-title">Feedback Window Settings</h5>
                  <ol class="breadcrumbs">
                    <li><a href="/">Dashboard</a></li>
                    <li class="active">Feedback Window Settings</li>
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
						@if(empty($postchat))
						<div class="card-panel" id="addpostchatdiv">
						<h4 class="header2">Feedback Window Settings</h4>
						<div class="row">
						<form role="form" method="post" action="<?php echo URL::route('addpostchatsetting') ?>" enctype="multipart/form-data" id="postchatform">
						{{ csrf_field() }}

							<div class="row">
							  <div class="input-field col s12">
								<i class="material-icons prefix">message</i>
							   <textarea name="greetingmsg"  class="materialize-textarea" data-length="120"></textarea>
								<label for="greetingmsg">Greeting Message</label>
							  </div>
							</div>
					    

							<div class="row">
							  <div class="row">
								<div class="input-field col s12">
								  <button id="addpostchatbtn" class="btn cyan waves-effect waves-light right" type="submit">
									<i class="material-icons right">add</i>  Save
								  </button>
								</div>
							  </div>
							</div>
						  </form>
						</div>
					  </div>
					  <div class="card-panel hide" id="updatepostchatdiv">
						<h4 class="header2">Feedback Window Settings</h4>
						<div class="row">
						<form role="form" method="post" action="<?php echo URL::route('updatepostchatsetting') ?>" enctype="multipart/form-data" id="updatepostchatform">
						{{ csrf_field() }}

							<div class="row">
							  <div class="input-field col s12">
								<i class="material-icons prefix">message</i>
							   <textarea name="greetingmsg" id="greetingmsg" class="materialize-textarea" data-length="120"></textarea>
								<label for="greetingmsg">Greeting Message</label>
							  </div>
							</div>

							<div class="row">
							  <div class="row">
								<div class="input-field col s12">
								<input type="hidden" class="form-control" name="id" id="id"  value="">
								  <button id="updatepostchatbtn" class="btn cyan waves-effect waves-light right" type="submit">
									<i class="material-icons right">edit</i>  Update
								  </button>
								</div>
							  </div>
							</div>
						  </form>
						</div>
					  </div>
					  @else
					  <div class="card-panel " id="updatepostchatdiv">
						<h4 class="header2">Feedback Window Settings</h4>
						<div class="row">
						<form role="form" method="post" action="<?php echo URL::route('updatepostchatsetting') ?>" enctype="multipart/form-data" id="updatepostchatform">
						{{ csrf_field() }}
						 
							<div class="row">
							  <div class="input-field col s12">
								<i class="material-icons prefix">message</i>
							   <textarea name="greetingmsg" id="greetingmsg" class="materialize-textarea" data-length="120">{{ $postchat->greeting_msg }}</textarea>
								<label for="greetingmsg">Greeting Message</label>
							  </div>
							</div>
							<div class="row">
							  <div class="row">
								<div class="input-field col s12">
								<input type="hidden" class="form-control" name="id" id="id"  value="{{ $postchat->id }}">
								  <button id="updatepostchatbtn" class="btn cyan waves-effect waves-light right" type="submit">
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
						if(!empty($postchat->greeting_msg)){
						?>
						<li class="collection-item avatar">
						  <i class="material-icons circle teal accent-4">message</i>
						  <span class="title"> Greeting Message</span>
						  <p id="greetingmsgtext" >{{ $postchat->greeting_msg }}
						  </p>
						</li>
						<?php } ?>
					  </ul>
					  
					  
					  	<div class="card-panel" id="addfielddiv">
						<h4 class="header2">Add Feedback Window Fields</h4>
						<div class="row">
						<form role="form" method="post" action="<?php echo URL::route('addpostchatfield') ?>" enctype="multipart/form-data" id="postchatfieldform">
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
								  <button id="addpostchatfieldbtn" class="btn cyan waves-effect waves-light right" type="submit">
									<i class="material-icons right">add</i>  Add a new field
								  </button>
								</div>
							  </div>
							</div>
						  </form>
						</div>
					  </div>
					  	<div class="card-panel hide" id="editfielddiv">
						<h4 class="header2"><i class="fa fa-chevron-left fa-lg field-edit-back tooltipped "  data-position="top" data-delay="50" data-tooltip="Go back to add a field" style="margin-right:10px;cursor:pointer;"></i> Edit Feedback Window Fields</h4>
						<div class="row">
						<form role="form" method="post" action="<?php echo URL::route('editpostchatfield') ?>" enctype="multipart/form-data" id="editpostchatfieldform">
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
								  <button id="editpostchatfieldbtn" class="btn cyan waves-effect waves-light right" type="submit">
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
<script src="{{ url('assets/js/postchat.js') }}"></script>
@endsection