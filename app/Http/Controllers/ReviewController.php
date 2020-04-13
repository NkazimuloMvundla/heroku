<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Response;

class ReviewController extends Controller
{
    public function create()
    {

        $reviews = DB::table('reviews')->paginate(50);
        $allusers = \App\User::all();
        $count = count($allusers);

        return view('super.manage-reviews', compact('reviews', 'count'));
    }
    public function store(Request $request)
    {


        if (request()->ajax()) {

            $data = request()->validate([

                'name' => ['required', 'string', 'max:255'],
                'rating' => ['required', 'numeric'],
                'comment' => ['required', 'string', 'max:255'],
                'product_id' => ['numeric'],

            ]);


            \App\Review::create([
                'pd_id' => $data['product_id'],
                'rating' => $data['rating'],
                'review' => $data['comment'],
                'rated_by' => $data['name'],


            ]);
        }
    }
    public function showReview()
    {

        if (request()->ajax()) {

            $data = request()->validate([
                'id' => ['numeric'],

            ]);
            //$result = \App\Product::where('pd_id', $data['id'])->get();
            $result = \App\Product::where('pd_id', $data['id'])->get(['pd_id', 'pd_name']);
            // $data = \App\Product::pluck('pd_name')->where('pd_id', $data['id'])->get();
            //$data = DB::select('select pd_id, pd_name from products where pd_id = ?', [$data['id']]);
            return  response($result, 200,);
        }
    }
    public function showReviews($pd_id)
    {
        $decoded_pd_id = base64_decode($pd_id);
        $result = \App\Review::where(['pd_id' => $decoded_pd_id, 'status' => 1])->get();
        $pCats = \App\productCategory::all();
        $subCats = \App\SubCategory::all();
        $lastCats = \App\lastCategory::all();
        $pd_images = \App\Photo::where('pd_photo_id', $decoded_pd_id)->get();
        $product = \App\Product::where('pd_id', $decoded_pd_id)->get();
        $buyingRequests = \App\BuyingRequest::all();
        $countBuyingRequest = count($buyingRequests);
        if (Auth::check()) {
            $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
            $count = count($userMessages);

            return view('front.product-reviews', compact('pCats', 'subCats', 'lastCats', 'pd_images', 'result', 'product', 'count', 'countBuyingRequest'));
        } else {

            return view('front.product-reviews', compact('pCats', 'subCats', 'lastCats', 'pd_images', 'result', 'product'));
        }
    }

    public function approve(Request $request)
    {

        if (request()->ajax()) {

            $data = request()->validate([
                'id' => ['numeric'],

            ]);
            \App\Review::where('id', $data['id'])->update(['status' => 1]);
        }
    }

    public function suspend(Request $request)
    {

        if (request()->ajax()) {

            $data = request()->validate([
                'id' => ['numeric'],

            ]);
            \App\Review::where('id', $data['id'])->update(['status' => 2]);
        }
    }


    public function destroyMultiplereviews()
    {

        if (request()->ajax()) {
            /*
        $data = request()->validate([
            'checked' => ['numeric'],


         ]);

         */
            $ids = request()->checked;
            //  $count = count($ids);
            if (!empty($ids) && is_array($ids)) {
                foreach ($ids as $id) {
                    \App\Review::where('id', $id)->delete();
                }
            }
        }
    }
}
