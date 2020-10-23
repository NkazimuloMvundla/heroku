<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use DB;
use Auth;
use Session;

class SearchController extends Controller
{

    public function livesearch(Request $request)
    {
        $term = $request->get('query');
        $term = trim($term);
        $validator = \Validator::make(request()->all(), [
            'query' => ['nullable', 'string', 'max:255'],
        ]);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator->errors());
        }
        $count = DB::table('products')->where("pd_name", "LIKE", "%$term%")->orderBy('pd_name')->limit(10)->get();
        $res = count($count);
        $output = '';
        if (!empty($term) && $res > 0) {
            $data = DB::table('products')->where("pd_name", "LIKE", "%$term%")->where('pd_approval_status', 1)->limit(10)->get();

            $searched_products = [];
            foreach ($data as $row1) {
                array_push($searched_products, $row1->pd_name);
                $uniqueProducts = array_unique($searched_products);
            }


            foreach ($uniqueProducts as $row) {

                $output .= '<li class="pd_search"><a href="/search/' . htmlspecialchars($row) . '">' . htmlspecialchars($row) . '</a></li>';
            }


            return response($output);
        } 
        
        else {
            $output .= 'No match found';

            return response($output);
        }
    }


    public function search($pd_name)
    {
        if (request()->pd_name != "") {
            Session::put("pd_name", $pd_name);
            $validator = \Validator::make(request()->all(), [
                'search' => ['nullable', 'string', 'max:255'],
            ]);
            if ($validator->fails()) {
                return back()->withInput()->withErrors($validator->errors());
            }
        }
        $Countproducts = DB::table('products')->where("pd_name", "LIKE", "%$pd_name%")->where('pd_approval_status', 1)->get();
        $products = DB::table('products')->where("pd_name", "LIKE", "%$pd_name%")->where('pd_approval_status', 1)->paginate(50);

        $Productcount = count($Countproducts);
        $pCats = \App\productCategory::all();
        $subCats = \App\SubCategory::all();
        $lastCats = \App\lastCategory::all();
        $pd_images = \App\Photo::all();
        $buyingRequests = \App\BuyingRequest::where('br_approval_status', 1)->get();
        $countBuyingRequest = count($buyingRequests);
         if(Auth::check()){
            $favs = \App\my_favorite::where('mf_u_id',Auth::user()->id)->get();
            $countFavs = count($favs);
            $fav = $favs->pluck('mf_pd_id'); 
          }
        $related_cats = DB::table('products')
            ->join('last_categories', 'last_categories.id', '=', 'products.pd_SubCategory_id')->where("pd_name", "LIKE", "%" . Session::get('pd_name') . "%")->get();
        $count_related_cats  =  count($related_cats);
        if (Auth::check()) {
            $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
            $count = count($userMessages);

            return view('front.search',  compact('Productcount', 'pd_name', 'pCats', 'subCats', 'related_cats', 'count_related_cats', 'lastCats', 'products', 'pd_images','fav','count', 'countBuyingRequest'));
        } else {

            return view('front.search',  compact('Productcount', 'pd_name', 'pCats', 'related_cats', 'count_related_cats', 'subCats', 'lastCats', 'products', 'pd_images'));
        }
    }

    public function formsearch()
    {
        if (request()->search != "") {
            Session::put("pd_name", request()->search);
            $pd_name = request()->search;
            $validator = \Validator::make(request()->all(), [
                'search' => ['nullable', 'string', 'max:255'],
            ]);
            if ($validator->fails()) {
                return back()->withInput()->withErrors($validator->errors());
            }

            $Countproducts = DB::table('products')->where("pd_name", "LIKE", "%" . Session::get('pd_name') . "%")->where('pd_approval_status', 1)->get();
            $products = DB::table('products')->where("pd_name", "LIKE", "%" . Session::get('pd_name') . "%")->where('pd_approval_status', 1)->paginate(50);

            $Productcount = count($Countproducts);
            $pCats = \App\productCategory::all();
            $subCats = \App\SubCategory::all();
            $lastCats = \App\lastCategory::all();
            $pd_images = \App\Photo::all();
            $buyingRequests = \App\BuyingRequest::where('br_approval_status', 1)->get();
            $countBuyingRequest = count($buyingRequests);
                 if(Auth::check()){
                    $favs = \App\my_favorite::where('mf_u_id',Auth::user()->id)->get();
                    $countFavs = count($favs);
                    $fav = $favs->pluck('mf_pd_id'); 
                }

            $related_cats = DB::table('products')
                ->join('last_categories', 'last_categories.id', '=', 'products.pd_SubCategory_id')->where("pd_name", "LIKE", "%" . Session::get('pd_name') . "%")->get();
            $count_related_cats  =  count($related_cats);

            if (Auth::check()) {
                $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
                $count = count($userMessages);

                return view('front.search',  compact('Productcount', 'pCats', 'subCats', 'lastCats', 'related_cats', 'count_related_cats', 'products', 'pd_images', 'fav', 'count', 'countBuyingRequest'));
            } else {

                return view('front.search',  compact('Productcount', 'pCats', 'subCats', 'lastCats', 'count_related_cats', 'related_cats', 'products', 'pd_images'));
            }
        } else if (request()->search == null && Session::get('pd_name') != null) {
            $Countproducts = DB::table('products')->where("pd_name", "LIKE", "%" . Session::get('pd_name') . "%")->where('pd_approval_status', 1)->get();
            $products = DB::table('products')->where("pd_name", "LIKE", "%" . Session::get('pd_name') . "%")->where('pd_approval_status', 1)->paginate(50);

            $Productcount = count($Countproducts);
            $pCats = \App\productCategory::all();
            $subCats = \App\SubCategory::all();
            $lastCats = \App\lastCategory::all();
            $pd_images = \App\Photo::all();
            $buyingRequests = \App\BuyingRequest::where('br_approval_status', 1)->get();
            $countBuyingRequest = count($buyingRequests);

            $related_cats = DB::table('products')
                ->join('last_categories', 'last_categories.id', '=', 'products.pd_SubCategory_id')->where("pd_name", "LIKE", "%" . Session::get('pd_name') . "%")->get();
            $count_related_cats  =  count($related_cats);
            if (Auth::check()) {
                $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
                $count = count($userMessages);

                return view('front.search',  compact('Productcount', 'pCats', 'subCats', 'lastCats', 'related_cats', 'count_related_cats', 'products', 'pd_images','fav', 'count', 'countBuyingRequest'));
            } else {

                return view('front.search',  compact('Productcount', 'pCats', 'subCats', 'lastCats', 'related_cats', 'count_related_cats', 'products', 'pd_images'));
            }
        } else {
            return redirect()->to('/');
        }
    }


    //filter by price
    public function filterByPrice()
    {
        //cehck if it empty

        if (request('max_price') != null && request('min_price') != null) {


            $validator = \Validator::make(request()->all(), [
                'min_price' => ['numeric', 'max:255'],
                'max_price' => ['numeric', 'max:255'],
            ]);
            if ($validator->fails()) {
                return back()->withInput()->withErrors($validator->errors());
            }

            Session::put("min_price", request()->min_price);
            Session::put("max_price", request()->max_price);

            $Countproducts = DB::table('products')->where("min_price", Session::get("min_price"))->where("max_price", Session::get("max_price"))->where('pd_approval_status', 1)->get();
            $products = DB::table('products')->where("min_price", Session::get("min_price"))->where("max_price", Session::get("max_price"))->where('pd_approval_status', 1)->paginate(50);


            $Productcount = count($Countproducts);
            $pCats = \App\productCategory::all();
            $subCats = \App\SubCategory::all();
            $lastCats = \App\lastCategory::all();
            $pd_images = \App\Photo::all();
            $buyingRequests = \App\BuyingRequest::where('br_approval_status', 1)->get();
            $countBuyingRequest = count($buyingRequests);
                 if(Auth::check()){
                    $favs = \App\my_favorite::where('mf_u_id',Auth::user()->id)->get();
                    $countFavs = count($favs); 
                    $fav = $favs->pluck('mf_pd_id'); 
                }


            $related_cats = DB::table('products')
                ->join('last_categories', 'last_categories.id', '=', 'products.pd_SubCategory_id')->where("min_price", Session::get("min_price"))->where("max_price", Session::get("max_price"))->get();
            $count_related_cats  =  count($related_cats);


            if (Auth::check()) {
                $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
                $count = count($userMessages);


                return view('front.filter-by-price',  compact('Productcount', 'pCats', 'subCats', 'lastCats', 'count_related_cats', 'related_cats', 'products','fav', 'pd_images', 'count', 'countBuyingRequest'));
            } else {

                return view('front.filter-by-price',  compact('Productcount', 'pCats', 'subCats', 'lastCats', 'count_related_cats', 'related_cats', 'products', 'pd_images'));
            }
        } else if ((Session::get("min_price") != null && request('min_price') == null) && (Session::get("max_price") != null && request('max_price') == null)) {
            $Countproducts = DB::table('products')->where("min_price", Session::get("min_price"))->where("max_price", Session::get("max_price"))->where('pd_approval_status', 1)->get();
            $products = DB::table('products')->where("min_price", Session::get("min_price"))->where("max_price", Session::get("max_price"))->where('pd_approval_status', 1)->paginate(50);

            $Productcount = count($Countproducts);
            $pCats = \App\productCategory::all();
            $subCats = \App\SubCategory::all();
            $lastCats = \App\lastCategory::all();
            $pd_images = \App\Photo::all();
            $buyingRequests = \App\BuyingRequest::where('br_approval_status', 1)->get();
            $countBuyingRequest = count($buyingRequests);
            $related_cats = DB::table('products')
                ->join('last_categories', 'last_categories.id', '=', 'products.pd_SubCategory_id')->where("min_price", Session::get("min_price"))->where("max_price", Session::get("max_price"))->get();
            $count_related_cats  =  count($related_cats);


            if (Auth::check()) {
                $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
                $count = count($userMessages);
                return view('front.filter-by-price',  compact('Productcount', 'pCats', 'subCats', 'lastCats', 'count_related_cats', 'related_cats', 'products', 'pd_images', 'count', 'countBuyingRequest'));
            } else {

                return view('front.filter-by-price',  compact('Productcount', 'pCats', 'subCats', 'lastCats', 'count_related_cats', 'related_cats', 'products', 'pd_images'));
            }
        } else {
            return redirect()->back();
        }
    }
}
