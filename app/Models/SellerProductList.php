<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerProductList extends Model
{
    use HasFactory;
    protected $fillable = [
        'seller_serial',
        'image',
        'name',
        'short_des',
        'starting_price',
        'status',
    ];
}
