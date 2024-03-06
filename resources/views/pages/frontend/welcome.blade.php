@extends('layouts.web-master')
@section('web_contend')
<!--============= Banner Section Starts Here =============-->
<section class="banner-section bg_img" data-background="./assets/images/banner/banner-bg-1.png">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-lg-6 col-xl-6">
                <div class="banner-content cl-white">
                    <h5 class="cate">Next Generation Auction</h5>
                    <h1 class="title"><span class="d-xl-block">Find Your</span> Next Deal!</h1>
                    <p>
                        Online Auction is where everyone goes to shop, sell,and give, while discovering variety and
                        affordability.
                    </p>
                    <a href="#0" class="custom-button yellow btn-large">Get Started</a>
                </div>
            </div>
            <div class="d-none d-lg-block col-lg-6">
                <div class="banner-thumb-2">
                    <img src="{{ asset('/public/assets/images/banner/banner-1.png') }}" alt="banner">
                </div>
            </div>
        </div>
    </div>
    <div class="banner-shape d-none d-lg-block">
        <img src="{{ asset('/public/assets/css/img/banner-shape.png') }}" alt="css">
    </div>
</section>
<!--============= Banner Section Ends Here =============-->
<div class="browse-section ash-bg">
    <!--============= Hightlight Slider Section Starts Here =============-->
@include('pages.frontend.helper_pages.feature_category')
</div>
<!--============= Coins and Bullion Auction Section Starts Here =============-->
<section class="coins-and-bullion-auction-section padding-bottom padding-top pos-rel pb-max-xl-0">
    <div class="container">
        <div class="section-header-3">
            <div class="left">

                <div class="title-area">
                    <h2 class="title">Running bids</h2>
                </div>
            </div>
            <a href="{{ route('running.bids') }}" class="normal-button">View All</a>
        </div>
        @include('pages.frontend.helper_pages.running_bid_list_frontend')
    </div>
</section>
<!--============= Coins and Bullion Auction Section Ends Here =============-->

<!--============= Popular Auction Section Starts Here =============-->
<section class="popular-auction padding-top pos-rel">
    <div class="popular-bg bg_img" data-background="./assets/images/auction/popular/popular-bg.png"></div>
    <div class="container">
        <div class="section-header cl-white">
            <span class="cate">Popular Auctions</span>
            <h2 class="title">Popular Auctions</h2>
            <p>Bid and win great deals,Our auction process is simple, efficient, and transparent.</p>
        </div>
        @include('pages.frontend.helper_pages.listed_items')
    </div>
</section>
<!--============= Popular Auction Section Ends Here =============-->
<!--============= How Section Starts Here =============-->
<section class="how-section padding-top">
    <div class="container">
        <div class="how-wrapper section-bg">
            <div class="section-header text-lg-left">
                <h2 class="title">How it works</h2>
                <p>Easy 3 steps to win</p>
            </div>
            <div class="row justify-content-center mb--40">
                <div class="col-md-6 col-lg-4">
                    <div class="how-item">
                        <div class="how-thumb">
                            <img src="./assets/images/how/how1.png" alt="how">
                        </div>
                        <div class="how-content">
                            <h4 class="title">Sign Up</h4>
                            <p>No Credit Card Required</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="how-item">
                        <div class="how-thumb">
                            <img src="./assets/images/how/how2.png" alt="how">
                        </div>
                        <div class="how-content">
                            <h4 class="title">Bid</h4>
                            <p>Bidding is free Only pay if you win</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="how-item">
                        <div class="how-thumb">
                            <img src="./assets/images/how/how3.png" alt="how">
                        </div>
                        <div class="how-content">
                            <h4 class="title">Win</h4>
                            <p>Fun - Excitement - Great deals</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--============= How Section Ends Here =============-->


<!--============= Client Section Starts Here =============-->
<section class="client-section padding-top padding-bottom">
    <div class="container">
        <div class="section-header">
            <h2 class="title">Don’t just take our word for it!</h2>
            <p>Our hard work is paying off. Great reviews from amazing customers.</p>
        </div>
        <div class="m--15">
            <div class="client-slider owl-theme owl-carousel">
                <div class="client-item">
                    <div class="client-content">
                        <p>I can't stop bidding! It's a great way to spend some time and I want everything on Sbidu.</p>
                    </div>
                    <div class="client-author">
                        <div class="thumb">
                            <a href="#0">
                                <img src="./assets/images/client/client01.png" alt="client">
                            </a>
                        </div>
                        <div class="content">
                            <h6 class="title"><a href="#0">Alexis Moore</a></h6>
                            <div class="ratings">
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="fas fa-star"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="client-item">
                    <div class="client-content">
                        <p>I came I saw I won. Love what I have won, and will try to win something else.</p>
                    </div>
                    <div class="client-author">
                        <div class="thumb">
                            <a href="#0">
                                <img src="./assets/images/client/client02.png" alt="client">
                            </a>
                        </div>
                        <div class="content">
                            <h6 class="title"><a href="#0">Darin Griffin</a></h6>
                            <div class="ratings">
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="fas fa-star"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="client-item">
                    <div class="client-content">

                    </div>
                    <div class="client-author">
                        <div class="thumb">
                            <a href="#0">
                                <img src="./assets/images/client/client03.png" alt="client">
                            </a>
                        </div>
                        <div class="content">
                            <div class="ratings">
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="fas fa-star"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
