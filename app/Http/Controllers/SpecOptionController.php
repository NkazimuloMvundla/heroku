<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Response;

class SpecOptionController extends Controller
{
    public function addSpecOption()
    {

        $specifications = DB::table('specifications')->get();
        return view('super.add-spec-option', compact('specifications'));
    }

    public function store(Request $request)
    {

        if (request()->ajax()) {

            $data = request()->validate([
                'spec_id' => ['numeric'],
                'spec_option' => ['required', 'string', 'max:255'],

            ]);

            \App\SpecOption::create([
                'spec_id' => trim($data['spec_id']),
                'spec_option_name' => trim($data['spec_option']),

            ]);
        }
    }
    public function viewSpecOption()
    {

        $specifications = DB::table('specifications')->get();
        $spec_options = DB::table('spec_options')->paginate(10);
        $sub_categories = DB::table('last_categories')->get();

        return view('super.spec-option-view', compact('specifications', 'spec_options', 'sub_categories'));
    }
    public function deleteSingleSpecOption()
    {

        if (request()->ajax()) {
            $id = request()->validate([
                'id' => ['numeric'],


            ]);
            \App\SpecOption::where('id', trim($id))->delete();
        }
    }
    public function destroyMultipleSpecOption()
    {

        if (request()->ajax()) {
            $data = request()->validate([
                'checked' => ['array'],
                'checked.*' => ['numeric'],
            ]);

            foreach ($data['checked'] as $id) {
                $id = trim($id);
                \App\SpecOption::where('id', $id)->delete();
            }
        }
    }
    public function showSpecOption()
    {

        if (request()->ajax()) {
            $data = request()->validate([
                'id' => ['numeric'],
            ]);
            $result = \App\SpecOption::where('id', trim($data['id']))->get();
            return response::json($result);
        }
    }
    public function specOptionUpdate(Request $request)
    {

        if (request()->ajax()) {

            $data = request()->validate([
                'id' => ['numeric'],
                'spec_option_name' => ['required', 'string', 'max:255'],

            ]);

            \App\SpecOption::where('id', trim($data['id']))->update([
                'spec_option_name' => trim($data['spec_option_name']),

            ]);
        }
    }
}
