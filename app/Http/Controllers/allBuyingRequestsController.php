<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Response;
use Auth;

class allBuyingRequestsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function create()
    {

        $parent_category = \App\productCategory::all();
        $pCats = \App\productCategory::all();
        $subCats = \App\SubCategory::all();
        $lastCats = \App\lastCategory::all();
        $buyingRequests = \App\BuyingRequest::all();
        $measurementUnits = \App\MeasurementUnit::all();
        $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
        $countBuyingRequest = count($buyingRequests);
        $count = count($userMessages);
        $users = \App\User::all();

        if (!empty($buyingRequests)) {

            return view('front.all-buying-requests', compact('pCats', 'subCats', 'lastCats', 'parent_category', 'buyingRequests', 'measurementUnits', 'users', 'count', 'countBuyingRequest'));
        }

        return view('front.all-buying-requests', compact('pCats', 'subCats', 'lastCats', 'parent_category', 'count', 'countBuyingRequest', 'users'));
    }


    public function show()
    {

        if (request()->ajax()) {
            $data = request()->validate([
                'id' => ['numeric'],
            ]);
            $result = \App\BuyingRequest::where('id', $data['id'])->get();
            return response::json($result);
        }
    }
}
