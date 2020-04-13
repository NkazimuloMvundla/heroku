<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;

class SuperUserRegistrationController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    // protected $redirectTo = '/super/login';

    //protected $guard = 'admin';

    public function __construct()
    {
        //  $this->middleware('guest');
        //  $this->middleware('guest:admin');
    }



    public function Adminregister()
    {
        return view('super.access.registration');
    }

    public function register()
    {
        $data = request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:super_users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        \App\superUser::create([
            'admin_name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return redirect('/super/login');
    }
}
