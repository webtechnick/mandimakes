@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <ul class="nav nav-pills nav-stacked">
                <li role="presentation" {!! MMS::isActive('AdminOrders') !!}><a href="/admin"><span class="glyphicon glyphicon-usd" aria-hidden="true"></span> Orders</a></li>
                <li role="presentation" {!! MMS::isActive('AdminItems') !!}><a href="/admin/items"><span class="glyphicon glyphicon-list"></span> Items</a> </li>
                <li role="presentation" {!! MMS::isActive('AdminTags') !!}><a href="/admin/tags"><span class="glyphicon glyphicon-tags"></span> Tags</a></li>
                <li role="presentation" {!! MMS::isActive('AdminShippings') !!}><a href="/admin/shippings"><span class="glyphicon glyphicon-road"></span> Shippings</a></li>
                <li role="presentation" {!! MMS::isActive('AdminUsers') !!}><a href="/admin/users"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Users</a></li>
                <li role="presentation">@include('layouts._logout')</li>
                <li class="divider"><hr></li>
                @yield('actions')
            </ul>
        </div>
        <div class="col-md-9">
            @yield('panel')
        </div>
    </div>
</div>
@endsection
