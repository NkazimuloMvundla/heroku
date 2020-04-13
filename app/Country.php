<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{

    protected $fillable = [
        'cn_name', 'cn_flag',
   ];
}
