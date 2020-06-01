<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use DB;

class AdminIndexController extends Controller
{
    public function create()
    {
        $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
        $count_emails = count($userMessages);
        $userFavs = \App\my_favorite::where('mf_u_id', Auth::user()->id)->get();
        $countUserFavs = count($userFavs);
        $product_listed = \App\Product::where('pd_u_id', Auth::user()->id)->get();
        $user_details = \App\User::where('id', Auth::user()->id)->get();
        // Session::flush();
        //Session::regenerate();
        Session::put('account', $user_details->first()->account_type);
        //dd(Session::get('account'));
        Session::put('date_created', $user_details->first()->created_at);
        //dd(Session::get('date_created'));
        $currentUserAccount =  $user_details->first()->account_type;
        $notifications =  DB::table('notifications')->where('user_id', Auth::user()->id)->get();
        $countNotifications = count($notifications);
        Session::put('user_messages', $userMessages);
        Session::put('user_messages_count', $count_emails);
        Session::put('notifications', $notifications);
        Session::put('count_notifications', $countNotifications);
        return view('admin.index', compact('count_emails', 'product_listed', 'countUserFavs', 'notifications'));
    }
}
