@extends('layouts.dashboard')

@section('panel')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1>My Orders</h1>
        </div>
        <div class="panel-body">
            <table class="table table-striped">
                <tr>
                    <th class="text-left">Date</th>
                    <th class="text-center">Items</th>
                    <th class="text-right">Total</th>
                    <th class="col-md-2 text-right">Actions</th>
                </tr>
                @foreach ($orders as $order)
                    <tr>
                        <td class="text-left"> {{ $order->created_at->diffForHumans() }} (Pending) </td>
                        <td class="text-center"> // TODO </td>
                        <td class="text-right"> $ {{ $order->total_dollars }} </td>
                        <td class="col-md-2 text-right">
                            <div class="btn-group">
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-info"> View</a>
                                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Duplicate</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="#" class="confirm" confirm-message="Are you sure you want to cancel this order?">Cancel Order</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
            {{ $orders->links() }}
        </div>
    </div>
@endsection