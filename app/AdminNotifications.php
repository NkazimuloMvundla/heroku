<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminNotifications extends Model
{

    protected $fillable = [
        'user_id', 'product_id', 'message',
    ];
}
