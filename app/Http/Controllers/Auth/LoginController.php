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
    protected $redirectTo = '/home';

    /*
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        //$this->middleware('guest:admin')->except('logout');
    }
*/

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
            return redirect()->intended('/home');
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

    /*
    //login for Super User
    public function showAdminLoginForm()
    {
        return view('super.access.login');
    }



    public function checklogin()
    {
        $this->validate(request(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (Auth::guard('admin')->attempt([
            'email' => request()->email,
            'password' => request()->password
        ])) {
            // return redirect('/super');
            Session::put('super', request()->email);
            return redirect()->route('super.index');
        }
        return redirect('/super/login')->with('error', 'Invalid Email address or Password');
    }
    */
}
