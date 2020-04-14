<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */



    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/';


    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function postLogin()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            session([
                'email' => request('email')
            ]);
            //Check if user still needs to confirm their email
            if (Auth::user()->email_verified_at == NULL) {
                Auth::logout();
                Session::flash('message', "You need to confirm your email in order to activate your account ");
                return redirect()->to('/login');
            }
            return redirect()->intended('/');
        } else {
            Session::flash('message', "Invalid Credentials , Please try again.");
            return redirect()->back();
        }
    }


    public function Logout()
    {
        auth()->logout();

        session()->flash('message', 'Come back again!');

        return redirect('/login');
    }
}
