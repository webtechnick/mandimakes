@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <ul class="nav nav-pills nav-stacked">
                <li role="presentation" {!! MMS::isActive('UsersController@account') !!}><a href="/account"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Account</a></li>
                <li role="presentation" {!! MMS::isActive('UsersController@password') !!}><a href="/account/password"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span> Security</a></li>
                <li role="presentation" {!! MMS::isActive('Orders') !!}><a href="/my-orders"><span class="glyphicon glyphicon-usd" aria-hidden="true"></span> My Orders</a></li>
                <li role="presentation">@include('layouts._logout')</li>
                @if ($user->isAdmin())
                    <li role="presentation"><li><a href="/admin"><span class="glyphicon glyphicon-tasks"></span> Admin</a></li></li>
                @endif
            </ul>
        </div>
        <div class="col-md-9">
            @yield('panel')
        </div>
    </div>
</div>
@endsection
