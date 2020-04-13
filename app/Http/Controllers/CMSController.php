<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
class CMSController extends Controller
{
    public function create(){

        return view('super.cms-add');
    }

    public function show(){
        $cms_s = \App\CMS::all();

        return view('super.cms-view', compact('cms_s'));
    }

    public function store(Request $request){

        if(request()->ajax()){

          $data = request()->validate([
              'cms_title' => ['required', 'string', 'max:255'],
              'cms_page' => ['required', 'string', 'max:255'],
              'cms_content' => ['required','string', 'max:255'],
           ]);

          \App\CMS::create([
            'cms_title' => $data['cms_title'],
            'cms_page' => $data['cms_page'],
            'cms_content' => $data['cms_content'],

              ]);


          }






  }

  public function update(Request $request){

    if(request()->ajax()){

      $data = request()->validate([
          'id' => ['numeric'],
          'cms_title' => ['required', 'string', 'max:255'],
          'cms_page' => ['required', 'string', 'max:255'],
          'cms_content' => ['required','string', 'max:255'],
       ]);

      \App\CMS::where('id', $data['id'])->update([
        'cms_title' => $data['cms_title'],
        'cms_page' => $data['cms_page'],
        'cms_content' => $data['cms_content'],

          ]);


      }






}

public function destroyMultipleCms(){

    if(request()->ajax()){
        /*
        $data = request()->validate([
            'checked' => ['numeric'],


         ]);

         */
      $ids = request()->checked;
    //  $count = count($ids);
      if(!empty($ids) && is_array($ids)){
        foreach($ids as $id){
            \App\CMS::where('id', $id)->delete();
        }
      }


    }


  }

  public function getCms(){

    if(request()->ajax()){
      $data = request()->validate([
        'id' => ['numeric'],
     ]);
      $result = \App\CMS::where('id' , $data['id'])->get();
         return response::json($result);
    }


  }

}