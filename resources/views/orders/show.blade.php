@extends('layouts.dashboard')

@section('panel')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1>Order # {{ $order->id }} <small>({{ $order->statusNice() }})</small></h1>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <h2>Billing</h2>
                    @include('addresses._show', ['address' => $order->billingAddress])
                </div>
                <div class="col-md-6">
                    <h2>Shipping</h2>
                    @include('addresses._show', ['address' => $order->shippingAddress])
                </div>
            </div>

            <h2>Purchased Items</h2>

            @include('orders._itemstable')

            <h2>Order Tracking</h2>

            @if ($order->tracking_number)
                <a href="{{ $order->trackingUrl() }}" target="_blank" class="btn btn-primary btn-lg">Track My Order</a>
            @else
                <p>Your order will be shipped soon.</p>
            @endif
        </div>
    </div>
@endsection