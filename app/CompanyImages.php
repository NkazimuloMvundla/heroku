<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyImages extends Model
{
     protected $fillable = [
        'user_id','company_image',
   ];
}
