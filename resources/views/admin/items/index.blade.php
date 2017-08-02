@extends('layouts.admin')

@section('actions')
    <li><a href="/admin/items/create"><span class="glyphicon glyphicon-plus"></span> New Item</a></li>
    <li><a href="/admin/items/clear_new"><span class="glyphicon glyphicon-ban-circle"></span> Clear New</a></li>
@endsection

@section('panel')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-9">
                    <h2>Items</h2>
                </div>
                <div class="col-md-3">
                    <form action="/admin/items" method="GET" class="form-inline">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Item Filter" value="{{ $filter }}">
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
                    <th class="text-center">Picture</th>
                    <th class="hidden-sm hidden-xs text-left">Description</th>
                    <th class="text-center">Qty</th>
                    <th class="text-center">Cart</th>
                    <th class="text-center">Price</th>
                    <th class="text-right">Actions</th>
                </tr>
            @foreach($items as $item)
                <tr>
                    <td class="text-center">{!! $item->pic('50'); !!} <br> {{ $item->statusNice() }}</td>
                    <td class="hidden-sm hidden-xs text-left">{{ $item->short_description }}</td>
                    <td class="text-center">{{ $item->qty }}</td>
                    <td class="text-center">{{ $item->cart_count }}</td>
                    <td class="text-center">{{ $item->formattedPrice() }}</td>
                    <td class="col-md-2 text-right">
                        <div class="btn-group">
                            <a href="{{ $item->adminUrl() }}" class="btn btn-info"> Edit</a>
                            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route('admin.items.toggle_new', $item) }}">Toggle New</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="/admin/items/delete/{{ $item->id }}" class="confirm" confirm-message="Are you sure you want to delete this item?">Delete</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
            </table>
        </div>
    </div>

    <div class="text-center">{{ $items->links() }}</div>
@endsection