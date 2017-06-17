@extends('layouts.app')

@section('content')
    <div class="container">
    @forelse($tags->chunk(4) as $chunk)
        <div class="row">
            @foreach($chunk as $tag)
                @include('tags._tag', ['tag' => $tag])
            @endforeach
        </div>
        @empty
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        No Tags Found.
                    </div>
                    <div class="panel-body">
                        Please widen your search.
                    </div>
                </div>
            </div>
        </div>
        @endforelse
    </div>
@endsection