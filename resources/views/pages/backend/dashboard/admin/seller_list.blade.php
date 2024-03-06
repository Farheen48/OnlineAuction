@extends('layouts.web-master')
@section('web_contend')
<!--============= Cart Section Starts Here =============-->
<div class="cart-sidebar-area">
    <div class="top-content">
        <a href="{{ route('welcome') }}" class="logo">
            <img src="{{ asset('assets/images/logo/logo2.png') }}" alt="logo">
        </a>
        <span class="side-sidebar-close-btn"><i class="fas fa-times"></i></span>
    </div>
    <div class="bottom-content">
        <div class="cart-products">
            <h4 class="title">Shopping cart</h4>
            <div class="single-product-item">
                <div class="thumb">
                    <a href="#0"><img src="{ asset('assets/images/shop/shop01.jpg')}}" alt="shop"></a>
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
                <span>Seller list</span>
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
                        <h5 class="title">Seller list</h5>
                    </div>
                    <div class="row justify-content-center mb-30-none">
                        <div class="table-responsive">
                            <table class="purchasing-table">
                                <thead>
                                    <tr>
                                        <th>Serial</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Paid</th>
                                        <th>Payment status</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($get_data as $seller)
                                    <tr>
                                        <td>{{ $seller->serial }}</td>
                                        <td>{{ $seller->name }}</td>
                                        <td>{{ $seller->email }}</td>
                                        <td>{{ $seller->amount }} BDT</td>
                                        <td>
                                            @if($seller->payemnt_status === 'succeeded')
                                            <span class="badge bg-success">{{ $seller->payemnt_status }}</span>
                                            @else
                                            <span class="badge bg-danger">{{ $seller->payemnt_status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($seller->status === 'Active')
                                            <span class="badge bg-primary">{{ $seller->status }}</span>
                                            @else
                                            <span class="badge bg-warning">{{ $seller->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($seller->status === 'Active')
                                            <a href="{{ route('update.status',[
                                            'serial' => $seller->serial ,
                                            'status' => 'Pending'
                                            ]) }}" class="btn btn-warning">Update to Pending</a>
                                            @else
                                            <a href="{{ route('update.status',[
                                            'serial' => $seller->serial ,
                                            'status' => 'Active'
                                            ]) }}" class="btn btn-primary">Update to Active</a>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No record found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {{ $get_data->withQueryString()->links() }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<!--============= Dashboard Section Ends Here =============-->
@endsection
