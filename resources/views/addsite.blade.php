@extends('layouts.master')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add New Site
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Sites</a></li>
        <li class="active">Add New Site</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	<div class="row">
    		<div class="col-md-12">
    			<div class="msgbox"></div>
    			<div class="box box-widget">
    				<div class="box-body">
    					<form role="form" method="post" action="<?php echo URL::route('addsite') ?>">
			              <div class="box-body">
			                <div class="form-group">
			                  <label for="name">Name</label>
			                  <input type="text" class="form-control" id="name" placeholder="Website Name">
			                </div>
			                <div class="form-group">
			                  <label for="url">Password</label>
			                  <input type="text" class="form-control" id="url" placeholder="http://example.com">
			                </div>
			                <div class="form-group">
			                  <label for="code">Code</label>
			                  <textarea class="form-control" id="code" style=""></textarea>
			                </div>
			              </div>
			              <!-- /.box-body -->

			              <div class="box-footer">
			                <button type="submit" class="btn btn-primary">Submit</button>
			              </div>
			            </form>
    				</div>
    			</div>
    		</div>
    	</div>
    </section>
</div>

@endsection