<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;

class SellingRequestsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
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
        $measurementUnits = \App\MeasurementUnit::all();
        $sellingRequests = \App\SellingRequests::all();
        $countSellingRequest = count($sellingRequests);
        $buyingRequests = \App\BuyingRequest::all();
        $countBuyingRequest = count($buyingRequests);
        if (Auth::check()) {
            $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
            $count = count($userMessages);
            return view('front.selling-request', compact('pCats', 'subCats', 'lastCats', 'parent_category', 'measurementUnits', 'count', 'countBuyingRequest', 'countSellingRequest'));
        } else {

            return view('front.selling-request', compact('pCats', 'subCats', 'lastCats', 'parent_category', 'measurementUnits'));
        }
    }


    public function store(Request $request)
    {

        $data = request()->validate([
            'mainCategory' => ['required', 'numeric'],
            'Category' => ['required', 'numeric'],
            'subCategory' => ['required', 'numeric'],
            'productName' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:255'],
            'detailedSpecification' => ['required', 'string', 'max:255'],
            'orderQuantity' => ['required', 'numeric'],
            'orderQuantityUnit' => ['required', 'string', 'max:255'],
            'deliveryDate' => ['required', 'string', 'max:255'],
            'sr_u_id' => ['numeric'],

        ]);

        \App\SellingRequests::create([
            'sr_u_id' => $data['sr_u_id'],
            'sr_pc_id' => $data['subCategory'],
            'sr_pc_name' => $data['productName'],
            'sr_pd_spec' => $data['detailedSpecification'],
            'message' => $data['message'],
            'sr_order_qty' => $data['orderQuantity'],
            'sr_order_qnty_unit' => $data['orderQuantityUnit'],
            'sr_expired_time' => $data['deliveryDate']
        ]);

        \App\AdminNotifications::create([
            'message' => $data['sr_u_id'] . " has posted a selling request " . " ",
        ]);
        Session::flash('sellingRequestPosted', "Selling Request Posted Successfully. ");
        return redirect()->back();
    }

    //all selling requests
    public function allSellingView()
    {

        $parent_category = \App\productCategory::all();
        $pCats = \App\productCategory::all();
        $subCats = \App\SubCategory::all();
        $lastCats = \App\lastCategory::all();
        $sellingRequests = \App\SellingRequests::where('sr_approval_status', 1)->get();
        $measurementUnits = \App\MeasurementUnit::all();
        $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
        $countSellingRequest = count($sellingRequests);
        $count = count($userMessages);
        $users = \App\User::all();
        $buyingRequests = \App\BuyingRequest::all();
        $countBuyingRequest = count($buyingRequests);

        if (!empty($buyingRequests)) {

            return view('front.all-selling-requests', compact('pCats', 'subCats', 'lastCats', 'parent_category', 'buyingRequests', 'measurementUnits', 'users', 'count', 'countSellingRequest', 'countBuyingRequest', 'sellingRequests'));
        }

        return view('front.all-selling-requests', compact('pCats', 'subCats', 'lastCats', 'parent_category', 'count', 'countBuyingRequest', 'sellingRequests', 'users'));
    }


    public function sendAmessageView($request_id)
    {
        $decoded_id = base64_decode($request_id);

        validator([
            $decoded_id => ['required', 'numeric'],
        ]);
        $parent_category = \App\productCategory::all();
        $pCats = \App\productCategory::all();
        $subCats = \App\SubCategory::all();
        $lastCats = \App\lastCategory::all();
        $sendAmessage = \App\SellingRequests::where('id', $decoded_id)->get();
        $measurementUnits = \App\MeasurementUnit::all();
        $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
        $count = count($userMessages);
        $users = \App\User::all();
        $buyingRequests = \App\BuyingRequest::all();
        $countBuyingRequest = count($buyingRequests);

        if (!empty($buyingRequests)) {

            return view('front.send-selling-request-message', compact('pCats', 'subCats', 'lastCats', 'parent_category', 'buyingRequests', 'measurementUnits', 'users', 'count', 'countBuyingRequest', 'sendAmessage'));
        }

        return view('front.send-selling-request-message', compact('pCats', 'subCats', 'lastCats', 'parent_category', 'count', 'countBuyingRequest', 'users'));
    }

    public function allSellingSingleView()
    {
        if (request()->ajax()) {
            $data = request()->validate([
                'id' => ['numeric'],
            ]);
            // $result = \App\BuyingRequest::where('id', $data['id'])->get();
            $result = \App\SellingRequests::where('id', $data['id'])->get(['sr_pc_name', 'sr_pd_spec', 'message']);
            return $result;
        }
    }
}
