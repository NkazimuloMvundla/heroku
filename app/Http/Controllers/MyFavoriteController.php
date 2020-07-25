<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use Auth;
use DB;

class MyFavoriteController extends Controller
{
    public function create()
    {
        $favorites = \App\my_favorite::where('mf_u_id', Auth()->user()->id)->get();
        $notifications =  DB::table('notifications')->where('user_id', Auth::user()->id)->get();
        $countNotifications = count($notifications);
        Session::put('notifications', $notifications);
        Session::put('count_notifications', $countNotifications);
        $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
        $count = count($userMessages);
        Session::put('user_messages', $userMessages);
        Session::put('user_messages_count', $count);
        $products = \App\Product::all();
        $pd_images = \App\Photo::all(); 

        return view('admin.my_favorites', compact('favorites', 'products', 'pd_images'));
    }

    public function addFavorite(Request $request)
    {

        if (Auth::check()) {
            if (request()->ajax()) {

                $data = request()->validate([
                    'id' => ['numeric'],
                    'u_id' => ['numeric']
                ]);
                $count = \App\my_favorite::where('mf_pd_id', trim($data['id']))->where('mf_u_id', trim($data['u_id']))->get();
                if (count($count) > 0) {
                  $count = \App\my_favorite::where('mf_pd_id', trim($data['id']))->delete();
                  return 0;

                } else {
                    \App\my_favorite::create([
                        'mf_u_id' => $data['u_id'],
                        'mf_pd_id' => trim($data['id']),
                    ]);
               return 1;
                }
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function removeFav()
    {
        if (request()->ajax()) {
            $data = request()->validate([
                'id' => ['numeric'],
            ]);
            \App\my_favorite::where('mf_pd_id', trim($data['id']))->delete();
        }
    }
}
