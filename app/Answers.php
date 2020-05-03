<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answers extends Model
{
    protected $fillable = [
        'pd_id',
        'question_id',
        'answer'

    ];
}
