<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Response;
use Session;

class BuyingRequestController extends Controller
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
        $buyingRequests = \App\BuyingRequest::where('br_approval_status', 1)->get();
        $countBuyingRequest = count($buyingRequests);
        if (Auth::check()) {
            $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
            $count = count($userMessages);
            return view('front.buying-request', compact('pCats', 'subCats', 'lastCats', 'parent_category', 'measurementUnits', 'count', 'countBuyingRequest'));
        } else {

            return view('front.buying-request', compact('pCats', 'subCats', 'lastCats', 'parent_category', 'measurementUnits'));
        }
    }

    public function store(Request $request)
    {

        $data = request()->validate([
            'mainCategory' => ['required', 'numeric'],
            'c_id' => ['required', 'numeric'],
            'subCategory' => ['required', 'numeric'],
            'productName' => ['required', 'string', 'max:255'],
            'detailedSpecification' => ['required', 'string', 'max:255'],
            'orderQuantity' => ['required', 'numeric'],
            'orderQuantityUnit' => ['required', 'string', 'max:255'],
            'deliveryDate' => ['string'],
            'br_u_id' => ['numeric'],

        ]);

        \App\BuyingRequest::create([
            'br_u_id' => trim($data['br_u_id']),
            'br_pc_id' => trim($data['subCategory']),
            'br_pc_name' => trim($data['productName']),
            'br_pd_spec' => trim($data['detailedSpecification']),
            'br_order_qty' => trim($data['orderQuantity']),
            'br_order_qnty_unit' => trim($data['orderQuantityUnit']),
            'br_expired_time' => trim($data['deliveryDate'])
        ]);

        \App\AdminNotifications::create([
            'message' => " a buying request has been posted " .  " for " . $data['productName'],
        ]);
        Session::flash('buyingRequestPosted', "Buying Request Posted Successfully. ");
        return redirect()->back();
    }

    //all buying requests

    public function allBuyingView()
    {

        $parent_category = \App\productCategory::all();
        $pCats = \App\productCategory::all();
        $subCats = \App\SubCategory::all();
        $lastCats = \App\lastCategory::all();
        $buyingRequests = \App\BuyingRequest::where('br_approval_status', 1)->get();
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
    public function sendAmessageView($request_id)
    {
        $decoded_id = base64_decode($request_id);
        $decoded_id = trim($decoded_id);

        $sanitized_product_id = filter_var($decoded_id, FILTER_SANITIZE_NUMBER_INT);
        if (filter_var($sanitized_product_id, FILTER_VALIDATE_INT)) {
            $parent_category = \App\productCategory::all();
            $pCats = \App\productCategory::all();
            $subCats = \App\SubCategory::all();
            $lastCats = \App\lastCategory::all();
            $sendAmessage = \App\BuyingRequest::where('id', $sanitized_product_id)->get();
            $measurementUnits = \App\MeasurementUnit::all();
            $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
            $count = count($userMessages);
            $users = \App\User::all();
              $buyingRequests = \App\BuyingRequest::where('br_approval_status', 1)->get();
            $countBuyingRequest = count($buyingRequests);

            if (!empty($buyingRequests)) {

                return view('front.send-buying-request-message', compact('pCats', 'subCats', 'lastCats', 'parent_category', 'buyingRequests', 'measurementUnits', 'users', 'count', 'countBuyingRequest', 'sendAmessage'));
            }

            return view('front.send-buying-request-message', compact('pCats', 'subCats', 'lastCats', 'parent_category', 'count', 'countBuyingRequest', 'users'));
        }
    }
    public function allBuyingSingleView()
    {
        if (request()->ajax()) {
            $data = request()->validate([
                'id' => ['numeric'],
            ]);

            $result = \App\BuyingRequest::where('id', trim($data['id']))->get(['br_pc_name', 'br_pd_spec']);
            return $result;
        }
    }
}
