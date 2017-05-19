@extends('layouts.app')

@section('content')
    <div class="container">

        @if($filter)
            <h2>Searching for: "{{ $filter }}"</h2>
        @endif

        <div class="text-center">
            {{ $items->links() }}
        </div>


        @foreach($items->chunk(3) as $chunk)
            <div class="row">
                @foreach($chunk as $item)
                    @include('items._itemth', ['item' => $item])
                @endforeach
            </div>
        @endforeach

        <div class="text-center">
            {{ $items->links() }}
        </div>
    </div>


@endsection