
@extends('layouts.master')
@section('styles')

@endsection('styles')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="font-weight:normal">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Adverts
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-4 connectedSortable">

          <div class="box box-primary" id="addadvertdiv">
            <div class="box-header with-border">
              <h3 class="box-title">Add Advert</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
    		<form role="form" method="post" action="<?php echo URL::route('addadvert') ?>" id="addadvertform">
             {{ csrf_field() }}
			
			 <div class="box-body">
					   <div class="form-group">
					   <label>Advert Name </label>
						<input name="name" type="text" class="form-control" placeholder="Advert Name">
					  </div>

					   <div class="form-group">
						  <label>Advert Message</label>
							<textarea class="form-control" rows="5" id="message" name="message" placeholder="Advert Message"></textarea>
						<div style="float: left;color: #a5a5a5;margin-top: 4px;"><span id="msg-count">0</span>/70</div>
						</div>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary" id="addadvertbtn"><i class="fa fa-plus" aria-hidden="true"></i> Add</button>
              </div>
            </form>
          </div>
          <!-- /.box -->
		  
          <div class="box box-primary hidden" id="editadvertdiv">
            <div class="box-header with-border">
             
			  <h3 class="box-title"><i class="fa fa-chevron-left fa-lg advert-edit-back" data-toggle="tooltip" data-original-title="Go back to add an advert" style="margin-right:10px;cursor:pointer;"></i> Edit Advert</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
    		<form role="form" method="post" action="<?php echo URL::route('editadvert') ?>" id="editadvertform">
             {{ csrf_field() }}
			
			 <div class="box-body">
	
					   <div class="form-group">
					   <label>Advert Name </label>
						<input name="name" id="name" type="text" class="form-control" placeholder="Advert Name">
					  </div>

					   <div class="form-group">
						  <label>Advert Message</label>
							<textarea class="form-control" rows="5" id="message1" name="message" placeholder="Advert Message"></textarea>
						<div style="float: left;color: #a5a5a5;margin-top: 4px;"><span id="msg-count">0</span>/70</div>
						</div>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
			   <input type="hidden" class="form-control" name="id" id="id">
                <button type="submit" class="btn btn-primary" id="editadvertbtn"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button>
              </div>
            </form>
          </div>
          <!-- /.box -->
        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-8 connectedSortable">

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Added Adverts</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="dataTable" class="table table-bordered table-striped">
                <thead>
                <tr>
				  <th>#</th>
                  <th>Advert Name</th>
                  <th>Advert Message</th>
				  <th>Status</th>
				  <th>Action</th>
                </tr>
                </thead>
                <tbody>
				@if (count($adverts) > 0)
					
					@foreach($adverts as $advert)
						<tr>
						<td>{{ $loop->iteration }}</td>
						<td>{{ $advert->name }}</td>
						<td>
						@if(strlen($advert->message)>50)
						{{substr($advert->message, 0, 50)}}...
						@else
							{{ $advert->message }}
						@endif
						</td>
						<td><?php if($advert->status == 1) { echo 'Active'; }else{ echo 'Inactive'; } ?></td>
						<td>
						<a  data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" onclick="editadvert({{ $advert->id }})"  class="btn btn-xs btn-info" style="margin-right:3px;" id="editadvertbtn{{ $advert->id }}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
						<?php if($advert->status == 1) { ?>
						<a   data-toggle="tooltip" data-placement="top" title="" data-original-title="Disable" onclick="disableadvert({{ $advert->id }})"  id="disableadvertbtn{{ $advert->id }}" class="btn btn-xs btn-danger" style="margin-right:3px;" ><i class="fa fa-times" aria-hidden="true"></i></a>
						<?php }else{ ?>
						<a   data-toggle="tooltip" data-placement="top" title="" data-original-title="Enable" onclick="enableadvert({{ $advert->id }})"  id="enableadvertbtn{{ $advert->id }}" class="btn btn-xs btn-success" style="margin-right:3px;" ><i class="fa fa-check" aria-hidden="true"></i></a>
						<?php } ?>
						</td>
						</tr>
                    @endforeach
                  

                @endif
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
@section('scripts')

<script src="/assets/js/adverts.js"></script>

@endsection