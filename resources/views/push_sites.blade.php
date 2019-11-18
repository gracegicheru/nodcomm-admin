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
                  <h5 class="breadcrumbs-title">Websites</h5>
                  <ol class="breadcrumbs">
                    <li><a href="/">Dashboard</a></li>
                    
                    <li class="active">Websites</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <!--breadcrumbs end-->
          <!--start container-->
          <div class="container">
            <div class="section">

           
        <div class="row addsitewrapper" style="display:none;">
          <div class="card-panel">
            <div class="row" >
              <p>This service is coming soon</p>
              <h4 class="header2">Add Website</h4>
                <div class="pull-right">
                <span class="fa fa-times close-site" style="cursor:pointer;"></span>
              </div>
            </div>
             
                    <div class="row">
                      @if(empty($prechat))
          <form role="form" method="post" action="<?php echo URL::route('addpushsite') ?>" id="addsitefrm">
          {{ csrf_field() }}
                     
                        <div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">account_circle</i>
                            <input type="text" class="form-control" name="name" id="name" >
                            <label for="name">Domain Name</label>
                          </div>
                        </div>
                        <div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">email</i>
                            <input type="text" class="form-control" name="url" id="url">
                            <label for="url">URL</label>
                          </div>
                        </div>
            <div class="row">
                          <div class="row">
                            <div class="input-field col s12">
                              <!--<button id="registerbtn" class="btn cyan waves-effect waves-light right" type="submit">
                                <i class="material-icons right">add</i>  Register
                              </button>-->
                <div class="pull-right">
                <button class="btn btn-success" id="addsitebtn">Add Site</button>
                </div>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
          </div>
        </div>
        <div class="row  hide code">
          <div class="col s12">
            <div class="card-panel">

              <div class="row">
                <hr style="margin-top: 10px;margin-bottom: 10px">
                <!-- <code style="padding:0;background-color:inherit;"></code> -->
                <textarea readonly="readonly" class="form-control" style="width:500px;height:200px;"></textarea>
              </div>
            </div>
          </div>
        </div>
      
              <div class="row">
          <div class="col s12">
           <div class="pull-right">
            <button class="btn btn-default showaddsite" style="margin-right:10px;"><i class="fa fa-plus"></i> Add Website</button>
            <a class="btn btn-default" href="{{ url('/push/campaigns') }}"><i class="fa fa-plus"></i> Create a push campaign</a>
          </div>
          </div>
                <div class="col s12">
          <div id="striped-table">
          <h4 class="header">Websites</h4>
          <div class="row">
            <div class="col s12">
            <table id="data-table-simple" class="responsive-table display" cellspacing="0">
              <thead>
              <tr>
                              <th>#</th>
                              <th>Name</th>
                              <th>URL</th>
                              <th>Identifier</th>
                              <th>Added On</th>
                <th>Action</th>
              </tr>
              </thead>
              <tfoot>
              <tr>
                              <th>#</th>
                              <th>Name</th>
                              <th>URL</th>
                              <th>Identifier</th>
                              <th>Added On</th>
                <th>Action</th>
              </tr>
              </tfoot>
                        <tbody id="allsitestbl">
                              <!--@if(!$sites->isEmpty())-->

                                @foreach($sites as $key => $site)
                                    <tr>
                                      <td>{{ $key+1 }}</td>
                                      <td>{{ $site->name }}</td>
                                      <td>{{ $site->url }}</td>
                                      <td>{{ $site->site_id }}</td>
                                      <td>{{ $site->created_at }}</td>
                                      <td>
                                        <a class="btn btn-primary btn-xs" href="{{ url('/push/'.$site->name) }}"><i class="fa fa-eye"></i></a>
                                      </td>
                                    </tr>
                                @endforeach

                           <!-- @else
                                <tr>
                                  <td class="text-center" colspan="6"><div style="padding:20px;">No Websites added</div></td>
                                </tr>
                            @endif-->
              </tbody>
            </table>
            </div>
            @if(!empty($messages))
            <div class="col s12">
            <div class="center">
                <button class="btn btn-default" id="load-more3" style="width: 30%;">Load more</button>
                <button class="btn btn-default hide" id="load-more4" style="width: 30%;">Load more</button>
                <button class="btn btn-default hide" id="load-more5" style="width: 30%;">Load more</button>
            </div>
            </div>
            @endif
          </div>
          </div>
                </div>

              </div>
            
            </div>

          </div>
          <!--end container-->
        </section>
        <!-- END CONTENT -->
    

    @endsection
@section('scripts')
  <script type="text/javascript">
    var URL = '{{ url('/') }}';
  </script>
  <script src="/assets/js/push_sites.js"></script>
@endsection