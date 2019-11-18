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
                  <h5 class="breadcrumbs-title">Websites</h5>
                  <ol class="breadcrumbs">
                    <li><a href="/">Dashboard</a></li>
                    
                    <li class="active">Websites</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <!--breadcrumbs end-->
          <!--start container-->
          <div class="container">
            <div class="section">
			  <div class="row addsitewrapper" style="display:none;">
				<div class="col s12">
					<div class="msgbox"></div>
					<div class="card-panel">
                    <h4 class="header2">Add Website</h4>
                    <div class="row">
					<form role="form" method="post" action="<?php echo URL::route('addsite') ?>" id="addsitefrm">
					{{ csrf_field() }}
                     
                        <div class="row">
                          <div class="input-field col s12">
                            <input type="text" class="form-control" name="name">
                            <label for="name">Website Name</label>
                          </div>
                        </div>
                        <div class="row">
                          <div class="input-field col s12">
                            <input type="text" class="form-control" name="url">
                            <label for="url">URL</label>
                          </div>
                        </div>
					   <div class="row">
					  <button class="btn btn-default showaddanalytics "><i class="fa fa-plus"></i> Add Google Analytics</button>
                         <div class="input-field col s12 hide gcodeinput">
                            <textarea id="gcode" name="gcode" class="materialize-textarea" data-length="120"></textarea>
							<label for="gcode" id="gcodelabel">Google Analytics Code</label>
                          </div>
					  </div>

						<div class="row">
                          <div class="row">
                            <div class="input-field col s12">
                              <button class="btn btn-success" id="addsitebtn">Add Site</button>
                              <button class="btn btn-default" id="canceladdsite">Cancel</button>
                              </button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
				</div>
			  </div>
			   <div class="row hide code">
					<div class="col s12">
						<div class="card-panel">
					    <div>Add the code below to the footer section of the website</div>
                        <hr style="margin-top: 10px;margin-bottom: 10px">
						<!--<textarea readonly="readonly" class="materialize-textarea" data-length="120" style="width:500px;height:200px;"></textarea>-->
						<textarea readonly="readonly" class="form-control" style="width:500px;height:200px;"></textarea>
						</div>
					</div>
			  </div>
              <div class="row">

                <div class="col s12">
              <!--DataTables example-->
              <div id="table-datatables">
                <h4 class="header">Websites</h4>
				<div class="pull-right">
                   <button class="btn  showaddsite"><i class="fa fa-plus"></i> Add Website</button>
                </div>
                <div class="row">
					  <div class="col s12">
						<table id="data-table-simple" class="responsive-table display" cellspacing="0">
						  <thead>
                            <tr>
                              <th>#</th>
                              <th>Name</th>
                              <th>URL</th>
                              <th>Identifier</th>
                              <th>Added On</th>
                              <th></th>
                            </tr>
						  </thead>
						  <tfoot>
                            <tr>
                              <th>#</th>
                              <th>Name</th>
                              <th>URL</th>
                              <th>Identifier</th>
                              <th>Added On</th>
                              <th></th>
                            </tr>
						  </tfoot>
						  <tbody id="allsitestbl">
                            @if(count($sites) > 0)

                                @foreach($sites as $key => $site)
                                    <tr>
                                      <td>{{ $key+1 }}</td>
                                      <td>{{ $site->name }}</td>
                                      <td>{{ $site->url }}</td>
                                      <td>{{ $site->site_id }}</td>
                                      <td>{{ $site->created_at }}</td>
                                      <td>
                                        <a class="btn btn-primary btn-xs" href="{{ url('/sites/'. $site->id) }}"><i class="fa fa-eye"></i></a>
                                      </td>
                                    </tr>
                                @endforeach

                            @endif
						  </tbody>
						</table>
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
<script type="text/javascript">
    var URL = '{{ url('/') }}';
</script>
<script src="{{ url('assets/js/sites.js') }}"></script>
@endsection