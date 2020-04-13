<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeaturedProduct extends Model
{
    protected $fillable = [
        'u_id',  'pd_id', 'pd_image',
   ];
}
