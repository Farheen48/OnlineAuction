<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuctionItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'seriel',
        'category',
        'time_limit',
        'bidding_staus',
        'status',
        'price_collected',
        'bidder',
        'total_bid',
        'current_price',
        'token',
    ];
}
