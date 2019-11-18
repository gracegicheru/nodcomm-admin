	@extends('layouts.new_master')
	@section('styles')
	<link rel="stylesheet" href="{{ url('assets/css/wizard.css')}}">
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
                  <h5 class="breadcrumbs-title">Translation</h5>
                  <ol class="breadcrumbs">
                    <li><a href="/">Dashboard</a></li>
                    <li class="active">Translation</li>
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
				    <div class="card-panel" id="translatediv">
                    <h4 class="header2">Translate</h4>
                    <div class="row">
					<form role="form" method="post" action="<?php echo URL::route('translate') ?>" id="translateform">
					{!! csrf_field() !!}
						<div class="row">
                        <div class="input-field col s12">
						<i class="material-icons prefix">language</i>
                          <select name="lang" class="lang">
                            <option value="" disabled selected>Please select a language</option>
							 @if (count($langs) > 0)
								@foreach($langs as $lang)
								<option value="{{$lang['code'] }}">{{ ucwords($lang['name']) }}</option>
							   @endforeach
							@endif
                          </select>
                          <label>Select language</label>
                        </div>
						</div>


						<div class="row">
                          <div class="row">
                            <div class="input-field col s12">
                              <button id="translatebtn" class="btn cyan waves-effect waves-light right" type="submit">
                                <i class="fa fa-language" aria-hidden="true"></i> Translate
                              </button>
                            </div>
                          </div>
                        </div>
                      </form>
					 <div class="row bs-wizard hide" style="border-bottom:0;padding:5px;" id="wizard">
						
						<div class="col s12 m6 l3 bs-wizard-step active" id="step1">
						  <div class="center bs-wizard-stepnum">Step 1</div>
						  <div class="progress"><div class="progress-bar"></div></div>
						  <a href="#" class="bs-wizard-dot"></a>
						  <div class="bs-wizard-info center">Validating language</div>
						</div>
						
						<div class="col s12 m6 l3 bs-wizard-step disabled" id="step2"><!-- complete -->
						  <div class="center bs-wizard-stepnum">Step 2</div>
						  <div class="progress"><div class="progress-bar"></div></div>
						  <a href="#" class="bs-wizard-dot"></a>
						  <div class="bs-wizard-info center">Create translated language file</div>
						</div>
						
						<div class="col s12 m6 l3 bs-wizard-step disabled" id="step3"><!-- complete -->
						  <div class="center bs-wizard-stepnum">Step 3</div>
						  <div class="progress"><div class="progress-bar"></div></div>
						  <a href="#" class="bs-wizard-dot"></a>
						  <div class="bs-wizard-info text-center">Save translated language in database</div>
						</div>
						<div class="col s12 m6 l3 bs-wizard-step disabled" id="step4"><!-- complete -->
						  <div class="center bs-wizard-stepnum">Step 4</div>
						  <div class="progress"><div class="progress-bar"></div></div>
						  <a href="#" class="bs-wizard-dot"></a>
						  <div class="bs-wizard-info center">Completed</div>
						</div>  
					</div>
                    </div>

                  </div>
                </div>
                <div class="col s12">
              <!--DataTables example-->
              <div id="table-datatables">
                <h4 class="header">Translated Languages</h4>
                <div class="row">
					  <div class="col s12">
						<table id="data-table-simple" class="responsive-table display" cellspacing="0">
						  <thead>
							<tr>
							  <th>#</th>
							  <th>Language Code</th>
							  <th>Language</th>
							  <th>Action</th>
							</tr>
						  </thead>
						  <tfoot>
							<tr>
							  <th>#</th>
							  <th>Language Code</th>
							  <th>Language</th>
							  <th>Action</th>
							</tr>
						  </tfoot>
						  <tbody>
							@if (isset($languages) && count($languages) > 0)
								
								@foreach($languages as $language)
									<tr>
									<td>{{ $loop->iteration }}</td>
									<td>{{ $language->lang_code }}</td>
									<td>{{ $language->lang }}</td>
									<td>
										<?php 
											$url = '/translation/view-file/'.$language->lang_code ;
										?>
											<!--<a data-toggle="tooltip" data-placement="top" title="" data-original-title="View file" href="<?php echo url($url);?>" class="btn btn-xs btn-primary"> <i class="fa fa-eye" aria-hidden="true"></i></a>-->
											<a  data-toggle="tooltip" data-placement="top" title="" data-original-title="View File" onclick="view_file('{{ $language->lang_code }}')"  class="btn btn-xs btn-info" style="margin-right:3px;" id="view_filebtn{{ $language->lang_code }}"><i class="fa fa-eye" aria-hidden="true"></i></a>							
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

          </div>
          <!--end container-->
        </section>
        <!-- END CONTENT -->
    @endsection
@section('scripts')

<script>
//$(".lang").select2();
var csrf = "{{ csrf_token() }}";
</script>
<script src="{{ url('assets/js/translation.js')}}"></script>
@endsection