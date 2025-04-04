<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Stock extends Model
{
    use HasFactory;

    protected $table = 'stocks';

    protected $fillable = [
        'product_sku',
        'store_id',
        'product_piece',
        'size_id'
    ];

    public $timestamps = false;

    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_sku', 'product_sku');
    }
}