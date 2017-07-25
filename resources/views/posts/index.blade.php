@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="text-center">
            {{ $posts->links() }}
        </div>

        @forelse($posts as $post)
            <div class="row">
                @include('posts._postth', ['post' => $post])
            </div>
        @empty
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            No Posts Found.
                        </div>
                        <div class="panel-body">
                            Stay tuned!
                        </div>
                    </div>
                </div>
            </div>
        @endforelse

        <div class="text-center">
            {{ $posts->links() }}
        </div>
    </div>


@endsection