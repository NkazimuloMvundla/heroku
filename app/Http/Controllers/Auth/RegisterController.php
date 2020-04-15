<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        if (empty(Session::get('account_type'))) {
            return redirect('/account-type');
        } else if (Session::get('account_type') == 'Supplier' || Session::get('account_type') == 'Both') {
            $countries = \App\Country::where('cn_name', 'South Africa')->get();
            return view('auth.registration', compact('countries'));
        } else {
            $countries = \App\Country::all();
            return view('auth.registration', compact('countries'));
        }
    }


    public function save_account_type()
    {

        $data = request()->validate([
            'account_type' => ['required', 'string', 'max:255'],

        ]);

        Session::put('account_type',   $data['account_type']);


        if (Session::get('account_type') == 'Supplier' || Session::get('account_type') == 'Both') {
            $countries = \App\Country::where('cn_name', 'South Africa')->get();
            return view('auth.registration', compact('countries'));
        } else {
            $countries = \App\Country::all();
            return view('auth.registration', compact('countries'));
        }
    }



    protected function validator(array $data)
    {

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'company_name' => ['required', 'string', 'max:255'],
            'industry' => ['required', 'array', 'max:3'],
            'industry.*' => ['required', 'string'],
            'phone_number' => ['required', 'numeric', 'digits_between:0 ,10'],
            'country' => ['required', 'string', 'max:255'],
            'check' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $user =  User::create([
            'name' => $data['name'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'company_name' => $data['company_name'],
            'industry' => implode(',', $data['industry']),
            'account_type' => Session::get('account_type'),
            'phone_number' => $data['phone_number'],
            'country' => $data['country'],
            'password' => Hash::make($data['password']),
        ]);


        /*if (
            Mail::to($data['email'])->send(new WelcomeMail($user))
        ) {

            Session::flash('message', "hgj");
            return redirect()->to('/login');
        }*/

        return $user;
    }
}
