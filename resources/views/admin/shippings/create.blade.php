@extends('layouts.admin')

@section('panel')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>New Shipping</h2>
            @include('layouts.errors')
        </div>
        <div class="panel-body">
            <form action="{{ route('admin.shippings.store') }}" method="POST">
                {{ csrf_field() }}
                @include('admin.shippings._form')
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-success btn-lg">Create Shipping</button>
                </div>
            </form>
        </div>
    </div>
@endsection