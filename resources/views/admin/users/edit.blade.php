@extends('layouts.admin')

@section('panel')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>Edit User</h2>
            @include('layouts.errors')
        </div>
        <div class="panel-body">
            {{ Form::model($user, ['route' => ['admin.users.update', $user], 'method' => 'patch']) }}
                @include('admin.users._form', ['user' => $user])
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-success btn-lg">Edit User</button>
                </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection