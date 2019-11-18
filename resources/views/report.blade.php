@extends('layouts.new_master')
  @section('styles')
  <link rel="stylesheet" href="{{ url('assets/css/custom.css')}}">
  <link rel="stylesheet" href="{{ url('int-tel/css/intlTelInput.css')}}">
  @endsection('styles')
  @section('content')


                 <div id="striped-table"  class="card card card-default scrollspy" style="margin-top: 25px; margin-right: 25px; margin-left: 25px; margin-bottom: 50px;">
               <div class="card-content">

                <div class="row">
                  <div class="col s12">
                     <h4 class="header" style= "text-align: center; margin-bottom: 0px; ">Messages Report</h4>
                    <table class="striped">
                      <thead>
                        <tr id="messages" style= "background-color: #2d5986 ">
                          <th data-field="id" style="color: white;">Recipients</th>
                          <th data-field="name" style="color: white;">Messages Preview</th>
                          <th data-field="price" style="color: white;">Status</th>
                          <th data-field="price" style="color: white;">Time Sent</th>
                        </tr>
                      </thead>
                      <tbody>
                        
                          @foreach($message_reports as $message_report)
                          <tr>
                          <td style="width:25%; overflow: hidden;text-overflow: ellipsis; white-space: nowrap; word-break:break-all;"  >{{$message_report->phone}}</td>
                          <td style="width: 45%;">{{$message_report->message}}</td>
                          <td style="width: 15%;">{{$message_report->status}}</td>
                          <td style="width: 15%;">{{$message_report->created_at}}</td>
                          </tr>
                        @endforeach
                        
                      </tbody>
                    </table>
                 <div style="text-decoration-color: blue">   {{ $message_reports->links() }} </div>
               
                  </div>
                </div>
              </div>

              </div>
             
          
   
        

@endsection