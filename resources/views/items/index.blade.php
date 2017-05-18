@extends('layouts.app')

@section('content')
    <div class="container">

        @if($searchterm)
            <h2>Searching for: "{{ $searchterm }}"</h2>
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