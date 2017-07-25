@extends('layouts.admin')

@section('actions')
    <li><a href="{{ route('admin.posts.show', $post) }}"><span class="glyphicon glyphicon-search"></span> Preview</a></li>
@endsection

@section('panel')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>Edit Post</h2>
            @include('layouts.errors')
        </div>
        <div class="panel-body">
            {{ Form::model($post, ['route' => ['admin.posts.update', $post], 'method' => 'PATCH']) }}
                @include('admin.posts._form')
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-success btn-lg">Update Post</button>
                </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection