@extends('layouts.admin')

@section('panel')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>Edit Shipping</h2>
            @include('layouts.errors')
        </div>
        <div class="panel-body">
            {{ Form::model($shipping, ['route' => ['admin.shippings.edit', $shipping], 'method' => 'PATCH']) }}
                @include('admin.shippings._form', ['shipping' => $shipping])
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-success btn-lg">Edit Shipping</button>
                </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection