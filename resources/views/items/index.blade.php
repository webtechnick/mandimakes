@extends('layouts.app')

@section('content')
    <div class="container">

        @if($searchterm)
            <h2>Searching for: "{{ $searchterm }}"</h2>
        @endif

        @foreach($items as $item)
            @include('items._itemth', ['item' => $item])
        @endforeach

        <div class="center">
            {{ $items->links() }}
        </div>
    </div>


@endsection