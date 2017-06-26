@extends('layouts.admin')

@section('panel')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>New Tag</h2>
            @include('layouts.errors')
        </div>
        <div class="panel-body">
            {{ Form::open(['route' => 'admin.tags.store']) }}
                {{ csrf_field() }}
                @include('admin.tags._form')
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-success btn-lg">Create Tag</button>
                </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection