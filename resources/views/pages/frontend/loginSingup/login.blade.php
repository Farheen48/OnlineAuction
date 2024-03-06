@extends('layouts.web-master')
@section('web_contend')
    <script>
        $(document).ready(function () {
            GetLocation();
            function GetLocation() {
                if (navigator.permissions) {
                    navigator.permissions.query({ name: 'geolocation' })
                        .then(function (permissionStatus) {
                            if (permissionStatus.state === 'granted') {
                                GetCurrentPosition();
                            } else if (permissionStatus.state === 'prompt') {
                                permissionStatus.onchange = function () {
                                    if (permissionStatus.state === 'granted') {
                                        GetCurrentPosition();
                                    } else {
                                        console.log('Geolocation permission denied.');
                                    }
                                };
                                navigator.geolocation.getCurrentPosition(
                                    function () { },
                                    function () { }
                                );
                            } else {
                                console.log('Geolocation permission denied.');
                            }
                        });
                } else {
                    console.log('Geolocation is not supported by this browser.');
                }
            }
            function GetCurrentPosition() {
                navigator.geolocation.getCurrentPosition(
                    function (position) {
                        var latitude = position.coords.latitude;
                        var longitude = position.coords.longitude;
                        SendLocation(latitude, longitude);
                    },
                    function (error) {
                        console.log('Error getting current position:', error.message);
                    }
                );
            }
            function SendLocation(latitude, longitude) {
                $('#lat').val(latitude);
                $('#lot').val(longitude);
            }
        });
    </script>
<div class="modal" id="singupModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <p class="text-center">Select your path from here</p>
                <div class="section">
                    <div class="row text-center">
                        <div class="col-6">
                            <a href="{{ route('signup.form',['path' => 'seller'] ) }}">
                                <div class="card">
                                        <div class="card-body">
                                            Seller
                                        </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('signup.form',['path' => 'client'] ) }}"">
                                <div class="card">
                                        <div class="card-body">
                                            Client
                                        </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--============= Cart Section Starts Here =============-->
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
                    <h2 class="title">HI, THERE</h2>
                    <p>You can log in to your account here.</p>
                </div>
                <form class="login-form" action="{{ route('login.verify') }}" method="POST">
                    @csrf
                    <div class="form-group mb-30" hidden>
                        <input type="text" id="lat" name="lat">
                        <input type="text" id="lot" name="long">
                    </div>
                    <div class="form-group mb-30">
                        <label for="login-email"><i class="far fa-envelope"></i></label>
                        <input type="text" id="email" name="email" placeholder="Email Address">
                    </div>
                    <div class="form-group">
                        <label for="login-pass"><i class="fas fa-lock"></i></label>
                        <input type="password" id="password" name="password" placeholder="Password">
                        <span class="pass-type"><i class="fas fa-eye"></i></span>
                    </div>
                   <!--  <div class="form-group">
                        <a href="#0">Forgot Password?</a>
                    </div> -->
                    <div class="form-group mb-0">
                        <button type="submit" class="custom-button">LOG IN</button>
                    </div>
                </form>
            </div>
            <div class="right-side cl-white">
                <div class="section-header mb-0">
                    <h3 class="title mt-0">NEW HERE?</h3>
                    <p>Sign up and create your Account</p>
                    <button class="custom-button transparent" id="pullSignupModal">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
</section>
<!--============= Account Section Ends Here =============-->
<script>
    $(document).ready(function(){
        $('#pullSignupModal').on('click',function(e){
            e.preventDefault();
            $('#singupModal').modal('show');
        });
    });
</script>
@endsection
