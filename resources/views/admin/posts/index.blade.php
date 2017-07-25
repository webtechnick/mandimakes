@extends('layouts.admin')

@section('actions')
    <li><a href="/admin/posts/create"><span class="glyphicon glyphicon-plus"></span> New Post</a></li>
@endsection

@section('panel')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-9">
                    <h2>Posts</h2>
                </div>
                <div class="col-md-3">
                    <form action="/admin/posts" method="GET" class="form-inline">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Post Filter" value="{{ $filter }}">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <table class="table table-striped">
                <tr>
                    <th class="text-center">Active</th>
                    <th class="text-left">Title</th>
                    <th class="text-right">Published</th>
                    <th class="text-right">Actions</th>
                </tr>
            @foreach($posts as $post)
                <tr">
                    <td class="text-center">
                        @if ($post->isActive())
                            <span class="glyphicon glyphicon-ok-sign text-success"></span>
                        @else
                            <span class="glyphicon glyphicon-remove-sign text-danger"></span>
                        @endif
                    </td>
                    <td class="text-left"><a href="{{ route('admin.posts.show', $post) }}">{{ $post->title }}</a></td>
                    <td class="text-right">{{ $post->published_at->diffForHumans() }}</td>
                    <td class="col-md-2 text-right">
                        <div class="btn-group">
                            <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-info"> Edit</a>
                            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route('admin.posts.show', $post) }}">Preview</a></li>
                                <li><a href="{{ route('admin.posts.toggle', $post) }}">Toggle Publish</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="{{ route('admin.posts.delete', $post) }}" class="confirm" confirm-message="Are you sure you want to delete this post?">Delete</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
            </table>
        </div>
    </div>

    <div class="text-center">{{ $posts->links() }}</div>
@endsection