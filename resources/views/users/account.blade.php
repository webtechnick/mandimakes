@extends('layouts.dashboard')

@section('panel')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1>My Account</h1>
        </div>

        <div class="panel-body">
            @include('layouts.errors')
            {{ Form::model($user, ['route' => ['users.update'], 'method' => 'PATCH']) }}
            <div class="form-group">
                <label for="name">Name: </label>
                {{ Form::text('name', null, ['class' => 'form-control'])}}
            </div>
            <div class="form-group">
                <label for="email">Email: </label>
                {{ Form::text('email', null, ['class' => 'form-control']) }}
            </div>
            <div class="form-group text-right">
                <button type="submit" class="btn btn-primary btn-lg">Update Account</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection
