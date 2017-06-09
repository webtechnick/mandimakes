@extends('layouts.admin')

@section('panel')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>Edit Tag</h2>
            @include('layouts.errors')
        </div>
        <div class="panel-body">
            <form action="{{ route('admin.tags.edit', [$tag]) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                @include('admin.tags._form', ['tag' => $tag])
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-success btn-lg">Edit Tag</button>
                </div>
            </form>
        </div>
    </div>
@endsection