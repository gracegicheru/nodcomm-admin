
@extends('layouts.master')
@section('styles')
<link rel="stylesheet" href="/assets/css/custom.css">
@endsection('styles')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="font-weight:normal">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Translation
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
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-12 connectedSortable">
	
          <div class="box box-primary" >
            <div class="box-body">
              <table id="dataTable" class="table table-bordered table-striped">
                <thead>
                <tr class="no-border">
                  <th>Key</th>
                  <th>Value</th>
				  <th>Action</th>
                </tr>
                </thead>
                <tbody>
				@if (isset($file) && count($file) > 0)
					
					@foreach($file as $key => $value)
						<tr>
						<td>{{ $key }}</td>
					    <td><span id="<?php echo 'settingspan'.$key;?>"><?php if(strlen($value ) > 100){echo substr($value , 0, 100)."...";}else{echo $value ;} ?></span><textarea  style="width:100%" class="form-control hidden" id="<?php echo 'txtArea'.$key;?>"   style="overflow-y: auto;"><?php echo $value ; ?></textarea></td>
						<td>
							<a  data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" onclick="editsetting('{{ $key}}')"  class="btn btn-xs btn-info" style="margin-right:3px;" id="editsettingbtn{{ $key }}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
							<a  data-toggle="tooltip" data-placement="top" title="" data-original-title="Save" onclick="savesetting('{{ $key }}')"  class="btn btn-xs btn-success hidden" style="margin-right:3px;" id="savesettingbtn{{$key }}"><i class="fa fa-floppy-o" aria-hidden="true"></i></a>
							<input  id="<?php echo 'lang_code'.$key;?>" type="hidden" value="{{$lang_code}}">
						</td>
						</tr>
                    @endforeach
                  

                @endif
                </tfoot>
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

<script src="/assets/js/translation.js"></script>

@endsection