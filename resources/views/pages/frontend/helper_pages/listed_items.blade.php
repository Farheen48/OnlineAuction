@php
$product_list_seller= App\Models\SellerProductList::paginate(10);
@endphp
<div class="popular-auction-wrapper">
    <div class="row justify-content-center mb-30-none">
        @forelse($product_list_seller as $pd)
        <div class="col-lg-6">
            <div class="auction-item-3">
                <div class="auction-thumb">
                    <a href="#"><img src="{{ asset($pd->image) }}"
                            alt="popular"></a>
                    <a href="#0" class="bid"><i class="flaticon-auction"></i></a>
                </div>
                <div class="auction-content">
                    <h6 class="title">
                        <a href="#">{{ $pd->name }}</a>
                    </h6>
                    <div class="bid-amount">
                        <div class="icon">
                            <i class="flaticon-auction"></i>
                        </div>
                        <div class="amount-content">
                            <div class="current">Starting price</div>
                            <div class="amount">{{ $pd->starting_price }}</div>
                        </div>
                    </div>
                    <div class="bids-area">
                        <span class="total-bids">{{ $pd->short_des }}</span>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-lg-6">
            <div class="auction-item-3">
                <div class="auction-thumb">
                    <img src="{{ asset('/public/assets/images/icons/note_found.jpg') }}" alt="No found">
                    <p class="bid"><i class="flaticon-auction"></i></p>
                </div>
                <div class="auction-content">
                    <h6 class="title">
                        No product available
                    </h6>
                </div>
            </div>
        </div>
        @endforelse
    </div>
</div>
