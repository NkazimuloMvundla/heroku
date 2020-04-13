<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
      protected $fillable = [
        'name',
        'lastname',
        'email',
        'company_name' ,
        'phone_number',
        'account_type',
        'password',
        'about_us',
        'company_logo' ,
        'company_slogan',
        'company_background_img' ,
        'zip_code',
        'company_address',
        'country',
        'province',
    ];
}
