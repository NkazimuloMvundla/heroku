<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use DB;

class NotificationsController extends Controller
{
    public function create()
    {

        $notifications =  DB::table('notifications')->where('user_id', Auth::user()->id)->latest()->get();
        // dd($notifications);
        $countNotifications = count($notifications);
        Session::put('notifications', $notifications);
        Session::put('count_notifications', $countNotifications);
        return view('admin.notifications', compact('notifications'));
    }

    public function destroy()
    {

        if (request()->ajax()) {
            $data = request()->validate([
                'id' => ['numeric'],

            ]);
            \App\Notifications::where('id', trim($data['id']))->delete();
        }
    }


    public function destroyAll()
    {

        if (request()->ajax()) {

            \App\Notifications::where('user_id', Auth::user()->id)->delete();
        }
    }
}
