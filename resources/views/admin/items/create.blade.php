@extends('layouts.admin')

@section('panel')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>New Item</h2>
            @include('layouts.errors')
        </div>
        <div class="panel-body">
            <form action="/admin/items" method="POST">
                {{ csrf_field() }}
                @include('admin.items._form')
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-success btn-lg">Create Item</button>
                </div>
            </form>
        </div>
    </div>
@endsection