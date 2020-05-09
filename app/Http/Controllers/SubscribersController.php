<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscribersController extends Controller
{
    //
    public function store(Request $request)
    {
        if (request()->ajax()) {
            $data = request()->validate([
                'email' => ['required', 'email', 'max:255'],
            ]);
            $email = \App\Subscribers::where('email', $data['email'])->get();
            if (count($email) > 0) {
                echo htmlentities("You have already subscribed!");
            } else {
                \App\Subscribers::create([
                    'email' => $data['email'],
                ]);
                echo htmlentities("Thanks for subscribing to our newsletter!");
            }
        }
    }
}
