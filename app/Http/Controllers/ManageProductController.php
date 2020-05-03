<?php

namespace App\Http\Controllers;

use App\FeaturedProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Response;
use Session;

class ManageProductController extends Controller
{

    public function create()
    {

        //get all products for the AUth user
        $products = \App\Product::where('pd_u_id', Auth::user()->id)->get();
        $user_details = \App\User::where('id', Auth::user()->id)->get();
        Session::put('account', $user_details->first()->account_type);
        $notifications = \App\Notifications::where('user_id', Auth::user()->id)->get();
        $countNotifications = count($notifications);
        $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
        $count = count($userMessages);
        Session::put('user_messages', $userMessages);
        Session::put('user_messages_count', $count);
        Session::put('notifications', $notifications);
        Session::put('count_notifications', $countNotifications);
        $count = count($products);
        if ($count >= 10) {
            $products = \App\Product::where('pd_u_id', Auth::user()->id)->paginate(50);
            return view('admin.manage-products', compact('products', 'count'));
        } else {
            return view('admin.manage-products', compact('products', 'count'));
        }
    }



    public function destroy()
    {

        if (request()->ajax()) {
            $data = request()->validate([
                'id' => ['numeric'],


            ]);
            $path = \App\Photo::where('pd_photo_id', $data['id'])->get();
            foreach ($path as $imgPath) {
                $paths = $imgPath->pd_filename; //pd_images\image.png
                $absolute = '\Users\Judge\freeCodeGram\public\storage' . "\\" . $paths;
                if (file_exists($absolute)) {
                    $success = unlink($absolute);

                    if ($success) {
                        \App\Photo::where('pd_photo_id', $data['id'])->delete();
                        \App\Product::where('pd_id', $data['id'])->delete();
                    }
                }
            }
        }
    }

    public function destroyMultipleProduct()
    {

        if (request()->ajax()) {

            $ids = request()->validate([
                'checked' => ['required', 'array'],
                'checked.*' => ['required'],

            ]);

            if (!empty($ids) && is_array($ids)) {
                foreach ($ids as $id) {
                    $path = \App\Photo::where('pd_photo_id', $id)->get();
                    foreach ($path as $imgPath) {
                        $paths = $imgPath->pd_filename; //pd_images\image.png
                        $absolute = '\Users\Judge\freeCodeGram\public\storage' . "\\" . $paths;
                        if (file_exists($absolute)) {
                            $success = unlink($absolute);

                            if ($success) {
                                \App\Photo::where('pd_photo_id', $id)->delete();
                                \App\Product::where('pd_id', $id)->delete();
                            }
                        }
                    }
                }
            }
        }
    }
    /*Transactions for super user */
    //-------------------------------------------------//
    public function view()
    {

        $products = DB::table('products')->paginate(100);
        $sub_categories = DB::table('last_categories')->get();
        $users = DB::table('users')->get();
        $count = count($products);
        return view('super.manage-products', compact('products', 'users', 'count', 'sub_categories'));
    }

    public function takeaction(Request $request)
    {

        if (request()->ajax()) {

            $data = request()->validate([
                'id' => ['numeric'],
                'pd_id' => ['numeric'],

            ]);
            $product = \App\Product::where('pd_id', $data['pd_id'])->get();
            if ($data['id'] == 1) {

                \App\Notifications::create([
                    'message' => " Your product " . $product->first()->pd_name . " has been approved ",
                    'user_id' => $product->first()->pd_u_id,
                    'product_id' => $product->first()->pd_id,
                ]);
                \App\Product::where('pd_id', $data['pd_id'])->update(['pd_approval_status' => 1]);
                $res = \App\Product::where('pd_id', $data['pd_id'])->get('pd_approval_status');
                return response($res);
            } else {

                \App\Notifications::create([
                    'message' => " Your product " . $product->first()->pd_name . " has been suspended ",
                    'user_id' => $product->first()->pd_u_id,
                    'product_id' => $product->first()->pd_id,
                ]);
                \App\Product::where('pd_id', $data['pd_id'])->update(['pd_approval_status' => 2]);
                $res = \App\Product::where('pd_id', $data['pd_id'])->get('pd_approval_status');
                return response($res);
            }
        }
    }


