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
        request()->validate([

            'query' => ['nullable', 'string', 'max:255'],

        ]);
        $count = DB::table('products')->where("pd_name", "LIKE", "%$term%")->orderBy('pd_name')->get();
        $res = count($count);
        if (!empty($term) && $res > 0) {
            $data = DB::table('products')->where("pd_name", "LIKE", "%$term%")->where('pd_approval_status', 1)->get();

            $searched_products = [];
            foreach ($data as $row1) {
                array_push($searched_products, $row1->pd_name);
                $uniqueProducts = array_unique($searched_products);
            }

            $output = '<ul class="dropdown-menu" id="liveSearch" style="display:block;position:obsolute">';
            foreach ($uniqueProducts as $row) {

                $output .= '<li id="pd_search"><a href="/search/' . htmlspecialchars($row) . '">' . htmlspecialchars($row) . '</a></li>';
            }
            $output .= '</ul>';

            return response($output);
        }


        /*	foreach($data as $row)
		{
		   $results[] = ['value'=> $row->pd_nameli];
		}

		return response()->json($results);

		*/
    }


    public function search($pd_name)
    {
        if (request()->pd_name != "") {
            Session::put("pd_name", $pd_name);
            request()->validate([

                'pd_name' => ['nullable', 'string', 'max:255'],

            ]);
        }
        $Countproducts = DB::table('products')->where("pd_name", "LIKE", "%$pd_name%")->where('pd_approval_status', 1)->get();
        $products = DB::table('products')->where("pd_name", "LIKE", "%$pd_name%")->where('pd_approval_status', 1)->paginate(50);

        $Productcount = count($Countproducts);
        $pCats = \App\productCategory::all();
        $subCats = \App\SubCategory::all();
        $lastCats = \App\lastCategory::all();
        $pd_images = \App\Photo::all();
        $buyingRequests = \App\BuyingRequest::all();
        $countBuyingRequest = count($buyingRequests);
        $related_cats = DB::table('products')
            ->join('last_categories', 'last_categories.id', '=', 'products.pd_SubCategory_id')->where("pd_name", "LIKE", "%" . Session::get('pd_name') . "%")->get();
        $count_related_cats  =  count($related_cats);
        if (Auth::check()) {
            $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
            $count = count($userMessages);

            return view('front.search',  compact('Productcount', 'pd_name', 'pCats', 'subCats', 'related_cats', 'count_related_cats', 'lastCats', 'products', 'pd_images', 'count', 'countBuyingRequest'));
        } else {

            return view('front.search',  compact('Productcount', 'pd_name', 'pCats', 'related_cats', 'count_related_cats', 'subCats', 'lastCats', 'products', 'pd_images'));
        }
    }

    public function formsearch()
    {
        if (request()->search != "") {
            Session::put("pd_name", request()->search);
            $pd_name = request()->search;
            request()->validate([

                'pd_name' => ['nullable', 'string', 'max:255'],

            ]);

            $Countproducts = DB::table('products')->where("pd_name", "LIKE", "%" . Session::get('pd_name') . "%")->where('pd_approval_status', 1)->get();
            $products = DB::table('products')->where("pd_name", "LIKE", "%" . Session::get('pd_name') . "%")->where('pd_approval_status', 1)->paginate(50);
            // dd($Countproducts);

            $Productcount = count($Countproducts);
            $pCats = \App\productCategory::all();
            $subCats = \App\SubCategory::all();
            $lastCats = \App\lastCategory::all();
            $pd_images = \App\Photo::all();
            $buyingRequests = \App\BuyingRequest::all();
            $countBuyingRequest = count($buyingRequests);

            $related_cats = DB::table('products')
                ->join('last_categories', 'last_categories.id', '=', 'products.pd_SubCategory_id')->where("pd_name", "LIKE", "%" . Session::get('pd_name') . "%")->get();
            $count_related_cats  =  count($related_cats);
            //  dd($count_related_cats);

            if (Auth::check()) {
                $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
                $count = count($userMessages);

                return view('front.search',  compact('Productcount', 'pCats', 'subCats', 'lastCats', 'related_cats', 'count_related_cats', 'products', 'pd_images', 'count', 'countBuyingRequest'));
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
            $buyingRequests = \App\BuyingRequest::all();
            $countBuyingRequest = count($buyingRequests);

            $related_cats = DB::table('products')
                ->join('last_categories', 'last_categories.id', '=', 'products.pd_SubCategory_id')->where("pd_name", "LIKE", "%" . Session::get('pd_name') . "%")->get();
            $count_related_cats  =  count($related_cats);
            if (Auth::check()) {
                $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
                $count = count($userMessages);

                return view('front.search',  compact('Productcount', 'pCats', 'subCats', 'lastCats', 'related_cats', 'count_related_cats', 'products', 'pd_images', 'count', 'countBuyingRequest'));
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
            request()->validate([
                'min_price' => ['numeric'],
                'max_price' => ['numeric'],
            ]);

            Session::put("min_price", request()->min_price);
            Session::put("max_price", request()->max_price);

            $Countproducts = DB::table('products')->where("min_price", Session::get("min_price"))->where("max_price", Session::get("max_price"))->where('pd_approval_status', 1)->get();
            $products = DB::table('products')->where("min_price", Session::get("min_price"))->where("max_price", Session::get("max_price"))->where('pd_approval_status', 1)->paginate(50);


            $Productcount = count($Countproducts);
            $pCats = \App\productCategory::all();
            $subCats = \App\SubCategory::all();
            $lastCats = \App\lastCategory::all();
            $pd_images = \App\Photo::all();
            $buyingRequests = \App\BuyingRequest::all();
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
        } else if ((Session::get("min_price") != null && request('min_price') == null) && (Session::get("max_price") != null && request('max_price') == null)) {
            $Countproducts = DB::table('products')->where("min_price", Session::get("min_price"))->where("max_price", Session::get("max_price"))->where('pd_approval_status', 1)->get();
            $products = DB::table('products')->where("min_price", Session::get("min_price"))->where("max_price", Session::get("max_price"))->where('pd_approval_status', 1)->paginate(50);

            $Productcount = count($Countproducts);
            $pCats = \App\productCategory::all();
            $subCats = \App\SubCategory::all();
            $lastCats = \App\lastCategory::all();
            $pd_images = \App\Photo::all();
            $buyingRequests = \App\BuyingRequest::all();
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
