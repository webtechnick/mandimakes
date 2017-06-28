@extends('layouts.admin')

@section('panel')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-9">
                    <h2>Users</h2>
                </div>
                <div class="col-md-3">
                    <form action="/admin/users" method="GET" class="form-inline">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="User Filter" value="{{ $filter }}">
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
                    <th class="text-center hidden-sm hidden-xs">Name</th>
                    <th class="text-left">Email</th>
                    <th class="text-left hidden-sm hidden-xs">Group</th>
                    <th class="text-right">Actions</th>
                </tr>
            @foreach($users as $user)
                <tr>
                    <td class="text-center hidden-sm hidden-xs"> {{ $user->name }} </td>
                    <td class="text-left"> {{ $user->email }} </td>
                    <td class="text-left hidden-sm hidden-xs"> {{ $user->group }} </td>
                    <td class="col-md-2 text-right">
                        <div class="btn-group">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-info"> Edit</a>
                            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route('admin.users.delete', $user) }}" class="confirm" confirm-message="Are you sure you want to delete this user?">Delete</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
            </table>
        </div>
    </div>

    <div class="text-center">{{ $users->links() }}</div>
@endsection