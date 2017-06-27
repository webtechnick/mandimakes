@extends('layouts.admin')

@section('panel')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-9">
                    <h2>Orders</h2>
                </div>
                <div class="col-md-3">
                    <form action="/admin/orders" method="GET" class="form-inline">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Order Filter" value="{{ $filter }}">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <table class="table table-striped">
                <tr>
                    <th class="text-center">Status</th>
                    <th class="text-center">Sales</th>
                    <th class="hidden-sm hidden-xs text-left">Customer</th>
                    <th class="text-center">Total</th>
                    <th class="text-right">Actions</th>
                </tr>
            @foreach($orders as $order)
                <tr>
                    <td class="text-center"> {{ $order->statusNice() }} </td>
                    <td class="text-left"> @include('orders._sales') </td>
                    <td class="hidden-sm hidden-xs text-left"> {{ $order->email }} </td>
                    <td class="text-center">{{ $order->formattedPrice() }}</td>
                    <td class="col-md-2 text-right">
                        <div class="btn-group">
                            <a href="{{ $order->adminUrl() }}" class="btn btn-info"> Edit</a>
                            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="/admin/orders/{{ $order->id }}/edit">Update Tracking</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="/admin/orders/delete/{{ $order->id }}" class="confirm" confirm-message="Are you sure you want to delete this order?">Delete</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
            </table>
        </div>
    </div>

    <div class="text-center">{{ $orders->links() }}</div>
@endsection