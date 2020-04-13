<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Response;
use DB;

class SubCategoryController extends Controller
{

    public  function show()
    {

        if (request()->ajax()) {
            $pc_id = request()->id;
            $result = \App\SubCategory::where('pc_id', $pc_id)->get(['id', 'pc_name']);
            return response::json($result);
        }
    }

    public function create()
    {



        $mainCategories = DB::table('product_categories')->paginate(20);



        return view('super.category-add', compact('mainCategories'));
    }

    public function store(Request $request)
    {



        $data = request()->validate([
            'main_category' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'category_image' => ['required', 'image'],

        ]);

        $imgPath = request('category_image')->store('category_images', 'public');


        \App\SubCategory::create([
            'pc_image' => $imgPath,
            'pc_name' => $data['category'],
            'pc_id' => $data['main_category'],



        ]);

        Session::flash('category_add', "Category Added Successfully..");
        return redirect()->back();
    }

    public function viewCat()
    {

        $Categories = DB::table('sub_categories')->paginate(20);
        $mainCategories = DB::table('product_categories')->get();

        return view('super.category-view', compact('Categories', 'mainCategories'));
    }

    public function showCat()
    {

        if (request()->ajax()) {
            $data = request()->validate([
                'id' => ['numeric'],
            ]);
            $result = \App\SubCategory::where('id', $data['id'])->get();
            return response::json($result);
        }
    }
    public function catUpdate(Request $request)
    {

        if (request()->ajax()) {

            $data = request()->validate([
                'id' => ['numeric'],
                'category' => ['required', 'string', 'max:255'],

            ]);

            \App\SubCategory::where('id', $data['id'])->update([
                'pc_name' => $data['category'],



            ]);
        }
    }

    public function deleteSingleCategory()
    {

        if (request()->ajax()) {
            $id = request()->validate([
                'id' => ['numeric'],


            ]);
            \App\SubCategory::where('id', $id)->delete();
        }
    }

    public function destroyMultipleCategories()
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
                    \App\SubCategory::where('id', $id)->delete();
                }
            }
        }
    }
}
