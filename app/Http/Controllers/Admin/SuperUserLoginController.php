<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SuperUserLoginController extends Controller
{
    use AuthenticatesUsers;


    /**
     * Where to redirect users after login.
     *
     * @var string
     */


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $guard = 'admin';
    protected $redirectTo = '/super/login';






    public function __construct()
    {
        //  $this->middleware('guest')->except('logout');
        //  $this->middleware('guest:admin')->except('logout');
    }



    public function showLoginForm()
    {
        return view('super.access.login');
    }

    protected function guard()
    {
        return Auth::guard($this->guard);
    }

    public function checklogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (Auth::guard('admin')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            // return redirect('/super');
            Session::put('super', $request->email);
            return redirect()->route('super.index');
        }
        return redirect('/super/login')->with('error', 'Invalid Email address or Password');
    }
}
