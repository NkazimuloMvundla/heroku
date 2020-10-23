<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Validator;

class ProductsByCategoryController extends Controller
{
    //
    public function create($sub_cat_name, $category_id)
    {
        $decoded_category_id = base64_decode($category_id);
        $decoded_category_id =  trim($decoded_category_id);
        $sanitized_last_category_id = filter_var($decoded_category_id, FILTER_SANITIZE_NUMBER_INT);
        if (filter_var($sanitized_last_category_id, FILTER_VALIDATE_INT)) {
            $parent_category = \App\productCategory::all();
            $pCats = \App\productCategory::all();
            $subCats = \App\SubCategory::all();
            $lastCats = \App\lastCategory::all();
            $category = \App\SubCategory::findOrfail($sanitized_last_category_id);
            $lasts = \App\lastCategory::where('pc_id', $sanitized_last_category_id)->get();
            $count = count($lasts);

            $buyingRequests = \App\BuyingRequest::where('br_approval_status', 1)->get();
                if(Auth::check()){
                    $favs = \App\my_favorite::where('mf_u_id',Auth::user()->id)->get();
                    $countFavs = count($favs);
                    $fav = $favs->pluck('mf_pd_id'); 
                }
            if ($count > 0) {
                $products = DB::table('products')->where('pd_category_id', $sanitized_last_category_id)->inRandomOrder()->paginate(50);  //to render random products

            } else {
                $products = DB::table('products')->where('pd_category_id', $sanitized_last_category_id)->inRandomOrder()->paginate(50); //to render random
            }

            $pd_images = \App\Photo::all();
            $countBuyingRequest = count($buyingRequests);
            if (Auth::check()) {
                $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
                $count = count($userMessages);

                return view('front.products-by-category', compact('pCats', 'subCats', 'lastCats', 'parent_category', 'category', 'lasts', 'products', 'fav', 'pd_images', 'count', 'countBuyingRequest'));
            } else {

                return view('front.products-by-category', compact('pCats', 'subCats', 'lastCats', 'parent_category', 'category', 'lasts', 'products', 'pd_images'));
            }
        } else {
            return redirect()->back();
        }
    }

    public function showByCat($last_cat_name, $last_category_id)
    {


        $decoded_last_category_id = base64_decode($last_category_id);
        $decoded_last_category_id = trim($decoded_last_category_id);
        $decoded_last_cat_name = base64_decode($last_cat_name);
        $decoded_last_cat_name = trim($last_cat_name);
        $sanitized_last_category_id = filter_var($decoded_last_category_id, FILTER_SANITIZE_NUMBER_INT);
        if (filter_var($sanitized_last_category_id, FILTER_VALIDATE_INT)) {
            $parent_category = \App\productCategory::all();
            $pCats = \App\productCategory::all();
            $subCats = \App\SubCategory::all();
            $lastCats = \App\lastCategory::all();

            $lasts = \App\lastCategory::where('id', $sanitized_last_category_id)->get();
            $count = count($lasts);
                if(Auth::check()){
                    $favs = \App\my_favorite::where('mf_u_id',Auth::user()->id)->get();
                    $countFavs = count($favs);
                    $fav = $favs->pluck('mf_pd_id'); 
                }
            foreach ($lasts as $last) {

                $pc_id = $last['pc_id'];
            }

            if ($count > 0) {
                $last_category = \App\lastCategory::where('pc_id', $pc_id)->get();
                //join last_categories with current product id

                //incase you want to count how many products foreach category
                /*  $last_category = DB::table('last_categories')
                    ->join('products', 'products.pd_subCategory_id', '=', 'last_categories.id')->where('last_categories.id', $sanitized_last_category_id)->get();*/
            } else {
                return redirect()->back();
            }


            //$products = \App\Product::where('pd_pc_id', $category_id)->get();
            $products = DB::table('products')->where('pd_subCategory_id', $sanitized_last_category_id)->paginate(50);



            //join last_categories with current product id
            $last_categories = DB::table('sub_categories')
                ->join('last_categories', 'last_categories.pc_id', '=', 'sub_categories.id')->where('last_categories.id', $sanitized_last_category_id)->get()->first();


            $buyingRequests = \App\BuyingRequest::where('br_approval_status', 1)->get();
            $countBuyingRequest = count($buyingRequests);
            if (Auth::check()) {
                $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
                $count = count($userMessages);

                return view('front.products-by-category-last-cat', compact('pCats', 'subCats', 'lastCats', 'parent_category', 'lasts', 'last_categories','fav', 'last_category', 'products', 'count', 'countBuyingRequest'));
            } else {

                return view('front.products-by-category-last-cat', compact('pCats', 'subCats', 'lastCats', 'parent_category', 'last_categories', 'lasts', 'last_category', 'products'));
            }
        } else {
            return redirect()->back();
        }
    }
}
