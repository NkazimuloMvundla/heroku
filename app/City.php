<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{

    protected $fillable = [
        'ct_cn_id' , 'ct_name',
    ];
}
