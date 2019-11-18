@extends('layouts.new_master')
@section('styles')
    <link rel="stylesheet" href="{{ url('int-tel/css/intlTelInput.css')}}">
    <link rel="stylesheet" href="{{ url('assets/css/custom.css')}}">
@endsection('styles')
@section('content')
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
                        <h5 class="breadcrumbs-title">Users</h5>
                        <ol class="breadcrumbs">
                            <li><a href="/">Dashboard</a></li>

                            <li class="active">Users</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="section">
                <div class="row">
                    <div class="col s12">
                            <h4 class="header2 left">Your Tickets</h4>
                            <div class="right2" style="float: right;">
                                <a class="btn light-green black-text lighten-4 waves-effect waves-light right2 modal-trigger" href="#modal" ><i class="material-icons left"  > add</i> Raise a Ticket</a>
                            </div>
                        </div>
                        <div style="clear: both;"></div>


                            <div id="striped-table"  class="card card card-default scrollspy" style="margin-top: 15px; margin-right: 15px; margin-left: 15px; margin-bottom:15px;">
                                <div class="card-content">
                                    <div class="row">
                                        <div class="col s12" style="padding-top: 10px;">
                                            <table id="data-table-simple" class="display">
                                                <thead>
                                                <tr>
                                                    <th>Title</th>
                                                    <th>Department</th>
                                                    <th>Priority</th>
                                                    <th>Message</th>
                                                    <th>Status</th>
                                                    <th>Date</th>


                                                </tr>
                                                </thead>
                                                <tbody id="msg-history">
                                                @foreach($tickets as $ticket)
                                                    <tr>
                                                        <td>{{$ticket->title}}</td>
                                                        <td>{{$ticket->department}}</td>
                                                        <td>{{$ticket->priority}}</td>
                                                        <td>{{$ticket->message}}</td>
                                                        <td>{{$ticket->status}}</td>
                                                        <td>{{$ticket->created_at}}</td>

                                                    </tr>
                                                    @endforeach





                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>




                    </div>
                </div>
            </div>

        </div>




        <div id="modal" class="modal">
            <div class="modal-content">
                <div class="row">
                    <div class="col s12">
                        <div class="card-panel">

                            <div class="row">
                                <form role="form" method="post" id="techicalform">
                                    {{ csrf_field() }}
{{--                                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">--}}
                                    <div class="row">
                                        <div class="col s3">
                                            <div class="" style="margin-top: 16px;"><i class="material-icons left">loyalty</i>Title</div>
                                        </div>
                                        <div class="input-field2 col s9">
                                            <input type="text" class="form-control" id="title" name="title" placeholder="Title"/>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom:15px;">
                                        <div class="col s3">
                                            <div class="" style="margin-top: 16px;"><i class="material-icons left">card_travel</i>Department</div>
                                        </div>
                                        <div class="input-field col s9">
                                            <select id="department" name="department">
                                                <option value="one" disabled selected>Choose the Department</option>
                                                <option value="technical_department">Technical Department</option>
                                                <option value="sales_department">Sales Department</option>
                                                <option value="api_department">Api Department</option>
                                            </select>

                                        </div>

                                    </div>
                                    <div class="row" style="margin-bottom:15px;">
                                        <div class="col s3">
                                            <div class="" style="margin-top: 16px;"><i class="material-icons left">report</i>Priority</div>
                                        </div>

                                        <div class="input-field col s9">
                                            <select id="priority" name="priority">
                                                <option value="two" disabled selected>Choose the Priority</option>
                                                <option value="low">low</option>
                                                <option value="medium">medium</option>
                                                <option value="high">high</option>
                                            </select>


                                        </div>


                                    </div>
                                    <div class="row" style="margin-bottom:15px;">
                                        <div class="col s3">
                                            <div class="" style="margin-top: 16px;"><i class="material-icons left">mail</i>Message</div>
                                        </div>
                                        <div class="input-field2 col s9" style="
					position: relative;
				">
                                            <textarea type="text"  name="message" id="message"  class="materialize-textarea" placeholder="type your message"></textarea>
                                        </div>
                                    </div>


                                            <div class="input-field2 col s12">
                                                <button id="ticketbtn" class="btn green waves-effect waves-light right" type="submit">
                                                    <i class="material-icons left">save</i>  Submit A Ticket
                                                </button>
                                            </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
            </div>
        </div>
    </section>


@endsection
@section('scripts')
    <script src="{{ url('/assets/js/support_ticket.js') }}"></script>

@endsection
