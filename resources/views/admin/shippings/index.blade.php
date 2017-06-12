@extends('layouts.admin')

@section('actions')
    <li><a href="/admin/shippings/create"><span class="glyphicon glyphicon-plus"></span> New Shipping</a></li>
@endsection

@section('panel')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-9">
                    <h2>Shippings</h2>
                </div>
                <div class="col-md-3">
                    <form action="/admin/shippings" method="GET" class="form-inline">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Shipping Filter" value="{{ $filter }}">
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
                    <th class="text-left">Type</th>
                    <th class="text-left">Name</th>
                    <th class="text-center">Price</th>
                    <th class="text-right">Actions</th>
                </tr>
            @foreach($shippings as $shipping)
                <tr>
                    <td class="text-left">{{ $shipping->type->name }}</td>
                    <td class="text-left">{{ $shipping->name }}</td>
                    <td class="text-center">{{ $shipping->formattedPrice() }}</td>
                    <td class="col-md-2 text-right">
                        <div class="btn-group">
                            <a href="{{ $shipping->adminUrl() }}" class="btn btn-info"> Edit</a>
                            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu">
                                <li role="separator" class="divider"></li>
                                <li><a href="/admin/shippings/delete/{{ $shipping->id }}" class="confirm" confirm-message="Are you sure you want to delete this shipping?">Delete</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
            </table>
        </div>
    </div>

    <div class="text-center">{{ $shippings->links() }}</div>
@endsection