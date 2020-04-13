<?php

namespace App\Http\Middleware;

use Closure;

class VerifyAccountType extends Middleware
{

    public function AccountType(){
     if(session()::has('account_type')){
     	return redirect('/register');
     }
    }



}
