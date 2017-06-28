@extends('layouts.admin')

@section('actions')
    <li><a href="/admin/tags/create"><span class="glyphicon glyphicon-plus"></span> New Tag</a></li>
@endsection

@section('panel')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-9">
                    <h2>Tags</h2>
                </div>
                <div class="col-md-3">
                    <form action="/admin/tags" method="GET" class="form-inline">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Tag Filter" value="{{ $filter }}">
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
                    <th class="hidden-sm hidden-xs text-center">Id</th>
                    <th class="text-left">Name</th>
                    <th class="text-left hidden-sm hidden-xs ">Slug</th>
                    <th class="text-right">Actions</th>
                </tr>
            @foreach($tags as $tag)
                <tr>
                    <td class="hidden-sm hidden-xs text-center">{{ $tag->id }}</td>
                    <td class="text-left">{{ $tag->name }}</td>
                    <td class="text-left hidden-sm hidden-xs ">{{ $tag->slug }}</td>
                    <td class="col-md-2 text-right">
                        <div class="btn-group">
                            <a href="{{ route('admin.tags.edit', [$tag]) }}" class="btn btn-info"> Edit</a>
                            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route('admin.tags.delete', [$tag]) }}" class="confirm" confirm-message="Are you sure you want to delete this tag?">Delete</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
            </table>
        </div>
    </div>

    <div class="text-center">{{ $tags->links() }}</div>
@endsection