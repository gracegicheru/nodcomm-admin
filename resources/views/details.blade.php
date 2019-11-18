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
                    <h4 class="header" style= "background-color: #2d5986; margin-bottom: 0px; color: white;">Message History Detail</h4>
                    <table class="striped">

                        <thead>

                        </thead>
                        <tbody>

                            <tr>
                                <td style="width:25%; overflow: hidden;text-overflow: ellipsis; white-space: nowrap; word-break:break-all;"  >Time Submitted</td>
                                <td style="width:75%;">{{date('d-m-Y')}}</td>
                            </tr>
                        <tr>

                            <td style="width: 25%;">Total Messages</td>
                            <td style="width:75%;">{{$details->recipients}}</td>
                        </tr>

                        </tbody>

                    </table>

                    <br/>


                    <table id="data-table-simple" class="display">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Recipients</th>
                            <th>Status</th>
                            <th>Message Body</th>

                        </tr>
                        </thead>
                        <tbody id="msg-history">

                            <tr>
                                <td>{{$details->created_at}}</td>

                                <td>
                                    <?php

                                    // Use preg_split() function
                                    $string = $details->phone;
                                    $str_arr = preg_split ("/\,/", $string);
                                    foreach($str_arr as $var)
                                    {
                                        echo $var ."<br/>";
                                    }

                                    ?>
                                </td>
                                <td>{{$details->status}}</td>
                                <td>{{$details->message}}</td>

                            </tr>




                        </tbody>

                    </table>




                </div>
            </div>



        </div>

    </div>





@endsection