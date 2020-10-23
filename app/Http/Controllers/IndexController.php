<?php

namespace App\Http\Controllers;

use Session;
use DB;
use Auth;

class IndexController extends Controller
{


    public function create()
    {
        $pCats = \App\productCategory::all();
        $subCats = \App\SubCategory::all();
        $lastCats = \App\lastCategory::all();
        $featured_products = \App\Product::take(12)->where('pd_approval_status', 1)->where('pd_featured_status', 1)->inRandomOrder()->get(); 
        if(Auth::check()){
        $favs = \App\my_favorite::where('mf_u_id',Auth::user()->id)->get();
        $countFavs = count($favs);
       // dd($countFavs);

        $fav = $favs->pluck('mf_pd_id'); // Collection contains only user names
        }

      
       
  
        
      /*  $featured_product = [];
        $newArraySize = array_push($featured_product,$featured_products); 
        $newArraySize = array_push($featured_product,$favs); 
        dd($featured_product); // Array is passed by reference, therefore the original array is modified to
        */
       // dd($favs);

        //join subcats with current product id
       /* $favs = DB::table('products')
                ->join('my_favorites', 'my_favorites.mf_pd_id', '=', 'products.pd_id')->take(12)->where('pd_approval_status', 1)->where('pd_featured_status', 1)->inRandomOrder()->get();
       //     dd($favs);*/

        $featured_images = \App\Photo::all();
        $pd_images = \App\Photo::all();
        $buyingRequests = \App\BuyingRequest::where('br_approval_status', 1)->get();
        $measurementUnits = \App\MeasurementUnit::all();
        $find_by_category = DB::table('sub_categories')->whereIn('pc_name', array('Fruit & Veg', 'Bags', 'Home & Appliances', 'Health & Beauty', 'Shoes', 'Cell Phones & Accessories', 'Baby Food', 'Dairy Products', 'Baked Goods', 'Safety Product', 'Construction steel', 'Textile', 'Apparels'))->get();
        $featured_suppliers = \App\User::where('featured', 1)->take(6)->get();
        $countBuyingRequest = count($buyingRequests);
        $banners = \App\Banner::all();


        if (Auth::check()) {
            $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
            $count = count($userMessages);
            return view('front.Index', compact('pCats', 'subCats', 'lastCats', 'featured_products', 'pd_images', 'featured_images', 'measurementUnits', 'find_by_category', 'featured_suppliers', 'count', 'countBuyingRequest', 'banners', 'fav', 'countFavs'));
        } else {
            return view('front.Index', compact('pCats', 'subCats', 'lastCats', 'featured_products', 'pd_images', 'featured_images', 'measurementUnits', 'find_by_category', 'featured_suppliers', 'banners'));
        }
    }

    public function account_type()
    {
        $pCats = \App\productCategory::all();
        $subCats = \App\SubCategory::all();
        $lastCats = \App\lastCategory::all();
        $buyingRequests = \App\BuyingRequest::where('br_approval_status', 1)->get();
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
