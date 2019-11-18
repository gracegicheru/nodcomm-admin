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
	  Agents on Chat
      </h1>
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>

        <li class="active">Agents on Chat</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">

		<div class="col-md-12">
			<div class="box box-widget ">
			<div class="box-body visitors-tbl">
              <div class="box-body table-responsive no-padding" style="font-weight: normal;">
                <table class="table table-hover">
                  <thead>
                      <tr>
                        <th></th>
                        <th>Visitor Info</th>
                        <th>Current Page</th>
                        <th>Visits</th>
                        <th>Chats</th>
						<th>Agent Name</th>
						<th>Agent Email</th>
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
							<td>{{ $visitor->agent->name }}</td>
							<td>{{ $visitor->agent->email }}</td>
                          </tr>
                      @endforeach

                  @else
                      <tr>
                        <td class="text-center" colspan="7"><div style="padding:20px;">You have no visitors</div></td>
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

  <!-- /.content-wrapper -->
 @endsection
 @section('scripts')

<script src="/assets/js/visitors.js"></script>

@endsection