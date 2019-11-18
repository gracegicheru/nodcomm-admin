@extends('layouts.master')

@section('styles')

<link rel="stylesheet" href="{{ url('/assets/css/admin.css') }}">

@endsection

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header clearfix">
      <ol class="breadcrumb" style="position: initial;">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Email History</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row filter-wrapper" style="display:none;">
        <div class="col-md-12">
          <div class="box box-widget">
            <div class="box-header clearfix" style="border-bottom:1px solid #f4f4f4;">
              <h3 class="box-title" style="font-size: 26px;">Add a filter</h3>
              <div class="pull-right">
                  <span class="fa fa-times close-filters" style="cursor:pointer;"></span>
              </div>
            </div>
            <div class="box-body">
              <div class="row" style="margin-right: -10px;margin-left: -10px;">
                <div class="col-md-4">
                  <label for="gateways-filter">Gateway</label>
                  <select name="gatewaysfilter" id="gateways-filter" class="form-control">
                  </select>
                </div>
                <div class="col-md-4">
                  <label for="sites-filter">Company</label>
                  <select name="sitesfilter" id="sites-filter" class="form-control">
                  </select>
                </div>
                <div class="col-md-4">
                  <label for="status-filter">Status</label>
                  <select name="statusfilter" id="status-filter" class="form-control">
                    <option value="all">All</option>
                    <option value="success">Sent</option>
                    <option value="error">Failed</option>
                  </select>
                </div>
                <div class="loading-overlay loading-filters"></div>
              </div>
              <div class="row" style="margin-right: -10px;margin-left: -10px;margin-top: 20px;">
                <div class="col-md-12">
                  <div class="clearfix">
                    <div class="pull-right">
                      <button class="btn btn-primary apply-filter"><i class="fa fa-check"></i> Apply Filters</button>
                      <button class="btn btn-default clear-filter"><i class="fa fa-times"></i> Clear Filters</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="box box-widget">
            <div class="box-header clearfix" style="border-bottom:1px solid #f4f4f4;">
              <h3 class="box-title" style="font-size: 26px;">Email History</h3>
              <div class="pull-right">
                  <button class="btn btn-default addfilter" style="margin-right:10px;"><i class="fa fa-plus"></i> Add Filters</button>
			  </div>
            </div>
            <div class="box-body">
              @if(count($messages) > 0)
                <div class="box-body table-responsive no-padding">
                  <table id="dataTable7" class="table table-hover">
                    <thead>
                      <th>Date</th>
                      <th>Message</th>
                      <th>To</th>
                      <th>Gateway</th>
                      <th>Company</th>
                      <th>Status</th>
                    </thead>
                    <tbody id="msg-history">
                      @foreach($messages as $message)
                        <tr>
                          <td>{{ $message->created_at }}</td>
                          <td>{{ $message->message }}</td>
                          <td>{{ $message->email }}</td>
                          <td>{{ $message->emailgateway->name }}</td>
                          <td>{{ $message->site->name }}</td>
                          <td>
                            @if($message->status == "success")
                              <span class="label label-success">Sent</span>
                            @else
                              <span class="label label-danger">Failed</span>
                            @endif
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              @else
                <div class="text-center">
                  <div style="padding: 40px;">No email sent yet</div>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </section>
</div>

@endsection

@section('scripts')

<script type="text/javascript">
  var URL = '{{ url('/') }}';
</script>
<script src="{{ url('/assets/js/emails.js') }}"></script>

@endsection