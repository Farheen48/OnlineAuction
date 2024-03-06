@extends('layouts.web-master')
@section('web_contend')
<div class="cart-sidebar-area">
    <div class="top-content">
        <a href="index.html" class="logo">
            <img src="{{ asset('assets/images/logo/logo.png') }}" alt="logo">
        </a>
        <span class="side-sidebar-close-btn"><i class="fas fa-times"></i></span>
    </div>
    <div class="bottom-content">
        <div class="cart-products">
            <h4 class="title">Shopping cart</h4>
            <div class="single-product-item">
                <div class="thumb">
                    <a href="#0"><img src="{{ asset('assets/images/shop/shop01.jpg') }}" alt="shop"></a>
                </div>
                <div class="content">
                    <h4 class="title"><a href="#0">Color Pencil</a></h4>
                    <div class="price"><span class="pprice">$80.00</span> <del class="dprice">$120.00</del></div>
                    <a href="#" class="remove-cart">Remove</a>
                </div>
            </div>
            <div class="single-product-item">
                <div class="thumb">
                    <a href="#0"><img src="{{ asset('assets/images/shop/shop02.jpg') }}" alt="shop"></a>
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
<div class="hero-section">
    <div class="container">
        <ul class="breadcrumb">
            <li>
                <a href="./index.html">Home</a>
            </li>
            <li>
                <a href="#0">Pages</a>
            </li>
            <li>
                <span>Sign In</span>
            </li>
        </ul>
    </div>
    <div class="bg_img hero-bg bottom_center" data-background="{{ asset('assets/images/banner/hero-bg.png') }}"></div>
</div>
<!--============= Hero Section Ends Here =============-->


<!--============= Account Section Starts Here =============-->
<section class="account-section padding-bottom">
    <div class="container">
        <div class="account-wrapper mt--100 mt-lg--440">
            <div class="left-side">
                <div class="section-header">
                    <h2 class="title">HI, you allmost there</h2>
                    <p>Please pay the registration fee [{{ config('appConfig.seller_reg_fee') }} BDT]</p>
                </div>
                    <form action="{{ route('pay.reg_bill_seller') }}" method="POST">
                        @csrf
                        @if(session()->has('payement_error'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            {{ session()->get('payement_error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
                        <div class="mb-3 row" hidden>
                            <div class="col-md-10">
                                <input class="form-control" type="number" name="price" value="{{ config('appConfig.seller_reg_fee') }}" required>
                                <input class="form-control" type="text" name="payment_token" value="{{ request()->payment_token }}" required>
                                <input class="form-control" type="text" name="identifier" value="{{ request()->identifier }}" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="html5-text-input" class="col-md-2 col-form-label">Card number</label>
                            <div class="col-md-10">
                                <input class="form-control" type="number" name="card_number" placeholder="4242424242424242"
                                    value="4242424242424242">
                                @error('card_number')
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    {{ $message }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="html5-text-input" class="col-md-2 col-form-label">Year</label>
                            <div class="col-md-10">
                                <input class="form-control" type="number" name="year" placeholder="24" value="{{ date('y')+2 }}">
                                @error('year')
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    {{ $message }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="html5-text-input" class="col-md-2 col-form-label">Month</label>
                            <div class="col-md-10">
                                <input class="form-control" type="number" name="month" placeholder="02" value="{{ date('m') }}">
                                @error('month')
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    {{ $message }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="html5-text-input" class="col-md-2 col-form-label">CVC</label>
                            <div class="col-md-10">
                                <input class="form-control" type="number" name="cvc" placeholder="1234" value="1234">
                                @error('cvc')
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    {{ $message }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-0 pb-5">
                            <button type="submit" class="custom-button">Add Balance</button>
                        </div>
                    </form>
            </div>
            <div class="right-side cl-white">
                <div class="section-header mb-0">
                    <h3 class="title mt-0">OTP Verification</h3>
                    <p>Write your email address and we will send you the code</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
