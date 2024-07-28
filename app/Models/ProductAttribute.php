<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'quantity',
        'weight',
        'width',
        'length',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
