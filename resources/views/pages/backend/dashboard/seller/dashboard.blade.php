@php
$live_bid = App\Models\AuctionItem::join('seller_product_lists','auction_items.serial','=','seller_product_lists.serial')
->where([
['seller_product_lists.seller_serial','=',session()->get('serial')],
['bidding_staus','=','live']
])->count();

$sold_bid =App\Models\AuctionItem::join('seller_product_lists','auction_items.serial','=','seller_product_lists.serial')
->where([
['seller_product_lists.seller_serial','=',session()->get('serial')],
['bidding_staus','=','closed']
])
->whereNotNull('current_price')->count();
$balance = App\Models\Balence::where('serial','=',session()->get('serial'))->value('balance');

$bid_items = App\Models\AuctionItem::join('seller_product_lists', 'auction_items.serial', 'seller_product_lists.serial')
->where([
['auction_items.bidding_staus', '=', 'closed'],
['seller_product_lists.seller_serial','=',session()->get('serial')]
])
->whereDate('auction_items.updated_at', '>=', now()->subDays(5))
->select(
'auction_items.serial',
'auction_items.token',
'auction_items.current_price',
'seller_product_lists.name',
'seller_product_lists.starting_price',
'seller_product_lists.image',
'auction_items.category',
'auction_items.time_limit'
)
->orderBy('auction_items.updated_at', 'desc')
->get();

@endphp

@extends('layouts.web-master')
@section('web_contend')
<!--============= Cart Section Starts Here =============-->
<div class="cart-sidebar-area">
    <div class="top-content">
        <a href="index.html" class="logo">
            <img src="./assets/images/logo/logo2.png" alt="logo">
        </a>
        <span class="side-sidebar-close-btn"><i class="fas fa-times"></i></span>
    </div>
    <div class="bottom-content">
        <div class="cart-products">
            <h4 class="title">Shopping cart</h4>
            <div class="single-product-item">
                <div class="thumb">
                    <a href="#0"><img src="assets/images/shop/shop01.jpg" alt="shop"></a>
                </div>
                <div class="content">
                    <h4 class="title"><a href="#0">Color Pencil</a></h4>
                    <div class="price"><span class="pprice">$80.00</span> <del class="dprice">$120.00</del></div>
                    <a href="#" class="remove-cart">Remove</a>
                </div>
            </div>
            <div class="single-product-item">
                <div class="thumb">
                    <a href="#0"><img src="assets/images/shop/shop02.jpg" alt="shop"></a>
                </div>
                <div class="content">
                    <h4 class="title"><a href="#0">Water Pot</a></h4>
                    <div class="price"><span class="pprice">$80.00</span> <del class="dprice">$120.00</del></div>
                    <a href="#" class="remove-cart">Remove</a>
                </div>
            </div>
            <div class="single-product-item">
                <div class="thumb">
                    <a href="#0"><img src="assets/images/shop/shop03.jpg" alt="shop"></a>
                </div>
                <div class="content">
                    <h4 class="title"><a href="#0">Art Paper</a></h4>
                    <div class="price"><span class="pprice">$80.00</span> <del class="dprice">$120.00</del></div>
                    <a href="#" class="remove-cart">Remove</a>
                </div>
            </div>
            <div class="single-product-item">
                <div class="thumb">
                    <a href="#0"><img src="assets/images/shop/shop04.jpg" alt="shop"></a>
                </div>
                <div class="content">
                    <h4 class="title"><a href="#0">Stop Watch</a></h4>
                    <div class="price"><span class="pprice">$80.00</span> <del class="dprice">$120.00</del></div>
                    <a href="#" class="remove-cart">Remove</a>
                </div>
            </div>
            <div class="single-product-item">
                <div class="thumb">
                    <a href="#0"><img src="assets/images/shop/shop05.jpg" alt="shop"></a>
                </div>
                <div class="content">
                    <h4 class="title"><a href="#0">Comics Book</a></h4>
                    <div class="price"><span class="pprice">$80.00</span> <del class="dprice">$120.00</del></div>
                    <a href="#" class="remove-cart">Remove</a>
                </div>
            </div>
            <div class="btn-wrapper text-center">
                <a href="#0" class="custom-button"><span>Checkout</span></a>
            </div>
        </div>
    </div>
</div>
<!--============= Cart Section Ends Here =============-->


<!--============= Hero Section Starts Here =============-->
<div class="hero-section style-2 pb-lg-400">
    <div class="container">
        <ul class="breadcrumb">
            <li>
                <a href="./index.html">Home</a>
            </li>
            <li>
                <a href="#0">My Account</a>
            </li>
            <li>
                <span>Dashboard</span>
            </li>
        </ul>
    </div>
    <div class="bg_img hero-bg bottom_center" data-background="{{ asset('assets/images/banner/hero-bg.png') }}"></div>
</div>
<!--============= Hero Section Ends Here =============-->


<!--============= Dashboard Section Starts Here =============-->
<section class="dashboard-section padding-bottom mt--240 mt-lg--325 pos-rel">
    <div class="container">
        <div class="row justify-content-center">
            @include('pages.backend.dashboard.aux_pages.side_bar')
            <div class="col-lg-8">
                <div class="dashboard-widget mb-40">
                    <div class="dashboard-title mb-30">
                        <h5 class="title">My Activity</h5>
                    </div>
                    <div class="row justify-content-center mb-30-none">
                        <div class="col-md-4 col-sm-6">
                            <div class="dashboard-item">

                                <div class="content">
                                    <h2 class="title"><span class="counter">{{ $live_bid }}</span></h2>
                                    <h6 class="info">Active Bids</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="dashboard-item">

                                <div class="content">
                                    <h2 class="title"><span class="counter">{{ $sold_bid }}</span></h2>
                                    <h6 class="info">Items Won</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="dashboard-item">

                                <div class="content">
                                    <h2 class="title"><span class="counter">{{ $balance }}</span></h2>
                                    <h6 class="info">Favorites</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dashboard-widget">
                    <h5 class="title mb-10">Recently Sold Item</h5>
                    <div class="dashboard-purchasing-tabs">
                        <div class="col-12">
                            @forelse ($bid_items as $bi)
                            <div class="card mb-3">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <img src="{{ asset($bi->image) }}" class="img-fluid rounded-start" alt="{{ $bi->name }}">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $bi->name }}</h5>

                                            <div class="bid-area">
                                                <div class="bid-amount">
                                                    <div class="amount-content">
                                                        <div class="current">Starts at</div>
                                                        <div class="amount">&#2547; {{ $bi->starting_price }}</div>
                                                    </div>
                                                </div>
                                                <div class="bid-amount">
                                                    <div class="amount-content">
                                                        <div class="current">Category</div>
                                                        <div class="amount">{{ $bi->category }}</div>
                                                    </div>
                                                </div>
                                                <h5> Bid closed at: <span class="text-primaray">{{ $bi->current_price }}
                                                        &#2547;</span></h5>
                                                <p class="text-success">Ends at: <br> {{
                                                    \Carbon\Carbon::parse($bi->time_limit)->format("F j, Y, g:i A") }}</p>
                                                @if (\Carbon\Carbon::parse($bi->time_limit)->isPast())
                                                <p class="bg-danger p-2 text-light">Auction time has passed for this item.</p>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-sm-10 col-md-6 col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        No live bids available right now
                                    </div>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--============= Dashboard Section Ends Here =============-->
@endsection
