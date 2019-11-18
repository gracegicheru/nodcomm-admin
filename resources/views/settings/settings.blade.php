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
                  <h5 class="breadcrumbs-title">General Settings</h5>
                  <ol class="breadcrumbs">
                    <li><a href="/">Dashboard</a></li>
                    <li class="active">General Settings</li>
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
              <!--DataTables example-->
              <div id="table-datatables">
                <h4 class="header">General Settings</h4>
                <div class="row">
					  <div class="col s12">
					  	<form role="form" class="form-horizontal" method="post" action="<?php echo URL::route('editsetting') ?>" id="editsettingform">
						{{ csrf_field() }}
						<table id="data-table-simple" class="responsive-table display" cellspacing="0">
						  <thead>
							<tr>
							  <th style="width: 10px">#</th>
							  <th>Setting Name</th>
							  <th>Setting Value</th>
							  <th>Action</th>
							</tr>
						  </thead>
						  <tfoot>
							<tr>
							  <th style="width: 10px">#</th>
							  <th>Setting Name</th>
							  <th>Setting Value</th>
							  <th>Action</th>
							</tr>
						  </tfoot>
						  <tbody>
							@if (count($settings) > 0)
								@foreach($settings as $setting)
							
									<tr>
									<td>{{ $loop->iteration }}</td>
									<td>{{  ucwords(str_replace("_"," ",$setting->config_key))}}</td>
									@if($setting->config_key=='paypal_mode')
									<td><span id="<?php echo 'paypalmodespan'.$setting->id;?>">				
										<?php
											if($setting->config_value==1){
												echo 'Sandbox';	
											}elseif($setting->config_value==2){
												echo 'Production';	
											}
										?>
										</span>
										<div class="hide" id="<?php echo 'paypalmodevalue'.$setting->id;?>">
															
											<label class="label-radio inline">
												<input type="radio" name="keyvalue" id="sandbox" value="1">
												<span class="custom-radio"></span>
													Sandbox
											</label>
											<label class="label-radio inline">
												<input type="radio" name="keyvalue" id="production" value="2" >
												<span class="custom-radio"></span>
													Production
											</label>
															
										</div><!-- /form-group -->
									</td>
									<td>
										<a  class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Edit" onclick="paypalmode({{ $setting->id }})"  style="margin-right:3px;" id="editpaypalmodebtn{{ $setting->id }}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
										<a  class="btn tooltipped hide" data-position="top" data-delay="50" data-tooltip="Save" onclick="savepaypalmode({{ $setting->id }})"  style="margin-right:3px;" id="savepaypalmodebtn{{ $setting->id }}"><i class="fa fa-floppy-o" aria-hidden="true"></i></a>
									</td>
									@else
									<td><span id="<?php echo 'settingspan'.$setting->id;?>"><?php if(strlen($setting->config_value ) > 100){echo substr($setting->config_value , 0, 100)."...";}else{echo $setting->config_value ;} ?></span><textarea  style="width:100%" class="form-control hide" id="<?php echo 'txtArea'.$setting->id;?>"   style="overflow-y: auto;"><?php echo $setting->config_value ; ?></textarea></td>
									<td>
										<a  class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Edit" onclick="editsetting({{ $setting->id }})"  style="margin-right:3px;" id="editsettingbtn{{ $setting->id }}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
										<a  class="btn tooltipped hide" data-position="top" data-delay="50" data-tooltip="Save" onclick="savesetting({{ $setting->id }})"   style="margin-right:3px;" id="savesettingbtn{{ $setting->id }}"><i class="fa fa-floppy-o" aria-hidden="true"></i></a>
									</td>
									 @endif

									</tr>
								@endforeach
							 @endif
						  </tbody>
						</table>
						</form>
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
<script src="{{ url('assets/js/settings.js') }}"></script>
@endsection