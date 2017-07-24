@extends('layouts.admin')

@section('panel')

    <div class="panel panel-default">
        <div class="panel-heading">
            <h1>Send Newseltter/Announcement</h1>
        </div>

        @include('layouts.errors')

        <div class="panel-body">
            {{ Form::open(['route' => ['admin.newsletters.send'], 'method' => 'POST']) }}
                <div class="form-group">
                    <label for="subject">Subject: </label>
                    <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" value="{{ old('subject') }}">
                </div>
                <div class="form-group">
                    <label for="body">Body: </label>
                    <textarea class="form-control tinymce" name="body" id="body" rows="10">{{ old('body') }}</textarea>
                </div>
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-success btn-lg confirm">Send <span class="glyphicon glyphicon-send"></span></button>
                </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection