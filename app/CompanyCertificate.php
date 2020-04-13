<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyCertificate extends Model
{
    protected $fillable = [
        'user_id', 'filename',
    ];
}
