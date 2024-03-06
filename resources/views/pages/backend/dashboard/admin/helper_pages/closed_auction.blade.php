@php
$bid_item = App\Models\AuctionItem::join('seller_product_lists', 'auction_items.serial', 'seller_product_lists.serial')
->where('auction_items.bidding_staus', '!=', 'live')
->whereNotNull('auction_items.bidder')
->select(
'auction_items.serial',
'auction_items.token',
'auction_items.current_price',
'auction_items.bidder',
'seller_product_lists.name',
'seller_product_lists.starting_price',
'seller_product_lists.image',
'auction_items.category',
'auction_items.time_limit'
)
->orderBy('auction_items.updated_at', 'desc')
->get();
@endphp

<div class="tab-pane show active fade" id="pending" style="display: none;">
    <div class="row">
        <div class="col-12">
            @forelse($bid_item as $bi)
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
                            <h5> Current bid price: <span class="text-primaray">{{ $bi->current_price }} &#2547;</span></h5>
                            <p class="text-success">Bidder: <br> {{ $bi->bidder }}</p>
                            <p class="text-success">Ends at: <br> {{ Carbon\Carbon::parse($bi->time_limit)->format("F j, Y, g:i A"); }}</p>

                        </div>

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
</div>
