@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <ul class="nav nav-pills nav-stacked">
                <li role="presentation" @if(Route::currentRouteName() == 'account') class="active" @endif><a href="/account"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Account</a></li>
                <li role="presentation" @if(Route::currentRouteName() == 'users.password') class="active" @endif><a href="/account/password"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span> Security</a></li>
                <li role="presentation" @if(Route::currentRouteName() == 'myorders') class="active" @endif><a href="/my-orders"><span class="glyphicon glyphicon-usd" aria-hidden="true"></span> Orders</a></li>
                <li role="presentation">@include('layouts._logout')</li>
            </ul>
        </div>
        <div class="col-md-9">
            @yield('panel')
        </div>
    </div>
</div>
@endsection
