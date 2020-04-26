<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function create()
    {

        $notifications = \App\Notifications::where('user_id', Auth::user()->id)->get();
        return view('admin.notifications', compact('notifications'));
    }

    public function destroy()
    {

        if (request()->ajax()) {
            $data = request()->validate([
                'id' => ['numeric'],


            ]);
            \App\Notifications::where('id', $data['id'])->delete();
        }
    }
}
