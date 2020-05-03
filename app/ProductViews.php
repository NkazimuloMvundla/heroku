<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductViews extends Model
{

    protected $fillable = [
        'user_id', 'product_id', 'views',
    ];

    public function Product()
    {
        return $this->belongsTo(Product::class);
    }
}
