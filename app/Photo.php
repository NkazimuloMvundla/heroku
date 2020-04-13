<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = [
        'pd_photo_id' , 'pd_u_id', 'pd_filename', 'pd_status', 'pd_priority',
    ];

}
