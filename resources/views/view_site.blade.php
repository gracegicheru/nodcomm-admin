	@extends('layouts.new_master')
	@section('styles')
	<link rel="stylesheet" href="{{ url('assets/css/admin.css')}}">
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
			     <div style="margin-bottom: 10px;">
				  <a href="{{ url('/sites') }}" class="btn btn-default"><i class="fa fa-chevron-left"></i> All Websites</a>
				</div>
			  <div>
              <div class="row">
			     <div class="col s12">
				 
				    @if(is_null($site))
                      <div>
                        <div class="text-center" style="padding: 50px;">The linked website was not found</div>
                      </div>
					@else
				    <div class="card-panel no-padding2">
                    <h4 class="header2">Website #{{ $site->site_id }}</h4>
                    <div class="row">
					<form role="form" method="post" action="<?php echo URL::route('editsite') ?>" id="editsitefrm">
					{{ csrf_field() }}
                     
                          <div class="row padding-top-10">
                            <div class="col s4 clearfix">
                              <div class="label-bold pull-left">Name</div>
                              <div class="pull-right label-bold mobile-hide">:</div>
                            </div>
                            <div class="col s8">
                              <div>{{ $site->name }}</div>
                              <div><input type="text" name="site_name" class="form-control hide" value="{{ $site->name }}"></div>
                            </div>
                          </div>
                          <div class="row padding-top-10">
                            <div class="col s4 clearfix">
                              <div class="label-bold pull-left">Website URL</div>
                              <div class="pull-right label-bold mobile-hide">:</div>
                            </div>
                            <div class="col s8">
                              <div>{{ $site->url }}</div>
                              <div>
                                <input type="text" name="site_url" class="form-control hide" value="{{ $site->url }}">
                                <input type="hidden" name="site_id" class="form-control hide" value="{{ $site->id }}">
                              </div>
                            </div>
                          </div>
                          <hr>
                          <div class="row padding-top-10">
                            <div class="col s4 clearfix">
                              <div class="label-bold pull-left">Website Identifier</div>
                              <div class="pull-right label-bold mobile-hide">:</div>
                            </div>
                            <div class="col s8">
                              <div>{{ $site->site_id }}</div>
                            </div>
                          </div>
                          <div class="row padding-top-10">
                            <div class="col s4 clearfix">
                              <div class="label-bold pull-left">Website Code</div>
                              <div class="pull-right label-bold mobile-hide">:</div>
                            </div>
                            <div class="col s8">
                              <div><textarea class="form-control code-view-textarea" readonly style="height:100px;">{{ $site->code }}</textarea></div>
                            </div>
                          </div>
						  
						   <div class="row padding-top-10">
                            <div class="col s4 clearfix">
                              <div class="label-bold pull-left">Google Analytics Code</div>
                              <div class="pull-right label-bold mobile-hide">:</div>
                            </div>
                            <div class="col s8">
                              <div><textarea class="form-control code-view-textarea" name="gcode"  style="height:100px;">{{ $site->gcode }}</textarea></div>
                            </div>
                          </div>
						
                        </form>
                        <hr>

						<div class="row">
                          <div class="row">
                            <div class="input-field col s12">
                                <button class="btn btn-primary btn-edit-site"><i class="fa fa-pencil"></i> Edit</button>
                                <button class="btn btn-success btn-edit-site-save hide"><i class="fa fa-save"></i> Save</button>
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

  <script type="text/javascript">
    var URL = '{{ url('/') }}';
  </script>
  <script src="{{ url('assets/js/sites.js') }}"></script>
@endsection