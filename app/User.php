<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'lastname',
        'email',
        'company_name',
        'phone_number',
        'account_type',
        'password',
        'about_us',
        'industry',
        'company_logo',
        'company_slogan',
        'company_background_img',
        'zip_code',
        'company_address',
        'country',
        'province',
        'registration_number'
    ];



    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function Profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function BuyingRequests()
    {
        return $this->hasMany(BuyingRequest::class);
    }
}
