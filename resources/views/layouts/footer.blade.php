<footer>
    <div class="footer" id="footer">
        <div class="container">
            <div class="row">
                @foreach(App\Tag::allForNav()->chunk(4) as $chunk)
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6 hidden-xs">
                        @if ($loop->first)
                            <h3> Shop </h3>
                        @else
                            <h3> &nbsp; </h3>
                        @endif
                        <ul>
                        @foreach($chunk as $tag)
                            <li> <a href="{{ route('items', ['tags' => $tag->slug]) }}">{{ $tag->name }}</a> </li>
                        @endforeach
                        </ul>
                    </div>
                @endforeach
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6 hidden-xs">
                    <h3> Info </h3>
                    <ul>
                        <li> <a href="/about"> About Us </a> </li>
                        <li> <a href="https://www.facebook.com/messages/t/MandiMakesShop" target="_blank" class="confirm" confirm-message="Message us on Facebook">Commission Request <i class="fa fa-external-link" aria-hidden="true"></i></a> </li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <h3> Subscribe to Newsletter </h3>
                    <ul>
                        <li>
                            <div class="input-append newsletter-box text-center">
                                {{ Form::open(['route' => 'newsletters.subscribe', 'method' => 'POST']) }}
                                    <input type="text" class="form-control full text-center" name="email" placeholder="you@server.com ">
                                    <button class="btn btn-primary" type="submit"> Subscribe <i class="fa fa-long-arrow-right"> </i> </button>
                                {{ Form::close() }}
                            </div>
                        </li>
                    </ul>
                    <ul class="social">
                        <li> <a href="https://www.facebook.com/MandiMakesShop" target="_blank"> <i class="fa fa-facebook">   </i> </a> </li>
                        <li> <a href="mailto:mandi@mandimakes.shop"> <i class="fa fa-envelope">   </i> </a> </li>
                        <!-- <li> <a href="#"> <i class="fa fa-twitter">   </i> </a> </li> -->
                        <!-- <li> <a href="#"> <i class="fa fa-google-plus">   </i> </a> </li> -->
                        <!-- <li> <a href="#"> <i class="fa fa-pinterest">   </i> </a> </li> -->
                        <!-- <li> <a href="#"> <i class="fa fa-youtube">   </i> </a> </li> -->
                    </ul>
                </div>
            </div>
            <!--/.row-->
        </div>
        <!--/.container-->
    </div>
    <!--/.footer-->

    <div class="footer-bottom">
        <div class="container">
            <p class="pull-left"> Copyright © {{ config('app.name') }} {{ date('Y') }}. All right reserved. </p>
            <div class="pull-right">
                <ul class="nav nav-pills payments">
                    <li><i class="fa fa-cc-visa"></i></li>
                    <li><i class="fa fa-cc-mastercard"></i></li>
                    <li><i class="fa fa-cc-amex"></i></li>
                    <!-- <li><i class="fa fa-cc-paypal"></i></li> -->
                </ul>
            </div>
        </div>
    </div>
    <!--/.footer-bottom-->
</footer>