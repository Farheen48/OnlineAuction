@php
$default_bid = $bid_item->starting_price+500;
$your_bid = $bid_item->current_price+500;
@endphp
@extends('layouts.web-master')
@section('web_contend')
<!--============= Hero Section Starts Here =============-->
<div class="hero-section style-2">
    <div class="container">
        <ul class="breadcrumb">
            <li>
                <a href="./index.html">Home</a>
            </li>
            <li>
                <a href="#0">Pages</a>
            </li>
            <li>
                <span>Vehicles</span>
            </li>
        </ul>
    </div>
    <div class="bg_img hero-bg bottom_center" data-background="{{ asset('assets/images/banner/hero-bg.png') }} "></div>
</div>
<!--============= Hero Section Ends Here =============-->
<!--============= Product Details Section Starts Here =============-->
<section class="product-details padding-bottom mt--240 mt-lg--440">
    <div class="container">
        <div class="product-details-slider-top-wrapper">
            <div class="product-details-slider owl-theme owl-carousel" id="sync1">
                <div class="slide-top-item">
                    <div class="slide-inner">
                        <img src="{{ asset($bid_item->image ) }}" width="150px" height="250px" alt="product">
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-40-60-80">
            <div class="col-lg-8">
                <div class="product-details-content">
                    <div class="product-details-header">
                        <h2 class="title">{{ $bid_item->name }}</h2>
                        <input type="text" value="{{ $bid_item->time_limit }}" id="time_limit" hidden>
                        <input type="text" value="{{ request()->serial }}" id="serial" hidden>
                        <input type="text" value="{{ request()->token }}" id="token" hidden>
                        <ul>
                            <li>Listing ID: {{ $bid_item->serial }}</li>
                            <li>Item #: {{ $bid_item->token }}</li>
                        </ul>
                    </div>
                    <ul class="price-table mb-30">
                        <li class="header">
                            <h5 class="current">Current Price</h5>
                            @if($bid_item->current_price == 0)
                            <h3 class="current_price">&#2547; {{ $bid_item->starting_price }}</h3>
                            @else
                            <h3 class="current_price">&#2547; {{ $bid_item->current_price }}</h3>
                            @endif
                        </li>
                        <li class="header">
                            <h6>Live Bidder list</h6>
                            <div class="table-responsive" style="height: 250px; overflow-y: auto;">
                                <table class="table table-border">
                                    <tr>
                                        <th>UID</th>
                                        <th>Name</th>
                                    </tr>
                                    <tbody id="dynamic_bidder">

                                    </tbody>
                                </table>
                            </div>
                        </li>
                    </ul>
                    <div class="product-bid-area">
                        <form class="product-bid-form" action="{{ route('submit_a.bid_item') }}" method="post">
                        @csrf
                        <input type="text" name="token" id="token" value="{{ request()->token }}" hidden>
                        <input type="text" name="serial" id="serial" value="{{ request()->serial }}" hidden>
                            @if($bid_item->current_price == 0)
                            <input type="text" placeholder="Enter you bid amount" value="{{ $default_bid }}" name="bid_price" id="bid_price">
                            @else
                            <input type="text" placeholder="Enter you bid amount" value="{{ $your_bid }}" name="bid_price" id="bid_price">
                            @endif
                            <button type="submit" class="custom-button" id="submit_button">Submit a bid</button>
                        </form>
                    </div>

                </div>
            </div>
            <div class="col-lg-4">
                <div class="product-sidebar-area">
                    <div class="product-single-sidebar mb-3">
                        <h6 class="title">This Auction Ends in:</h6>
                        <div class="countdown">
                            <div id="bid_counter"></div>
                        </div>
                        <div class="side-counter-area">
                            <div class="side-counter-item">
                                <div class="thumb">
                                    <img src="{{ asset('assets/images/product/icon1.png') }}" alt="product">
                                </div>
                                <div class="content">
                                    <h3 class="count-title"><span class="total_bidder">0</span></h3>
                                    <p>Active Bidders</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="product-tab-menu-area mb-40-60 mt-70-100">
        <div class="container">
            <ul class="product-tab-menu nav nav-tabs">
                <li>
                    <a href="#details" class="active" data-toggle="tab">
                        <div class="content">Description</div>
                    </a>
                </li>

            </ul>
        </div>
    </div>
    <div class="container">
        <div class="tab-content">
            <div class="tab-pane fade show active" id="details">
                <div class="tab-details-content">
                    <div class="header-area">
                        <h3 class="title">{{ $bid_item->name }}</h3>


                        <div class="item">

                            <p>{{ $bid_item->short_des }} </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
</section>
<!--============= Product Details Section Ends Here =============-->

<script>
    const timeLimit = $('#time_limit').val();
    const submitButton = $('#submit_button');
    const targetDate = new Date(timeLimit).getTime();
    $('#bid_counter').countdown(targetDate, function (event) {
        const days = event.strftime('%D');
        const hours = event.strftime('%H');
        const minutes = event.strftime('%M');
        const seconds = event.strftime('%S');
        $(this).html(
            days + ' days ' +
            hours + ' hours ' +
            minutes + ' minutes ' +
            seconds + ' seconds'
        );
    });
    $(document).ready(function () {
        liveBid();
        function liveBid(){
            const serial = $('#serial').val();
            const token = $('#token').val();
            $.ajax({
                type: "GET",
                url: "{{ route('live.bidder') }}",
                data: {
                    'serial': serial,
                    'token': token
                },
                dataType: "json",
                success: function (response) {
                    if (response.status === true) {
                        if (response.msg === 'data-fetched') {
                            $('.total_bidder').html(response.data.total_bidder);
                            $('.current_price').html(response.data.current_price);
                            $('#dynamic_bidder').html(response.data.live_bidder);
                            console.log('live call');
                        }
                    }else{
                         console.log('Error: ' + response.msg);
                    }
                }
            });
        }
        setInterval(liveBid,10000);
    });
</script>
@endsection
