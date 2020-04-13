<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Response;
use Illuminate\Support\Facades\DB;
class ManageBuyRequestController extends Controller
{
    public function create(){
        $user = Auth::user()->id;

        $buyingRequests = \App\BuyingRequest::where( 'br_u_id', $user)-> get();

            return view('admin.manage-buy-request', compact('buyingRequests'));
        }


        public function update(){
            if(request()->ajax()){
                $data = request()->validate([
                    'id' => ['numeric'],
                    'br_pd_spec' => ['string'],


                 ]);

              \App\BuyingRequest::where('id', $data['id'])->update(['br_pd_spec' =>  $data['br_pd_spec'] , 'br_approval_status' => 0]);


              }
        }

        public function deleteRequest(){
            if(request()->ajax()){
                $data = request()->validate([
                    'id' => ['numeric'],
                 ]);

              \App\BuyingRequest::where('id', $data['id'])->delete();


              }
        }
        /*-------------------------------------------*/
        //==================super admin============//
        public function view(){

            $buyingRequests = DB::table('buying_requests')->paginate(5);
            $sub_categories = DB::table('last_categories')->get();
            $users = DB::table('users')->get();
            $count = count($buyingRequests);

                return view('super.manage-buy-request', compact('buyingRequests', 'count', 'sub_categories', 'users'));
            }

            public function approve(Request $request){

                if(request()->ajax()){

                    $data = request()->validate([
                        'id' =>['numeric'],

                     ]);


                   \App\BuyingRequest::where('id' ,$data['id'])->update(['br_approval_status'=> 1]);


                  }
            }
            public function suspend(Request $request){

                if(request()->ajax()){

                    $data = request()->validate([
                        'id' =>['numeric'],

                     ]);



                     \App\BuyingRequest::where('id' ,$data['id'])->update(['br_approval_status'=> 2]);


                  }
            }

            public function deleteSingleRequest(){

                if(request()->ajax()){
                    $id = request()->validate([
                        'id' => ['numeric'],


                     ]);
                  \App\BuyingRequest::where('id', $id)->delete();
                }


              }

              public function destroyMultiplerequests(){

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
                        \App\BuyingRequest::where('id', $id)->delete();
                    }
                  }


                }


              }

              public function showRequest(){

                if(request()->ajax()){
                  $data = request()->validate([
                    'id' => ['numeric'],
                 ]);

                  $result = \App\BuyingRequest::where('id' , $data['id'])->get();
                 // $photos = \App\Photo::where('pd_photo_id' , $data['id'])->get();
                  /*
                  foreach ($photos as $value) {
                   $data =  '<img src="/storage/' . $value['pd_filename'] . '"' . 'width="100"' . 'height="200"' . '>' ;
                  }
                  */
                     return response::json($result);
                }


              }

              public function showUser(){

                if(request()->ajax()){
                  $data = request()->validate([
                    'id' => ['numeric'],
                 ]);
                  $result = \App\User::where('id' , $data['id'])->get();
                     return response::json($result);
                }


              }
}
