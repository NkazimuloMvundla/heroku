<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Response;
use Session;
use DB;

class ManageRequestsController extends Controller
{
    public function create()
    {
        $user = Auth::user()->id;

        $buyingRequests = \App\BuyingRequest::where('br_u_id', $user)->get();
        $notifications =  DB::table('notifications')->where('user_id', Auth::user()->id)->get();
        $countNotifications = count($notifications);
        Session::put('notifications', $notifications);
        Session::put('count_notifications', $countNotifications);
        $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
        $count = count($userMessages);
        Session::put('user_messages', $userMessages);
        Session::put('user_messages_count', $count);
        return view('admin.manage-buy-request', compact('buyingRequests'));
    }
    //selling requests
    public function SellingView()
    {
        $user = Auth::user()->id;
        $sellingRequests = \App\SellingRequests::where('sr_u_id', $user)->get();
        $notifications =  DB::table('notifications')->where('user_id', Auth::user()->id)->get();
        $countNotifications = count($notifications);
        Session::put('notifications', $notifications);
        Session::put('count_notifications', $countNotifications);
        $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
        $count = count($userMessages);
        Session::put('user_messages', $userMessages);
        Session::put('user_messages_count', $count);
        return view('admin.manage-selling-request', compact('sellingRequests'));
    }

    public function update()
    {
        if (request()->ajax()) {
            $data = request()->validate([
                'id' => ['numeric'],
                'br_pd_spec' => ['string'],

            ]);

            \App\BuyingRequest::where('id', trim($data['id']))->update(['br_pd_spec' =>  trim($data['br_pd_spec']), 'br_approval_status' => 0]);
        }
    }

    public function deleteRequest()
    {
        if (request()->ajax()) {
            $data = request()->validate([
                'id' => ['numeric'],
            ]);

            \App\BuyingRequest::where('id', trim($data['id']))->delete();
        }
    }


    //selling request
    public function updateSellingRequest()
    {
        if (request()->ajax()) {
            $data = request()->validate([
                'id' => ['numeric'],
                'sr_pd_spec' => ['string'],

            ]);

            \App\SellingRequests::where('id', trim($data['id']))->update(['sr_pd_spec' =>  trim($data['sr_pd_spec']), 'sr_approval_status' => 0]);
        }
    }

    public function deleteSellingRequest()
    {
        if (request()->ajax()) {
            $data = request()->validate([
                'id' => ['numeric'],
            ]);

            \App\SellingRequests::where('id', trim($data['id']))->delete();
        }
    }
    /*-------------------------------------------*/
    //==================super admin============//
    public function view()
    {

        $buyingRequests = DB::table('buying_requests')->paginate(5);
        $sub_categories = DB::table('last_categories')->get();
        $users = DB::table('users')->get();
        $count = count($buyingRequests);

        return view('super.manage-buy-request', compact('buyingRequests', 'count', 'sub_categories', 'users'));
    }
    //selling request view
    public function SellingRequestsView()
    {

        $sellingRequests = DB::table('selling_requests')->paginate(5);
        $sub_categories = DB::table('last_categories')->get();
        $users = DB::table('users')->get();
        $count = count($sellingRequests);

        return view('super.manage-selling-requests', compact('sellingRequests', 'count', 'sub_categories', 'users'));
    }


    //buying-request
    public function takeActionBuyingRequests(Request $request)
    {

        if (request()->ajax()) {

            $data = request()->validate([
                'id' => ['numeric'],
                'br_id' => ['numeric'],

            ]);
            if ($data['id'] == 1) {
                \App\BuyingRequest::where('id', $data['br_id'])->update(['br_approval_status' => 1]);
                $res = \App\BuyingRequest::where('id', $data['br_id'])->get('br_approval_status');
                return response($res);
            } else {
                \App\BuyingRequest::where('id', $data['br_id'])->update(['br_approval_status' => 2]);
                $res = \App\BuyingRequest::where('id', $data['br_id'])->get('br_approval_status');
                return response($res);
            }
        }
    }



    public function deleteSingleRequest()
    {

        if (request()->ajax()) {
            $id = request()->validate([
                'id' => ['numeric'],
            ]);
            \App\BuyingRequest::where('id', trim($id))->delete();
        }
    }

    public function destroyMultiplerequests()
    {

        if (request()->ajax()) {

            $data = request()->validate([
                'checked' => ['array'],
                'checked.*' => ['numeric'],

            ]);
            foreach ($data['checked'] as $id) {
                \App\BuyingRequest::where('id', trim($id))->delete();
            }
        }
    }

    public function showRequest()
    {

        if (request()->ajax()) {
            $data = request()->validate([
                'id' => ['numeric'],
            ]);

            $result = \App\BuyingRequest::where('id', trim($data['id']))->get();
            // $photos = \App\Photo::where('pd_photo_id' , $data['id'])->get();
            /*
                  foreach ($photos as $value) {
                   $data =  '<img src="/storage/' . $value['pd_filename'] . '"' . 'width="100"' . 'height="200"' . '>' ;
                  }
                  */
            return response::json($result);
        }
    }

    public function showUser()
    {

        if (request()->ajax()) {
            $data = request()->validate([
                'id' => ['numeric'],
            ]);
            $result = \App\User::where('id', trim($data['id']))->get();
            return response::json($result);
        }
    }


    //selling request
    public function takeActionSellingRequests(Request $request)
    {

        if (request()->ajax()) {

            $data = request()->validate([
                'id' => ['numeric'],
                'sr_id' => ['numeric'],

            ]);
            if ($data['id'] == 1) {
                \App\SellingRequests::where('id', $data['sr_id'])->update(['sr_approval_status' => 1]);
                $res = \App\SellingRequests::where('id', $data['sr_id'])->get('sr_approval_status');
                return response($res);
            } else {
                \App\SellingRequests::where('id', $data['sr_id'])->update(['sr_approval_status' => 2]);
                $res = \App\SellingRequests::where('id', $data['sr_id'])->get('sr_approval_status');
                return response($res);
            }
        }
    }
    public function showSellingRequestUser()
    {

        if (request()->ajax()) {
            $data = request()->validate([
                'id' => ['numeric'],
            ]);
            $result = \App\User::where('id', trim($data['id']))->get();
            return response::json($result);
        }
    }
    public function showSellingRequest()
    {

        if (request()->ajax()) {
            $data = request()->validate([
                'id' => ['numeric'],
            ]);

            $result = \App\SellingRequests::where('id', $data['id'])->get();
            // $photos = \App\Photo::where('pd_photo_id' , $data['id'])->get();
            /*
                  foreach ($photos as $value) {
                   $data =  '<img src="/storage/' . $value['pd_filename'] . '"' . 'width="100"' . 'height="200"' . '>' ;
                  }
                  */
            return response::json($result);
        }
    }

    public function deleteSingleSellingRequest()
    {

        if (request()->ajax()) {
            $id = request()->validate([
                'id' => ['numeric'],
            ]);
            \App\SellingRequests::where('id', trim($id))->delete();
        }
    }

    public function destroyMultipleSellingrequests()
    {

        if (request()->ajax()) {

            $data = request()->validate([
                'checked' => ['required', 'array'],
                'checked.*' => ['numeric'],

            ]);


            foreach ($data['checked'] as $id) {
                \App\SellingRequests::where('id', trim($id))->delete();
            }
        }
    }
}
