<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MockIP extends Model
{
    use HasFactory;
    protected $fillable = [
        'index',
        'value'
    ];
}
