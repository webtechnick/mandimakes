<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                Mandi Makes Shop
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                <li><a href="/?new=1">New Items</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        Products <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Tag</a></li>
                        <li><a href="#">Tag</a></li>
                        <li><a href="#">Tag</a></li>
                    </ul>
                </li>
                <li><a href="/about">About Us</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                <li><a href="/checkout"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> {{ Cart::text() }}</a></li>
                @if (Auth::guest())
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="/account"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Account</a></li>
                            <li><a href="/my-orders"><span class="glyphicon glyphicon-usd" aria-hidden="true"></span> My Orders</a></li>

                            <li>@include('layouts._logout')</li>
                        </ul>
                    </li>
                @endif
            </ul>

            <form action="/search" method="POST" class="navbar-form navbar-right">
                {{ csrf_field() }}
                <div class="input-group">
                    <input type="text" name="term" class="form-control" id="topsearch" placeholder="Search">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                    </span>
                </div>
            </form>

        </div>
    </div>
</nav>