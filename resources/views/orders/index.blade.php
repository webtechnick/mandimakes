@extends('layouts.dashboard')

@section('panel')
    <div class="panel panel-default">
        <div class="panel-heading">
            My Orders
        </div>
        <div class="panel-body">
            <table class="table table-striped">
                <tr>
                    <th>ID</th><th>Status</th><th>Amount</th><th>Date</th>
                </tr>
                @foreach ($orders as $order)
                    <tr>
                        <td> {{ $order->id }}</td>
                        <td> Pending </td>
                        <td> {{ $order->total_dollars }} </td>
                        <td> {{ $order->created_at->diffForHumans() }} </td>
                    </tr>
                @endforeach
            </table>
            {{ $orders->links() }}
        </div>
    </div>
@endsection