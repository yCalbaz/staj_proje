<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts'; 

    protected $fillable = [
        'product_name',
        'product_sku',
        'product_price', 
        'product_piece',
        'product_image',
    ];

    public $timestamps = false;
}

