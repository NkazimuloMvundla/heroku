<?php

namespace App;


//use Illuminate\Foundation\Auth\superUser as Authenticatable;
//use Illuminate\Notifications\Notifiable;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class superUser extends  Authenticatable
{


    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $guard = 'admin';

    protected $fillable = [
        'admin_name',

        'email',

        'password',

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
