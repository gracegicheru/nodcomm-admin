@extends('layouts.master')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header clearfix">
      <ol class="breadcrumb" style="position: initial;">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Websites</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">


        <div class="row hide code">
            <div class="col-md-12">
                <div class="box box-widget">
                    <div class="box-body" style="font-weight:normal;">
                        <div>Add the code below to the footer section of the website</div>
                        <hr style="margin-top: 10px;margin-bottom: 10px">
                        <!-- <code style="padding:0;background-color:inherit;"></code> -->
                        <textarea readonly="readonly" class="form-control" style="width:500px;height:200px;"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header clearfix" style="border-bottom:1px solid #f4f4f4;">
                      <h3 class="box-title" style="font-size: 26px;">Websites</h3>

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding" style="font-weight:normal;">
                      <table class="table table-hover">
                        <thead>
                            <tr>
                              <th>#</th>
                              <th>Name</th>
                              <th>URL</th>
                              <th>Identifier</th>
                              <th>Added On</th>
                              <th></th>
                            </tr>
                        </thead>
                        <tbody id="allsitestbl">
                            @if(count($sites) > 0)

                                @foreach($sites as $key => $site)
                                    <tr>
                                      <td>{{ $key+1 }}</td>
                                      <td>{{ $site->name }}</td>
                                      <td>{{ $site->url }}</td>
                                      <td>{{ $site->site_id }}</td>
                                      <td>{{ $site->created_at }}</td>
                                      <td>
                                        <a class="btn btn-primary btn-xs" href="{{ url('/sites/'. $site->id) }}"><i class="fa fa-eye"></i></a>
                                      </td>
                                    </tr>
                                @endforeach

                            @else
                                <tr>
                                  <td class="text-center" colspan="5"><div style="padding:20px;">No Websites added</div></td>
                                </tr>
                            @endif
                            
                        </tbody>
                      </table>
                    </div>
                    <!-- /.box-body -->
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
  <script src="/assets/js/sites.js"></script>

    <!--Begin NodComm Chat Code--><script type='text/javascript'>var NodChat = {site_id: 90117};var NodChat_lc = document.createElement('script');NodChat_lc.type = 'text/javascript';NodChat_lc.async = true;NodChat_lc.src = 'http://localhost:8000/chat/init?siteId=' + NodChat.site_id;document.body.appendChild(NodChat_lc);</script><!--End NodComm Live Chat Code-->
@endsection