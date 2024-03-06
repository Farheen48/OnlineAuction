<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoneyTransac extends Model
{
    use HasFactory;
    protected $fillable = [
        'identifier',
        'token',
        'description',
        'amount',
        'status',
    ];
}
