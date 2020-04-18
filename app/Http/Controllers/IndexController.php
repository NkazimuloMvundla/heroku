<?php

namespace App\Http\Controllers;

use Session;
use DB;
use Auth;

class IndexController extends Controller
{
     public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    
    public function create()
    {
        $pCats = \App\productCategory::all();
        $subCats = \App\SubCategory::all();
        $lastCats = \App\lastCategory::all();
        $slide_one = \App\Product::take(8)->where('pd_approval_status', 1)->inRandomOrder()->get();
        $featured_images = \App\Photo::all();
        $pd_images = \App\Photo::all();
        $buyingRequests = \App\BuyingRequest::all();
        $find_by_category = DB::table('sub_categories')->whereIn('pc_name', array('Fruit & Veg', 'Bags', 'Home & Appliances', 'Health & Beauty', 'Shoes', 'Cell Phones & Accessories', 'Baby Food', 'Dairy Products', 'Baked Goods', 'Safety Product', 'Construction steel', 'Textile', 'Apparels'))->get();
        $featured_suppliers = \App\User::where('account_type', 'supplier')->take(4)->get();
        $countBuyingRequest = count($buyingRequests);
        $banners = \App\Banner::all();


        if (Auth::check()) {
            $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
            $count = count($userMessages);
            return view('front.Index', compact('pCats', 'subCats', 'lastCats', 'slide_one', 'pd_images', 'featured_images', 'find_by_category', 'featured_suppliers', 'count', 'countBuyingRequest', 'banners'));
        } else {
            return view('front.Index', compact('pCats', 'subCats', 'lastCats', 'slide_one', 'pd_images', 'featured_images', 'find_by_category', 'featured_suppliers', 'banners'));
        }
    }

    public function account_type()
    {
        $pCats = \App\productCategory::all();
        $subCats = \App\SubCategory::all();
        $lastCats = \App\lastCategory::all();
        $buyingRequests = \App\BuyingRequest::all();
        $countBuyingRequest = count($buyingRequests);
        if (Auth::check()) {
            $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
            $count = count($userMessages);
            return view('front.account_type', compact('pCats', 'subCats', 'lastCats', 'count', 'countBuyingRequest'));
        } else {
            return view('front.account_type', compact('pCats', 'subCats', 'lastCats'));
        }
    }
}
