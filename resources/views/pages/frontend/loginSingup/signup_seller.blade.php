@extends('layouts.web-master')
@section('web_contend')
<!--============= Hero Section Starts Here =============-->
<div class="hero-section">
    <div class="container">
        <ul class="breadcrumb">
            <li>
                <a href="{{ route('welcome') }}">Home</a>
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
            <div class="right-side cl-white">
                <div class="section-header mb-0">
                    <h3 class="title mt-0">Seller form</h3>
                    <p>Sign up and create your seller Account</p>
                </div>
            </div>
            <div class="left-side">
                <div class="section-header">
                    <h2 class="title">HI, THERE</h2>
                    <p>You can log in to your account here.</p>
                </div>
                <form class="login-form" action="{{ route('signup.form_seller') }}" method="POST">
                    @csrf
                    <div class="form-group mb-30">
                        <div class="form-group mb-30">
                            <input type="text" id="name" name="name" placeholder="Name" required>
                        </div>
                        <div class="form-group mb-30">
                            <input type="email" id="email" name="email" placeholder="Email Address" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="password" id="login_pass" name="login_pass" placeholder="Password" required>
                        <span class="pass-type"><i class="fas fa-eye"></i></span>
                    </div>
                    <div class="form-group mb-0">
                        <button type="submit" class="custom-button">Sign up</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!--============= Account Section Ends Here =============-->
@endsection
