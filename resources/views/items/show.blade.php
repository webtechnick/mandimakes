@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-9">
            <h1>{{ $item->title }}</h1>
            <p>{{ $item->description }}</p>
        </div>
        <div class="col-md-3">
            <p>{{ $item->formattedPrice() }}</p>
            <a href="/carts/add/{{ $item->id }}" class="btn btn-primary btn-lg btn-block"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Add To Cart</a>
        </div>
    </div>
</div>

@endsection