@extends('layouts.app')

@section('content')
    <div class="container">

        @if($filter)
            <h2>Searching for: "{{ $filter }}"</h2>
        @endif

        <div class="text-center">
            {{ $items->links() }}
        </div>

        @forelse($items->chunk(3) as $chunk)
            <div class="row">
                @foreach($chunk as $item)
                    @include('items._itemth', ['item' => $item])
                @endforeach
            </div>
        @empty
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            No Items Found.
                        </div>
                        <div class="panel-body">
                            Please widen your search.
                        </div>
                    </div>
                </div>
            </div>
        @endforelse

        <div class="text-center">
            {{ $items->links() }}
        </div>
    </div>


@endsection