					@extends('layouts.master')
					@extends('layouts.master')

					@section('content')

					  <!-- Content Wrapper. Contains page content -->
					  <div class="content-wrapper">
						<!-- Content Header (Page header) -->
						<section class="content-header">
						  <h1>
							Online Agents
						  </h1>
						  <ol class="breadcrumb">
							<li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>

							<li class="active"> Online Agents</li>
						  </ol>
						</section>

						<!-- Main content -->
						<section class="content">

						  <div class="row">

							<div class="col-md-12">
								
							  <div class="box box-primary">
								<div class="box-header with-border">
								  <h3 class="box-title">  Online Agents</h3>
								</div>
								<!-- /.box-header -->
								<div class="box-body">

									<ul class="list-group" id="online_agents" style="overflow-y: auto; max-height:400px;padding:0" >
									@if (count($agents) > 0)
										@foreach($agents as $agent)
										<li class="list-group-item clearfix">
											<div class=" " style="width:42px;height:42px;font-size:20px;float:left;line-height: 38px">
												<i class="fa fa-user-o"></i>
											</div>
											<div class="pull-left" style="margin-left: 10px;">
												<span> {{ $agent->name }} </span><br/>
												<small class="text-muted" style="color:#65cea7" ><i class="fa fa-clock-o"></i>  online </small>
											</div>	
										</li>
										@endforeach
									@else
									<li class="list-group-item clearfix"> No online agents</li>
									
									@endif
									</ul>	
		
								</div>
								<!-- /.box-body -->
							  </div>
							  <!-- /.box -->

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

					<script src="/assets/js/online_agents.js"></script>

					@endsection