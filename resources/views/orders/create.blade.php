@extends('layouts.app')

@section('content')
<div class="container">
    @include('orders._cart')
    <form action="/checkout" method="POST">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="shipping_id">Select Shipping: </label>
            {{ Form::select('shipping_id', \App\Shipping::listOptions(), null, ['class' => 'form-control','required']) }}
        </div>
        <div class="form-group">
            <label for="special_request">Special Request: <small>Include any details you want to communicate about the order.</small></label>
            <textarea class="form-control" rows="4" name="special_request" id="special_request" rows="10">{{ old('special_request') }}</textarea>
        </div>
        <div class="pull-right">
            {!! Cart::checkout() !!}
        </div>
    </form>
</div>
@endsection