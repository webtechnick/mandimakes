@extends('layouts.app')

@section('content')
<div class="container">
    <form action="/checkout" method="POST">
        @include('orders._cart')

        {{ csrf_field() }}
        <div class="form-group">
            <label for="shipping_id">Select Shipping: </label>
            <select name="shipping_id" id="shipping_id" class="form-control">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
            </select>
        </div>
        <div class="form-group">
            <label for="special_request">Special Request: </label>
            <textarea class="form-control" name="special_request" id="special_request" rows="10">{{ old('special_request') }}</textarea>
        </div>
        <div class="pull-right">
            {!! Cart::checkout() !!}
        </div>
    </form>
</div>
@endsection