    public function feature_a_product()
    {

        $products = DB::table('products')->paginate(100);
        $sub_categories = DB::table('last_categories')->get();
        $users = DB::table('users')->get();
        $count = count($products);
        return view('super.feature_a_product', compact('products', 'users', 'count', 'sub_categories'));
    }

    public function featured_product(Request $request)
    {

        if (request()->ajax()) {

            $data = request()->validate([
                'id' => ['numeric'],
                'pd_id' => ['numeric'],

            ]);

            $products = \App\Product::where('pd_id', $data['pd_id']);
            $images = \App\Photo::where('pd_photo_id', $data['pd_id']);

            //feature a product if it one
            if ($data['id'] == 1) {
                \App\Product::where('pd_id', $data['pd_id'])->update(['pd_featured_status' => 1]);
                \App\FeaturedProduct::create([
                    'u_id' => $products->first()->pd_u_id,
                    'pd_id' => $products->first()->pd_id,
                    'pd_image' => $images->first()->pd_filename,
                ]);
                //notify user that his product has been featured
                \App\Notifications::create([
                    'message' => " Your product " . $products->first()->pd_name . " has been Featured in Home Page ",
                    'user_id' => $products->first()->pd_u_id,
                    'product_id' => $products->first()->pd_id,
                ]);
                //notify admin
                \App\AdminNotifications::create([
                    'message' => $products->first()->pd_name . " has been Featured in Home Page ",
                    'user_id' => $products->first()->pd_u_id,
                    'product_id' => $products->first()->pd_id,
                ]);
                $res = \App\Product::where('pd_id', $data['pd_id'])->get('pd_featured_status');
                return response($res);
            } else if ($data['id'] == 2) {
                \App\Product::where('pd_id', $data['pd_id'])->update(['pd_featured_status' => 2]);
                $res = \App\Product::where('pd_id', $data['pd_id'])->get('pd_featured_status');
                return response($res);
            }
        }
    }




    public function deleteSingleProduct()
    {

        if (request()->ajax()) {
            $data = request()->validate([
                'id' => ['numeric'],
            ]);
            $path = \App\Photo::where('pd_photo_id', $data['id'])->get();
            foreach ($path as $imgPath) {
                $paths = $imgPath->pd_filename; //pd_images\image.png
                $absolute = '\Users\Judge\freeCodeGram\public\storage' . "\\" . $paths;
                if (file_exists($absolute)) {
                    $success = unlink($absolute);
                }

                \App\Photo::where('pd_photo_id', $data['id'])->delete();
                \App\Product::where('pd_id', $data['id'])->delete();
            }
        }
    }

    public function destroyMultipleproducts()
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
                    $path = \App\Photo::where('pd_photo_id', $id)->get();
                    foreach ($path as $imgPath) {
                        $paths = $imgPath->pd_filename; //pd_images\image.png
                        $absolute = '\Users\Judge\freeCodeGram\public\storage' . "\\" . $paths;
                        if (file_exists($absolute)) {
                            $success = unlink($absolute);
                        }
                        \App\Photo::where('pd_photo_id', $id)->delete();
                        \App\Product::where('pd_id', $id)->delete();
                    }
                }
            }
        }
    }


    public function showProduct()
    {

        if (request()->ajax()) {
            $data = request()->validate([
                'id' => ['numeric'],
            ]);
            $result = DB::table('products')
                ->join('photos', 'photos.pd_photo_id', '=', 'products.pd_id')->where('photos.pd_photo_id', $data['id'])->get();

            return response::json($result);
        }
    }
}
