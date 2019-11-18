
@extends('layouts.master')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="font-weight:normal">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
	  {{$sites->name }} Visitors 
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

          <div class="box box-primary">

            <div class="box-body">
				<table class="table table-bordered table-condensed table-hover table-striped table-vertical-center" id="dataTable">
                <thead>
                <tr>
				  <th>#</th>
                  <th>Website</th>
                  <th>Website ID</th>
				  <th>Website URL</th>
				  <th>Visitors</th>
				  <th>Action</th>
                </tr>
                </thead>
                <tbody>
				@if (count($sites->sites) > 0)
					
					@foreach($sites->sites as $site)
						<tr>
						<td>{{ $loop->iteration }}</td>
						<td>{{ $site->name }}</td>
						<td>{{ $site->site_id }}</td>
						<td>{{ $site->url }}</td>
						<td>{{ $site->totalvisitors }}</td>
						<td>
							<?php 
								$url = '/website/'.$site->id;
							?>
								<a data-toggle="tooltip" data-placement="top" title="" data-original-title="View Visitors" href="<?php echo url($url);?>" class="btn btn-xs btn-info"> <i class="fa fa-eye" aria-hidden="true"></i></a>	
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
