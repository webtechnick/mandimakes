@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                @if ($isAdmin)
                <div class="pull-right">
                    <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-default">Edit</a>
                </div>
                @endif
                <h1>
                    {!! $post->renderTitle() !!}
                </h1>
            </div>
            <div class="panel-body">
                {!! $post->body !!}
            </div>
        </div>
    </div>
@endsection