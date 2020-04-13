<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;

class ExportCapabilityController extends Controller
{
       
        
        public function save(Request $request){

        if(request()->ajax() ){   

        $exist = \App\ExportCapability::where('user_id', Auth::user()->id)->get();

    

        //if there's already data in db
       if(count($exist) > 0){

        //check to see if chekha is set

        if(!empty(request()->chekha)){
          //then update all three
           $data = request()->validate([
              'export_percentage' => [ 'numeric'],
              //'market' => ['required' ],
              'chekha' => ['string', 'max:255'],
              'export_year' => [ 'numeric'],


              ]);

            //  $market = implode(',', $data['market']);
        
            \App\ExportCapability::where('user_id', Auth::user()->id)->update([
              'user_id' => Auth::user()->id,
              'export_percentage' => $data['export_percentage'],
              'main_markets' => $data['chekha'],
              'export_started' => $data['export_year'],



              ]);
    


        }else{
          //update the two only
           $data = request()->validate([
              'export_percentage' => [ 'numeric'],
              'export_year' => [ 'numeric'],


              ]);

            //  $market = implode(',', $data['market']);
        
            \App\ExportCapability::where('user_id', Auth::user()->id)->update([
              'user_id' => Auth::user()->id,
              'export_percentage' => $data['export_percentage'],
              'export_started' => $data['export_year'],



              ]);
        
            }
          

        }else{

                //then update all three
           $data = request()->validate([
              'export_percentage' => [ 'numeric'],
              //'market' => ['required' ],
              'chekha' => ['string', 'max:255'],
              'export_year' => [ 'numeric'],


              ]);

              //$market = implode(',', $data['market']);
        
             \App\ExportCapability::create([
             'user_id' => Auth::user()->id,
              'export_percentage' => $data['export_percentage'],
              'main_markets' => $data['chekha'],
              'export_started' => $data['export_year'],



              ]);


        }

      
      }
         

    }
/*
==========This is only PHP code incase there's no javascript
    public function save(Request $request){

          

        $exist = \App\ExportCapability::where('user_id', Auth::user()->id)->get();
        if(count($exist) > 0){
              $data = request()->validate([
              'export_percentage' => ['required', 'numeric'],
              'market' => ['required' ],
              'market.*' => ['required', 'string', 'max:255'],
              'export_year' => ['required', 'numeric'],


           ]);

              $market = implode(',', $data['market']);
        
            \App\ExportCapability::where('user_id', Auth::user()->id)->update([
              'user_id' => Auth::user()->id,
              'export_percentage' => $data['export_percentage'],
              'main_markets' => $market,
              'export_started' => $data['export_year'],



              ]);
    

         
            Session::flash('message', " Updated Successfully.");
              return redirect()->back();




        }else{

              $data = request()->validate([
              'export_percentage' => ['required', 'numeric'],
              'market' => ['required' ],
              'market.*' => ['required', 'string', 'max:255'],
              'export_year' => ['required', 'numeric'],


           ]);

              $market = implode(',', $data['market']);
        
             \App\ExportCapability::create([
              'user_id' => Auth::user()->id,
              'export_percentage' => $data['export_percentage'],
              'main_markets' => $market,
              'export_started' => $data['export_year'],



              ]);
    

         
            Session::flash('message', " Added Successfully.");
              return redirect()->back();

        }

      
         

    }

 */
}
