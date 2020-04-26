<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class notifications extends Model
{
    protected $fillable = [
        'user_id', 'product_id', 'message',
    ];
}
