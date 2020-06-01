<?php

namespace App\Http\Controllers;

use App\superUser;
use Illuminate\Http\Request;
use Session;
use Auth;


class SuperIndexController extends Controller
{
    public function view()
    {

        $adminNotifications = \App\AdminNotifications::all();
        $adminCountNotifications = count($adminNotifications);
        Session::put('Adminnotifications', $adminNotifications);
        Session::put('count_AdminNotifications', $adminCountNotifications);

        return view('super.index', compact('adminNotifications', 'adminCountNotifications'));
    }

    public function destroy()
    {

        if (request()->ajax()) {
            $data = request()->validate([
                'id' => ['numeric'],

            ]);
            \App\AdminNotifications::where('id', trim($data['id']))->delete();
        }
    }


    public function destroyAll()
    {

        if (request()->ajax()) {

            \App\AdminNotifications::where('user_id', Auth::user()->id)->delete();
        }
    }
}
