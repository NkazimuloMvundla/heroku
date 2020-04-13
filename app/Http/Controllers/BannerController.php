<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;

class BannerController extends Controller
{
    public function create()
    {

        return view('super.banner-add');
    }

    public function store(Request $request)
    {



        $data = request()->validate([
            'banner_link' => ['required', 'string', 'max:255'],
            'banner_img' => ['required', 'image']

        ]);

        $imgPath = request('banner_img')->store('banners', 'public');

        \App\Banner::create([
            'bn_link' => $data['banner_link'],
            'bn_img' => $imgPath,


        ]);


        Session::flash('banner', "Banner Added Successfully.");
        return redirect()->back();
    }
    public function show()
    {

        $banners = DB::table('banners')->paginate(5);

        return view('super.banner-view', compact('banners'));
    }

    public function deleteSingleBanner()
    {

        if (request()->ajax()) {
            $id = request()->validate([
                'id' => ['numeric'],
            ]);
            $imgPath = \App\Banner::where('bn_id', $id)->get();
            $paths = $imgPath->first()->bn_img; //pd_images\image.png
            $absolute = '\Users\Judge\freeCodeGram\public\storage' . "\\" . $paths;
            if (file_exists($absolute)) {
                $success = unlink($absolute);
                if ($success) {
                    \App\Banner::where('bn_id', $id)->delete();
                }
            }
        }
    }

    public function destroyMultipleBanners()
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
                    $path = \App\Banner::where('bn_id', $id)->get();
                    foreach ($path as $imgPath) {
                        $paths = $imgPath->bn_img; //pd_images\image.png
                        $absolute = '\Users\Judge\freeCodeGram\public\storage' . "\\" . $paths;
                        if (file_exists($absolute)) {
                            $success = unlink($absolute);
                            if ($success) {
                                \App\Banner::where('bn_id', $id)->delete();
                            }
                        }
                    }
                }
            }
        }
    }

    public function edit($banner_id)
    {

        $data = request()->validate([
            'banner_id' => ['numeric'],

        ]);
        $banner = \App\Banner::where('bn_id', $banner_id);
        return view('super.banner-edit', compact('banner'));
    }
    public function update($banner_id)
    {

        //dd(request()->subCategory);

        //This is for inserting into DB


        $data = request()->validate([
            'banner_link' => ['required', 'string', 'max:255'],
            'banner_img' => ['required', 'image']

        ]);



        $imgPath = request('banner_img')->store('banners', 'public');

        \App\Banner::where('bn_id', $banner_id)->update([
            'bn_link' => $data['banner_link'],
            'bn_img' => $imgPath,

        ]);
        Session::flash('message', "Banner Updated Successfully..");
        return redirect()->back();
    }
}
