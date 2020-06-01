<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Response;

class SpecificationController extends Controller
{
    //Super user
    public function create()
    {
        $parent_category = DB::table('product_categories')->get();
        return view('super.add-specification', compact('parent_category'));
    }

    public function store(Request $request)
    {

        if (request()->ajax()) {

            $data = request()->validate([
                'mainCategory' => ['required', 'numeric'],
                'subcategory' => ['required', 'numeric'],
                'specification' => ['required', 'string', 'max:255'],

            ]);

            \App\Specification::create([
                'spec_subCatid' => trim($data['subcategory']),
                'spec_name' => trim($data['specification']),
                'spec_parentCat_id' => trim($data['mainCategory']),


            ]);
        }
    }

    public function viewSpec()
    {

        $specifications = DB::table('specifications')->paginate(10);
        $sub_categories = DB::table('last_categories')->get();

        return view('super.spec-view', compact('specifications', 'sub_categories'));
    }
    public function specUpdate(Request $request)
    {

        if (request()->ajax()) {

            $data = request()->validate([
                'id' => ['numeric'],
                'spec_name' => ['required', 'string', 'max:255'],

            ]);

            \App\Specification::where('spec_id', trim($data['id']))->update([
                'spec_name' => trim($data['spec_name']),

            ]);
        }
    }
    public function deleteSingleSpec()
    {

        if (request()->ajax()) {
            $id = request()->validate([
                'id' => ['numeric'],
            ]);
            \App\Specification::where('spec_id', trim($id))->delete();
        }
    }

    public function destroyMultipleSpecs()
    {

        if (request()->ajax()) {
            $data = request()->validate([
                'checked' => ['array'],
                'checked.*' => ['numeric'],
            ]);

            foreach ($data['checked'] as $id) {
                $id = trim($id);
                \App\Specification::where('spec_id', $id)->delete();
            }
        }
    }

    public function showSpec()
    {

        if (request()->ajax()) {
            $data = request()->validate([
                'id' => ['numeric'],
            ]);
            $result = \App\Specification::where('spec_id', trim($data['id']))->get();
            return response::json($result);
        }
    }


    public function showSpecList()
    {

        if (request()->ajax()) {
            $data = request()->validate([
                'subcateid' => ['numeric'],
            ]);
            $result = \App\Specification::where('spec_subCatid', trim($data['subcateid']))->get(['spec_id', 'spec_name']);
            return response::json($result);
        }
    }
}
