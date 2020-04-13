<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FeaturedProductController extends Controller
{
    public function store(Request $request){

        if(request()->ajax()){

          $data = request()->validate([
              'pd_id' => ['required', 'numeric'],

           ]);




          }






  }
}
