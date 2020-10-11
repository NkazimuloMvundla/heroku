<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'pd_id' , 'rating', 'review', 'rated_by', 'rater_id'
    ];
}
