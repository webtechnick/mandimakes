@extends('layouts.app')

@section('content')

<div class="container">
    <h1>{{ $item->title }}</h1>
    <p>{{ $item->description }}</p>
</div>

@endsection