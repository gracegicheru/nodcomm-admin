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
                        <h5 class="breadcrumbs-title">SMS History</h5>
                        <ol class="breadcrumbs">
                            <li><a href="/">Dashboard</a></li>

                            <li class="active">SMS History</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!--breadcrumbs end-->
        <!--start container-->
        <div class="container">
            <div class="section">
                <div class="row filter-wrapper" style="display:none;">
                    <div class="card-panel">
                        <form role="form" method="post" action="<?php echo URL::route('apply_company_filters') ?>" id="ApplyCompanyfilterform">
                            {{ csrf_field() }}
                            <div class="row" >
                                <h4 class="header2">Add a filter</h4>
                                <div class="pull-right">
                                    <span class="fa fa-times close-filters" style="cursor:pointer;"></span>
                                </div>
                            </div>
                            <div class="row" style="margin-right: -10px;margin-left: -10px;">
                                <div class="col s12 m4 l4">

                                    <label>From</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right" id="datepicker" name="datepicker" value="<?php
                                        echo $date;?>"/>
                                    </div>
                                </div>
                                <div class="col s12 m4 l4">
                                    <label>To:</label>

                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right" id="datepicker1" name="datepicker1" value="<?php
                                        echo $date;?>">
                                    </div>
                                </div>
                                <div class="col s12 m4 l4">
                                    <label for="status-filter">Status</label>
                                    <div style="margin-top:21px">
                                        <select name="statusfilter" id="status-filter">
                                            <option value="sent">Sent</option>
                                            <option value="fail">Failed</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="loading-overlay loading-filters"></div>
                            </div>
                            <div class="row" style="margin-right: -10px;margin-left: -10px;margin-top: 20px;">
                                <div class="col-md-12">
                                    <div class="clearfix">
                                        <div class="pull-right">
                                            <button class="btn btn-primary" id="apply-filter"><i class="fa fa-check"></i> Apply Filters</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div id="striped-table"  class="card card card-default scrollspy" style="margin-top: 15px; margin-right: 15px; margin-left: 15px; margin-bottom:15px;">
                    <div class="card-content">
                        <div class="row">
                            <div class="col s12">
                                <div id="striped-table">
                                    <h4 class="header">SMS History</h4>
                                    <div class="row">
                                        <div class="col s12 search">
                                            <form role="form" method="post" action="<?php echo URL::route('search_sms') ?>" id="searchSMSForm1">
                                                {{ csrf_field() }}
                                                <input type="text" name="search" class="header-search-input z-depth-2" placeholder="Search SMS by number"/><button class="btn btn-default " style="margin-right:10px;" id="sms-search-term1"> Search sms</button>
                                            </form>
                                        </div>

                                        <div class="col s12">

                                            <div class="pull-right">
                                                <button class="btn btn-default addfilter" style="margin-right:10px;"><i class="fa fa-plus"></i> Add Filters</button>
                                            </div>
                                        </div>

                                            <div class="col s12" style="padding-top: 10px;">
                                                <table id="data-table-simple" class="display">
                                                    <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Message</th>
                                                        <th>To</th>
                                                        <th>status</th>
                                                        <th></th>

                                                    </tr>
                                                    </thead>
                                                    <tbody id="msg-history">
                                                    @foreach($messages as $message)
                                                    <tr>
                                                        <td style="width:20%;">{{$message->created_at}}</td>
                                                        <td style="width:30%;">{{$message->message}}</td>
                                                        <td style="width:30%;">
                                                        <?php

                                                                        // Use preg_split() function
                                                            $string = $message->phone;
                                                            $str_arr = preg_split ("/\,/", $string);
                                                            foreach($str_arr as $var)
                                                            {
                                                                echo $var ."<br/>";
                                                            }

                                                            ?>
                                                        </td>
                                                        <td style="width:10%;">{{$message->status}}</td>
                                                        <td style="width:10%;"><a style="text-decoration: underline; width:10%; text-align: center;" href="/showDetails/{{$message->id}}">read more</a></td>
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







        <!--end container-->
    </section>
    <!-- END CONTENT -->



@endsection
@section('scripts')
    <script type="text/javascript">
        var URL = '{{ url('/') }}';
        var csrf = "{{ csrf_token() }}";
        var paymentemail = "{{ Auth::user()->email }}";
    </script>

    <script type="text/javascript">
        $('#datepicker').pickadate({
            selectMonths: true, // Creates a dropdown to control month
            selectYears: 15, // Creates a dropdown of 15 years to control year,
            today: 'Today',
            clear: 'Clear',
            close: 'Ok',
            closeOnSelect: false ,// Close upon selecting a date,
            format: 'yyyy-mm-dd',
            formatSubmit: 'yyyy-mm-dd'
        });
        $('#datepicker1').pickadate({
            selectMonths: true, // Creates a dropdown to control month
            selectYears: 15, // Creates a dropdown of 15 years to control year,
            today: 'Today',
            clear: 'Clear',
            close: 'Ok',
            closeOnSelect: false ,// Close upon selecting a date,
            format: 'yyyy-mm-dd',
            formatSubmit: 'yyyy-mm-dd'
        });
    </script>

    <script src="{{ url('/assets/js/messages.js') }}"></script>
@endsection