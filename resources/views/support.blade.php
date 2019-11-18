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
                  <h5 class="breadcrumbs-title">Support</h5>
                  <ol class="breadcrumbs">
                    <li><a href="/">Dashboard</a></li>
                   
                    <li class="active">Support</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <!--breadcrumbs end-->
          <!--start container-->
          <div class="container">
            <div class="section">
			@if (Auth::user()->company_id!=0)
{{--              <div class="row">--}}
{{--		  	 @if($disabled==1)--}}
{{--					<div class="col s12">--}}
{{--					<p>This service is coming soon</p>--}}
{{--					</div>--}}
				
{{--			 @else--}}
			     <div class="col s4">
				    <div class="card-panel">
                    <div class="row">
					<form role="form" method="post" action="<?php echo URL::route('sendmessage') ?>" id="sendmessageform">
					{{ csrf_field() }}
						<div class="row">
						  <div class="input-field col s12">
							<i class="material-icons prefix">message</i>
							<textarea name="message"  id="message" class="materialize-textarea" data-length="120"></textarea>
							<label for="message"> Message</label>
						  </div>
						</div>
						<div class="row">
                          <div class="row">
                            <div class="input-field col s12">
                              <button id="sendmessagebtn" class="btn cyan waves-effect waves-light right" type="submit">
                                <i class="material-icons right">send</i>  Send
                              </button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>

                </div>
				<div class="col s8">
					<table id="data-table-simple" class="responsive-table display" cellspacing="0">
						  <thead>
							<tr>
							  <th>#</th>
							  <th>Messsage</th>
							  <th>Sent By</th>
							  <th>Action</th>
							</tr>
						  </thead>
						  <tfoot>
							<tr>
							  <th>#</th>
							  <th>Messsage</th>
							  <th>Sent By</th>
							  <th>Action</th>
							</tr>
						  </tfoot>
						  <tbody>
								@if (count($messages) > 0)
									
									@foreach($messages as $message)
										<tr>
										<td>{{ $loop->iteration }}</td>
										<td>
										@if(strlen($message->support_description) > 70)
										{{ substr(ucfirst($message->support_description), 0, 70)."..."}}
										 @else
										 {{	$message->support_description }}
										@endif
																
										</td>
										<td>
										@if(Auth::user()->id==$message->user_id)
											Me
										@else
										{{ $message->user }}
										@endif
										</td>
										<td>
										<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="View Response" style="margin-right:3px;" href="<?php echo url('/support/reply/'.$message->id);?>"><i class="fa fa-reply" aria-hidden="true"></i></a>
										</td>
										</tr>
									@endforeach
								  

								@endif
						  </tbody>
						</table>
				</div>
{{--				@endif--}}
				</div>
{{--				@else--}}
				 <div class="row">
                <div class="col s12">
              <!--DataTables example-->
              <div id="table-datatables">
                <h4 class="header">Registered Users</h4>
                <div class="row">
					  <div class="col s12">
						<table id="data-table-simple1" class="responsive-table display" cellspacing="0">
						  <thead>
							<tr>
							  <th>#</th>
							  <th>Messsage</th>
							  <th>Company</th>
							  <th>Sent By</th>
							  <th>Status</th>
							  <th>Action</th>
							</tr>
						  </thead>
						  <tfoot>
							<tr>
							  <th>#</th>
							  <th>Messsage</th>
							  <th>Company</th>
							  <th>Sent By</th>
							  <th>Status</th>
							  <th>Action</th>
							</tr>
						  </tfoot>
						  <tbody>
							@if (count($messages) > 0)
								
								@foreach($messages as $message)
									<tr>
									<td>{{ $loop->iteration }}</td>
									<td>
									@if(strlen($message->support_description) > 70)
									{{ substr(ucfirst($message->support_description), 0, 70)."..."}}
									 @else
									 {{	$message->support_description }}
									@endif
															
									</td>
									<td>{{ $message->company }}</td>
									<td>{{ $message->user }}</td>
									<td>
									@if($message->solved==0)
										Not Solved
									@else
										 Solved
									@endif
									</td>
									<td>
									@if($message->solved==0)
										<a  class="btn tooltipped" data-position="top" data-delay="50"  data-tooltip="Mark Solved" onclick="marksolved({{ $message->id }})"  style="margin-right:3px;" id="marksolvedbtn{{ $message->id }}"><i class="fa fa-check" aria-hidden="true"></i></a>

									@else
										<a  class="btn tooltipped" data-position="top" data-delay="50"  data-tooltip="Mark Unsolved" onclick="markunsolved({{ $message->id }})"  style="margin-right:3px;" id="markunsolvedbtn{{ $message->id }}"><i class="fa fa-times" aria-hidden="true"></i></a>
									@endif
								
									<a  class="btn tooltipped" data-position="top" data-delay="50"  data-tooltip="Reply"  style="margin-right:3px;" href="<?php echo url('/support/reply/'.$message->id);?>"><i class="fa fa-reply" aria-hidden="true"></i></a>
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
            @endif


            </div>

          </div>
          <!--end container-->
        </section>
        <!-- END CONTENT -->
    @endsection
@section('scripts')

<script src="{{ url('assets/js/support.js') }}"></script>
<script type="text/javascript">
  var csrf = "{{ csrf_token() }}";
</script>
@endsection