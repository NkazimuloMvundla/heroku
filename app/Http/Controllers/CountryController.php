<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Response;

class CountryController extends Controller
{
    public function create()
    {

        return view('super.add-country');
    }


    public function store(Request $request)
    {

        if (request()->ajax()) {

            $data = request()->validate([
                'country_name' => ['required', 'string', 'max:255'],
                'country_flag' => ['image'],


            ]);

            \App\Country::create([
                'cn_name' => trim($data['country_name']),

            ]);
        }
    }

    public function viewCountry()
    {

        $countries = DB::table('countries')->get();

        $cities = DB::table('cities')->get();

        return view('super.country-view', compact('countries', 'cities'));
    }

    public function showCountry()
    {

        if (request()->ajax()) {
            $data = request()->validate([
                'id' => ['numeric'],
            ]);
            $result = \App\Country::where('id', trim($data['id']))->get();
            return response::json($result);
        }
    }

    public function showCity()
    {

        if (request()->ajax()) {
            $data = request()->validate([
                'id' => ['numeric'],
            ]);
            $result = \App\City::where('id', trim($data['id']))->get();
            return response::json($result);
        }
    }
    public function countryUpdate(Request $request)
    {

        if (request()->ajax()) {

            $data = request()->validate([
                'id' => ['numeric'],
                'cn_name' => ['required', 'string', 'max:255'],

            ]);

            \App\Country::where('id', trim($data['id']))->update([
                'cn_name' => trim($data['cn_name']),



            ]);
        }
    }

    public function cityUpdate(Request $request)
    {

        if (request()->ajax()) {

            $data = request()->validate([
                'id' => ['numeric'],
                'city' => ['required', 'string', 'max:255'],

            ]);

            \App\City::where('id', trim($data['id']))->update([
                'ct_name' => trim($data['city']),



            ]);
        }
    }

    public function deleteSingleCity()
    {

        if (request()->ajax()) {
            $id = request()->validate([
                'id' => ['numeric'],


            ]);
            \App\City::where('id', trim($id))->delete();
        }
    }

    public function destroyMultipleCountries()
    {

        if (request()->ajax()) {
            $data = request()->validate([
                'checked' => ['array'],
                'checked.*' => ['numeric'],
            ]);



            foreach ($data['checked'] as $id) {
                \App\Country::where('id', trim($id))->delete();
                \App\City::where('ct_cn_id', trim($id))->delete();
            }
        }
    }


    public function viewCity()
    {

        $countries = DB::table('countries')->get();
        $cities = DB::table('cities')->get();

        return view('super.city-view', compact('countries', 'cities'));
    }

    public function addCity()
    {

        $countries = DB::table('countries')->paginate(20);


        return view('super.add-city', compact('countries'));
    }

    public function storeCity(Request $request)
    {

        if (request()->ajax()) {

            $data = request()->validate([
                'city_name' => ['required', 'string', 'max:255'],
                'country_id' => ['required', 'numeric', 'max:255'],


            ]);

            \App\City::create([
                'ct_name' => trim($data['city_name']),
                'ct_cn_id' => trim($data['country_id']),
                // 'cn_flag' => $data['country_flag'],



            ]);
        }
    }
}
