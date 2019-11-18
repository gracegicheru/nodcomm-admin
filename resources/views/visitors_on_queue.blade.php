@extends('layouts.master')
@section('styles')
<link rel="stylesheet" href="/assets/css/adminchat.css">
@endsection('styles')
@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
	  Visitors on Queue
      </h1>
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>

        <li class="active"> Visitors on Queue</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">

		<div class="col-md-12">
			<div class="box box-widget ">
			<div class="box-body visitors-tbl">
              <div class="box-body table-responsive no-padding" style="font-weight: normal;">
                <table class="table table-hover" id="dataTable">
                  <thead>
                      <tr>
                        <th></th>
                        <th>Visitor Info</th>
                        <th>Current Page</th>
                        <th>Visits</th>
                        <th>Chats</th>
						<th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                    @if(count($visitors) > 0)

                      @foreach($visitors as $visitor)
                          <tr>
                            <td><i class="fa fa-user" style="color:green;"></i></td>
                            <td>
                              <span style="padding-right: 5px;"><img style="width:20px;height:20px;" src="{{ $visitor->flag }}"></span>
                              <span>{{ $visitor->ip }}</span>
                              <span><a class="v-dets" data-visitor="{{ $visitor->data_json }}">Details</a></span>
                            </td>
                            <td>{{ $visitor->current_page }}</td>
                            <td>{{ $visitor->visits }}</td>
                            <td>{{ $visitor->chats }}</td>
							<td>	
								@if(Auth::user()->admin==1)
								<a onclick="assignagent({{ $visitor->id }})" class="btn btn-info btn-sm "   data-toggle="modal" data-target="#myModal"><i class="fa fa-user-plus" aria-hidden="true"></i> Assign Agent</a>
								@else
								<form role="form" method="post" action="<?php echo URL::route('assignagent') ?>" id="pickagentform">
								 {{ csrf_field() }}
								<input type="hidden" required name="vid" id="vid"  class="form-control input-sm bounceIn animation-delay2" value="{{ $visitor->id }}">
								<a  class="btn btn-info btn-sm assignagentbtn"  ><i class="fa fa-user-plus" aria-hidden="true"></i> Pick Visitor</a>	
								</form>
								@endif
						 </td>
						  </tr>
                      @endforeach

                  @else
                      <tr>
                        <td class="text-center" colspan="7"><div style="padding:20px;">You have no visitors on queue </div></td>
                      </tr>
                  @endif
                  </tbody>
                </table>
              </div>
			  
			    <div class="visitor-details-container" style="display:none;font-weight: normal;">
                <div class="visitor-details-body hide2">
                  <div style="padding: 10px 10px;"><i class="fa fa-info-circle"></i> Visitor Info</div>
                  <div id="visitor-ip" style="padding: 10px 10px;"></div>
                  <div style="padding: 10px 10px;">
                    <div class="info-title">Location</div>
                    <div id="visitor-location"></div>
                  </div>
                  <div style="padding: 10px 10px;">
                    <div class="info-title">Where From</div>
                    <div id="visitor-where-from"></div>
                  </div>
                  <div style="padding: 10px 10px;">
                    <div class="info-title">History</div>
                    <div><span id="visitor-visits"></span> | <span id="visitor-chats"></span></div>
                  </div>
                  <div style="padding: 10px 10px;">
                    <div class="info-title">Device Info</div>
                    <div id="visitor-browser"></div>
                    <div id="visitor-os"></div>
                  </div>
                </div>
                <div></div>
              </div>
			  </div>
			  </div>
        </div>
        <!-- /.col -->
		

      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
			<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Assign Agent</h4>
      </div>
      <div class="modal-body">
	  <div id="error"></div>
            <!-- form start -->
    		<form role="form" method="post" action="<?php echo URL::route('assignagent') ?>" id="assignagentform">
             {{ csrf_field() }}
			
			 <div class="box-body">
			   <div class="form-group">
						<label>Agent Name</label>
						 <select class="" id="agent_id" name="agent_id" style="width: 100%;">
						<option value="">Please select an agent</option>
		              		<?php
				
									foreach($agents as $row)
									{ 
									 echo '<option value="'.$row->id.'">'.$row->name.' ('.$row->email.')</option>';
									}
						?>

						</select>
			   </div>


              </div>
              <!-- /.box-body -->

              <div class="box-footer">
			    <input type="hidden" required name="id" id="id"  class="form-control input-sm bounceIn animation-delay2" value="">
                <button type="submit" class="btn btn-primary" id="assignagentbtn"><i class="fa fa-plus" aria-hidden="true"></i> Assign </button>
              </div>
            </form>
	 </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
     
	 </div>
    </div>

  </div>
</div>
  <!-- /.content-wrapper -->
 @endsection
 @section('scripts')

<script src="/assets/js/visitors.js"></script>

@endsection