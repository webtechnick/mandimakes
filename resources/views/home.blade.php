@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <ul class="nav nav-pills nav-stacked">
                <li role="presentation" class="active"><a href="#"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Account</a></li>
                <li role="presentation"><a href="/my-orders"><span class="glyphicon glyphicon-usd" aria-hidden="true"></span> Orders</a></li>
                <li role="presentation">@include('layouts._logout')</li>
            </ul>
        </div>
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome!</div>

                <div class="panel-body">
                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
