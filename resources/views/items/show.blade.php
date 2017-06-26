@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>{{ $item->title }} <span class="label label-default pull-right">{{ $item->formattedPrice() }}</span></h1>
                </div>
                <div class="panel-body">
                    @include('items.photos', ['item' => $item])

                    <div class="well">
                        {!! $item->description !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>
                        @if ($item->inStock())
                            <span class="label label-success">In Stock</span>
                        @else
                            <span class="label label-info">Backorder</span>
                        @endif
                    </h3>
                </div>
                <div class="panel-body">
                    <a href="/carts/add/{{ $item->id }}" class="btn btn-primary btn-lg btn-block"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Add To Cart</a>
                    <a href="/commission/{{ $item->id }}/create" class="btn btn-default btn-lg btn-block"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> Commission Request</a>
                    @if ($user AND $user->isAdmin())
                        <a href="{{ $item->adminUrl() }}" class="btn btn-default btn-lg btn-block"><span class="glyphicon glyphicon-edit"></span> Edit</a>
                    @endif
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Related Items</h3>
                </div>
                <div class="panel-body">
                    // TODO
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
