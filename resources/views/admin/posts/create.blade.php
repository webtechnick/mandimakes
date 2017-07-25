@extends('layouts.admin')

@section('panel')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>New Post</h2>
            @include('layouts.errors')
        </div>
        <div class="panel-body">
            {{ Form::open(['route' => 'admin.posts.store']) }}
                @include('admin.posts._form')
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-success btn-lg">Create Post</button>
                </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection