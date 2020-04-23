<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use Auth;

class MyFavoriteController extends Controller
{
    public function create()
    {
        $favorites = \App\my_favorite::where('mf_u_id', Auth()->user()->id)->get();


        $products = \App\Product::all();
        $pd_images = \App\Photo::all();

        return view('admin.my_favorites', compact('favorites', 'products', 'pd_images'));
    }

    public function addFavorite(Request $request)
    {

        if (Auth::check()) {
            if (request()->ajax()) {

                $data = request()->validate([
                    'id' => ['numeric'],
                ]);
                $count = \App\my_favorite::where('mf_pd_id', $data['id'])->get();
                if (count($count) > 0) {
                    echo htmlspecialchars('You have already liked this product');
                } else {
                    \App\my_favorite::create([
                        'mf_u_id' => Auth()->user()->id,
                        'mf_pd_id' => $data['id'],
                    ]);
                    echo htmlspecialchars('Product was added to liked products');
                }
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function removeFav()
    {
        if (request()->ajax()) {
            $data = request()->validate([
                'id' => ['numeric'],
            ]);
            \App\my_favorite::where('mf_pd_id', $data['id'])->delete();
        }
    }
}
