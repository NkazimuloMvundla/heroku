<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class ProductsByCategoryController extends Controller
{
    //
    public function create($sub_cat_name, $category_id)
    {
        $decoded_category_id = base64_decode($category_id);
        $parent_category = \App\productCategory::all();
        $pCats = \App\productCategory::all();
        $subCats = \App\SubCategory::all();
        $lastCats = \App\lastCategory::all();
        $category = \App\SubCategory::findOrfail($decoded_category_id);
        $lasts = \App\lastCategory::where('pc_id', $decoded_category_id)->get();
        $count = count($lasts);

        $buyingRequests = \App\BuyingRequest::all();
        if ($count > 0) {
            $products = DB::table('products')->where('pd_category_id', $decoded_category_id)->inRandomOrder()->paginate(1);  //to render random products

        } else {
            $products = DB::table('products')->where('pd_category_id', $decoded_category_id)->inRandomOrder()->paginate(1); //to render random products
            //  return redirect()->back();
        }

        $pd_images = \App\Photo::all();
        $countBuyingRequest = count($buyingRequests);
        if (Auth::check()) {
            $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
            $count = count($userMessages);

            return view('front.products-by-category', compact('pCats', 'subCats', 'lastCats', 'parent_category', 'category', 'lasts', 'products', 'pd_images', 'count', 'countBuyingRequest'));
        } else {

            return view('front.products-by-category', compact('pCats', 'subCats', 'lastCats', 'parent_category', 'category', 'lasts', 'products', 'pd_images'));
        }
    }
    //
    public function showByCat($last_cat_name, $last_category_id)
    {
        $decoded_last_category_id = base64_decode($last_category_id);
        $parent_category = \App\productCategory::all();
        $pCats = \App\productCategory::all();
        $subCats = \App\SubCategory::all();
        $lastCats = \App\lastCategory::all();

        $lasts = \App\lastCategory::where('id', $decoded_last_category_id)->get();
        $count = count($lasts);
        foreach ($lasts as $last) {

            $pc_id = $last['pc_id'];
        }

        if ($count > 0) {
            $last_category = \App\lastCategory::where('pc_id', $pc_id)->get();
        } else {
            return redirect()->back();
        }


        //$products = \App\Product::where('pd_pc_id', $category_id)->get();
        $products = DB::table('products')->where('pd_subCategory_id', $decoded_last_category_id)->paginate(2);
        //$products = DB::table('products')->where('pd_category_id', $category_id)->inRandomOrder()->paginate(50); //to render random products

        $pd_images = \App\Photo::all();
        $buyingRequests = \App\BuyingRequest::all();
        $countBuyingRequest = count($buyingRequests);
        if (Auth::check()) {
            $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
            $count = count($userMessages);

            return view('front.products-by-category-last-cat', compact('pCats', 'subCats', 'lastCats', 'parent_category', 'lasts', 'last_category', 'products', 'pd_images', 'count', 'countBuyingRequest'));
        } else {

            return view('front.products-by-category-last-cat', compact('pCats', 'subCats', 'lastCats', 'parent_category', 'lasts', 'last_category', 'products', 'pd_images'));
        }
    }
}
