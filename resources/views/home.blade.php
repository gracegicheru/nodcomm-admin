@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    Users
                    @if (count($users) > 0)
                        @foreach($users as $user)
                        <div class="well">
                            <h3><a href="/register/{{ $user->id }}">{{ $user->name }}</a></h3>
                        </div>
                        @endforeach
                  
                    @else
                        I don't have any records!
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
