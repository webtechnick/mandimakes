@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>Welcome to Mandi Makes Shop</h1>
            </div>
            <div class="panel-body">
                <p>Where everything is handmade, handcrafted, and made with love from all our favorite fandoms!</p>

                <div class="text-center">
                    <a href="{{ route('items') }}" class="btn btn-primary btn-lg">Browse All Items!</a>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>Featured Items</h1>
            </div>
            <div class="panel-body">
                <div class="slick">
                    @foreach($items as $item)
                        <div>
                            @include('items._itemlist')
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css"/>
    <script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>
    <script>
    $('.slick').slick({
        slidesToShow: 2,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 3500,
        arrows: false,
    });
    </script>
@endsection