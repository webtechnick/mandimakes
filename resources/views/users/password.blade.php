@extends('layouts.dashboard')

@section('panel')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1>Change Password</h1>
        </div>

        <div class="panel-body">
            @include('layouts.errors')
            {{ Form::open(['route' => ['users.password'], 'method' => 'PATCH']) }}
            <div class="form-group">
                <label for="password">Current Password: </label>
                {{ Form::password('password', ['class' => 'form-control', 'required'])}}
            </div>
            <hr>
            <div class="form-group">
                <label for="new_password">New Password: </label>
                {{ Form::password('new_password', ['class' => 'form-control', 'required']) }}
            </div>
            <div class="form-group">
                <label for="newpassword">Confirm Password: </label>
                {{ Form::password('new_password_confirmation', ['class' => 'form-control', 'required']) }}
            </div>
            <div class="form-group text-right">
                <button type="submit" class="btn btn-primary btn-lg">Update Password</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection
