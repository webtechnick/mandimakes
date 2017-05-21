@extends('layouts.admin')

@section('panel')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>Edit Item</h2>
            @include('layouts.errors')
        </div>
        <div class="panel-body">
            <form action="/admin/items/edit/{{ $item->id }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                @include('admin.items._form', ['item' => $item])
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-success btn-lg">Edit Item</button>
                </div>
            </form>
        </div>
    </div>
@endsection