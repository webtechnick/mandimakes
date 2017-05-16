@extends('layouts.app')

@section('content')
<div class="container">
    @include('orders._cart')

    <form action="/checkout" method="POST">

    </form>
</div>
@endsection