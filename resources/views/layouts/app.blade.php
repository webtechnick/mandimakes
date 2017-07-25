<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    @include('layouts.head')
</head>
<body>
    <div id="app">
        @include('layouts.nav')

        @include('layouts.flashes')

        <div id="main">
            @yield('content')
        </div>
    </div>

    @include('layouts.footer')
    @include('layouts.scripts')
</body>
</html>
