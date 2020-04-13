<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Response;

class SettingController extends Controller
{
    public function create(){

        return view('super.add-setting');
      }

      public function store(Request $request){



          $data = request()->validate([
              'setting_field' => ['required', 'string', 'max:255'],
              'setting_name' => ['required', 'string', 'max:255'],
           ]);

           if(!empty(request('setting_pic'))){
           $datas = request()->validate([
            'setting_pic' => ['image'],
            ]);
           }

           if(!empty(request('setting_pic'))){
            $imgPath = request('setting_pic')->store('img', 'public');
           }else{
            $imgPath = '';
           }


          \App\Setting::create([
            'st_field' => $data['setting_field'],
            'st_value' => $data['setting_name'],
            'st_pic' =>  $imgPath,

              ]);



              Session::flash('setting_add', "Setting Added Successfully.");
              return redirect()->back();



  }
  public function viewSetting(){

    $settings = DB::table('settings')->paginate(10);

    return view('super.settings-view', compact('settings'));
  }

  public function destroyMultiplesettings(){

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
            \App\Setting::where('id', $id)->delete();
        }
      }


    }


  }
  public function showField(){

    if(request()->ajax()){
      $data = request()->validate([
        'id' => ['numeric'],
     ]);
      $result = \App\Setting::where('id' , $data['id'])->get();
         return response::json($result);
    }


  }

  public function showValue(){

    if(request()->ajax()){
      $data = request()->validate([
        'id' => ['numeric'],
     ]);
      $result = \App\Setting::where('id' , $data['id'])->get();
         return response::json($result);
    }


  }


  public function fieldUpdate(Request $request){

    if(request()->ajax()){

      $data = request()->validate([
          'id' => ['numeric'],
          'st_field' => ['required', 'string', 'max:255'],

       ]);

      \App\Setting::where('id', $data['id'])->update([
        'st_field' => $data['st_field'],

          ]);


      }

}

public function valueUpdate(Request $request){

    if(request()->ajax()){

      $data = request()->validate([
          'id' => ['numeric'],
          'st_value' => ['required', 'string', 'max:255'],

       ]);

      \App\Setting::where('id', $data['id'])->update([
        'st_value' => $data['st_value'],

          ]);


      }

}


public function deleteSingleValue(){

    if(request()->ajax()){
        $id = request()->validate([
            'id' => ['numeric'],


         ]);
      \App\Setting::where('id', $id)->delete();
    }


  }

}
