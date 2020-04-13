<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'pd_u_id',
        'pd_subCategory_id',
        'pd_category_id',
        'pd_name',
        'pd_keyword',
        'pd_listing_description',
        'pd_min_order_qty',
        'minOrderUnit',
        'max_price',
        'min_price',
        'fob_mu_id',
        'port',
        'pd_payment_term',
        'pd_photo',
        'capacity',
        'pd_supply_ability',
        'supplyPeriod',
        'pd_delivery_time',
    ];
}
