@php
$access_token = session()->get('access_token');
$path = session()->get('path');
@endphp
<header>
    <div class="header-top">
        <div class="container">
            <div class="header-top-wrapper">
                <ul class="customer-support">
                    <li>
                        <a href="#0" class="mr-3"><i class="fas fa-phone-alt"></i><span
                                class="ml-2 d-none d-sm-inline-block">Customer Support</span></a>
                    </li>
                    <li>
                        <i class="fas fa-globe"></i>
                    </li>
                </ul>
                <ul class="cart-button-area">
                    <li>
                        <a href="#0" class="cart-button"><p style="font-size: 14px;">Basket</p><span
                                class="amount">08</span></a>
                    </li>
                    <li>
                        @if(!empty($access_token))
                        @if($path === 'Admin')
                        @if (
                            request()->routeIs('admin.dashboard')||
                            request()->routeIs('seller.list')||
                            request()->routeIs('view.category_list')
                            )
                        <a href="{{ route('logout') }}" class="user-button">
                            <p style="font-size: 14px;">Log out</p>
                        </a>
                        @else
                        <a href="{{ route('admin.dashboard') }}" class="user-button">
                            <p style="font-size: 14px;">AD</p>
                        </a>
                        @endif
                        @elseif($path === 'User')
                        @if (
                            request()->routeIs('user.dashboard')||
                            request()->routeIs('add.balance')
                            )
                        <a href="{{ route('logout') }}" class="user-button">
                            <p style="font-size: 14px;">Log out</p>
                        </a>
                        @else
                        <a href="{{ route('user.dashboard') }}" class="user-button">
                            <p style="font-size: 14px;">UD</p>
                        </a>
                        @endif
                        @elseif($path === 'Seller')
                        @if (
                            request()->routeIs('seller.dashboard')||
                            request()->routeIs('product_reg.lit_seller')
                            )
                        <a href="{{ route('logout') }}" class="user-button">
                            <p style="font-size: 14px;">Log out</p>
                        </a>
                        @else
                        <a href="{{ route('seller.dashboard') }}" class="user-button">
                            <p style="font-size: 14px;">SD</p>
                        </a>
                        @endif
                        @endif
                        @else
                        <a href="{{ route('login') }}" class="user-button"><p style="font-size: 14px;">Login</p></a>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="header-bottom">
        <div class="container">
            <div class="header-wrapper">
                <div class="logo">
                    <a href="{{ route('welcome') }}">
                        <h2 class="text-light">{{ config('appConfig.app.name') }}</h2>
                    </a>
                </div>
                <ul class="menu ml-auto">
                    <li>
                        <a href="{{ route('welcome') }}">Home</a>

                    </li>
                    <li>
                        <a href="{{ route('running.bids') }}">Auction</a>
                    </li>

                </ul>

                <div class="search-bar d-md-none">
                    <a href="#0"><i class="fas fa-search"></i></a>
                </div>
                <div class="header-bar d-lg-none">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </div>
</header>
