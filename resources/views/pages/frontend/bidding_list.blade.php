@extends('layouts.web-master')
@section('web_contend')
<!--============= Coins and Bullion Auction Section Starts Here =============-->
<section class="coins-and-bullion-auction-section padding-bottom padding-top pos-rel pb-max-xl-0">
    <div class="container mt-10">
        <div class="row justify-content-center mb-30-none">
            @forelse($bid_item as $bi)
            <div class="col-sm-10 col-md-6 col-lg-4">
                <div class="auction-item-2">
                    <div class="auction-thumb">
                        <p><img src="{{ asset($bi->image) }}" alt="coins"></a>
                        <a href="#0" class="rating"><i class="far fa-star"></i></a>
                        <a href="#0" class="bid"><i class="flaticon-auction"></i></a>
                    </div>
                    <div class="auction-content">
                        <h6 class="title">
                            <p>{{ $bi->name }}</p>
                        </h6>
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
                        </div>
                        <div class="countdown-area">
                            <div class="countdown">
                                <p class="text-success">Ends at: <br> {{ Carbon\Carbon::parse($bi->time_limit)->format("F j, Y,
                                    g:i A"); }}</p>
                            </div>
                        </div>
                        <div class="text-center">
                        <a href="{{ route('public_bidding.item_details',[
                        'token' => $bi->token,
                         'serial' => $bi->serial
                        ])}}" class="custom-button">Submit a bid</a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-sm-10 col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        No bid available right now
                    </div>
                </div>
            </div>
            @endforelse

        </div>

    </div>
</section>
<!--============= Coins and Bullion Auction Section Ends Here =============-->
@endsection
