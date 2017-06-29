@extends('layouts.admin')

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

            {{ Form::model($order, ['route' => ['admin.orders.update', $order], 'method' => 'PATCH']) }}
                <div class="form-group">
                    {{ Form::text('tracking_number', null, ['placeholder' => 'Tracking Number', 'class' => 'form-control']) }}
                </div>
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-success btn-lg">Update Order</button>
                </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection