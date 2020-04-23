<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Response;
use Illuminate\Support\Facades\DB;

class LastCategoryController extends Controller
{
    public  function show()
    {

        if (request()->ajax()) {
            $id = request()->id;
            $result = \App\lastCategory::where('pc_id', $id)->get(['id', 'pc_name']);

            $count = count($result);

            return response::json($result);
        }
    }


    public function create()
    {
        $parent_category = \App\productCategory::all();

        return view('super.subcategory-add', compact('parent_category'));
    }
    public function store(Request $request)
    {

        if (request()->ajax()) {

            $data = request()->validate([
                'category' => ['required', 'numeric'],
                'subcategory' => ['required', 'string', 'max:255'],

            ]);

            \App\lastCategory::create([
                'pc_name' => $data['subcategory'],
                'pc_id' => $data['category'],

            ]);
        }
    }
    public function viewSub()
    {
        $SubCategories = DB::table('last_categories')->paginate(20);
        $mainCategories = DB::table('product_categories')->get();
        $Categories = DB::table('sub_categories')->get();

        return view('super.subcategory-view', compact('SubCategories', 'mainCategories', 'Categories'));
    }


    public function showSub()
    {
        if (request()->ajax()) {
            $data = request()->validate([
                'id' => ['numeric'],
            ]);
            $result = \App\lastCategory::where('id', $data['id'])->get();
            return response::json($result);
        }
    }
    public function subUpdate(Request $request)
    {

        if (request()->ajax()) {

            $data = request()->validate([
                'id' => ['numeric'],
                'category' => ['required', 'string', 'max:255'],
            ]);
            \App\lastCategory::where('id', $data['id'])->update([
                'pc_name' => $data['category'],
            ]);
        }
    }

    public function deleteSingleSubCategory()
    {

        if (request()->ajax()) {
            $id = request()->validate([
                'id' => ['numeric'],
            ]);
            \App\lastCategory::where('id', $id)->delete();
        }
    }

    public function destroyMultipleSubCategories()
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
                    \App\lastCategory::where('id', $id)->delete();
                }
            }
        }
    }
}
