<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Response;
use DB;
use Intervention\Image\Facades\Image;

class SubCategoryController extends Controller
{

    public  function show()
    {

        if (request()->ajax()) {
            $data = request()->validate([
                'id' => ['numeric'],
            ]);
            $result = \App\SubCategory::where('pc_id', $data['id'])->get(['id', 'pc_name']);
            return response::json($result);
        }
    }

    public function create()
    {
        $mainCategories = DB::table('product_categories')->get();
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
        $image = Image::make(public_path('storage/' . $imgPath . ''))->fit(80, 80);
        $image->save();

        \App\SubCategory::create([
            'pc_image' => $imgPath,
            'pc_name' => trim($data['category']),
            'pc_id' => trim($data['main_category']),



        ]);

        Session::flash('category_add', "Category Added Successfully..");
        return redirect()->back();
    }

    public function viewCat()
    {

        $Categories = DB::table('sub_categories')->get();

        $mainCategories = DB::table('product_categories')->get();

        return view('super.category-view', compact('Categories', 'mainCategories'));
    }

    public function editView($category_id)
    {

        $category = DB::table('sub_categories')->where("id", $category_id)->get();

        $mainCategories = DB::table('product_categories')->get();

        return view('super.category-edit', compact('category', 'mainCategories'));
    }

    public function categorySave($category_id)
    {



        //if you want to change a main menu for a sub category,like change agriculture for fruits and veg
        if (!empty(request()->main_category)) {
            $data = request()->validate([
                'main_category' => ['required', 'numeric', 'max:255'],
                'category' => ['required', 'string', 'max:255'],
                'category_image' => ['nullable', 'image'],

            ]);

            \App\SubCategory::where('id', $category_id)->update([
                'pc_name' => trim($data['category']),
                'pc_id' => trim($data['main_category']),
            ]);
        } else {
            $data = request()->validate([
                'category' => ['required', 'string', 'max:255'],
                'category_image' => ['nullable', 'image'],

            ]);

            \App\SubCategory::where('id', $category_id)->update([
                'pc_name' => trim($data['category']),
            ]);
        }
        if (!empty(request()->category_image)) {

            $category = DB::table('sub_categories')->where("id", $category_id);

            $imgPath = request('category_image')->store('category_images', 'public');
            $image = Image::make(public_path('storage/' . $imgPath . ''))->fit(120, 120);
            $image->save();

            if ($category->first()->pc_image == "") {
                \App\SubCategory::create([
                    'pc_image' => $imgPath,
                ]);
            } else {

                $absolute = '\Users\Judge\freeCodeGram\public\storage' . "\\" . $category->first()->pc_image;
                if (file_exists($absolute)) {
                    $success = unlink($absolute);
                    if ($success) {
                        $data = request()->validate([
                            'pc_image' => ['nullable', 'image', 'mimes:jpeg,png', 'max:2048']
                        ]);
                        \App\SubCategory::where('id', $category_id)->update([
                            'pc_image' => $imgPath,
                        ]);
                    }
                }
            }
        }



        Session::flash('category_add', "Category updated Successfully..");
        return redirect()->back();
    }


    public function showCat()
    {

        if (request()->ajax()) {
            $data = request()->validate([
                'id' => ['numeric'],
            ]);
            $result = \App\SubCategory::where('id', trim($data['id']))->get();
            return response::json($result);
        }
    }
    public function catUpdate(Request $request)
    {

        if (request()->ajax()) {

            /*   $data = request()->validate([
                'id' => ['numeric'],
                'category' => ['required', 'string', 'max:255'],

            ]); */
            /*
            \App\SubCategory::where('id', trim($data['id']))->update([
                'pc_name' => trim($data['category']),

            ]);*/

            return request();
        }
    }

    public function deleteSingleCategory()
    {

        if (request()->ajax()) {
            $id = request()->validate([
                'id' => ['numeric'],


            ]);
            \App\SubCategory::where('id', trim($id))->delete();
        }
    }

    public function destroyMultipleCategories()
    {

        if (request()->ajax()) {
            $data = request()->validate([
                'checked' => ['array'],
                'checked.*' => ['numeric'],
            ]);

            foreach ($data['checked'] as $id) {
                \App\SubCategory::where('id', trim($id))->delete();
            }
        }
    }
}
