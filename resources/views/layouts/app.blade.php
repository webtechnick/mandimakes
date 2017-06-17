<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    @include('layouts.head')
</head>
<body>
    <div id="app">
        @include('layouts.nav')

        @include('layouts.flashes')

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- <script src="{{ asset('js/libs.js') }}"></script> -->
    @yield('scripts')
</body>
</html>
