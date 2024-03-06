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
    <div class="bg_img hero-bg bottom_center" data-background="./assets/images/banner/hero-bg.png"></div>
</div>
<!--============= Hero Section Ends Here =============-->


<!--============= Account Section Starts Here =============-->
<section class="account-section padding-bottom">
    <div class="container">
        <div class="account-wrapper mt--100 mt-lg--440">
            <div class="left-side">
                <div class="section-header">
                    <h2 class="title">Set OTP</h2>
                    <p>You can log in to your account here.</p>
                </div>
                <form class="login-form" action="{{ route('submit.OTP') }}" method="GET">
                    @csrf
                    <div class="form-group mb-30">
                        <input type="email" id="email" name="email" placeholder="Email Address"
                            value="{{ request()->email }}" hidden>
                        <input type="text" id="useragent" name="useragent" value="{{ request()->useragent }}" hidden>
                        <input type="number" id="otp" name="otp" placeholder="Type your otp">
                        @error('otp')
                        <span class="text-center text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-0">
                        <button type="submit" class="custom-button">Get OTP</button>
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
<!--============= Account Section Ends Here =============-->
<script>
    $(document).ready(function () {
        $('#pullSignupModal').on('click', function (e) {
            e.preventDefault();
            $('#singupModal').modal('show');
        });
    });
</script>
@endsection
