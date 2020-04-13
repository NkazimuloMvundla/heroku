<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use DB;
use Auth;
class ProductCategoryController extends Controller

{
    public function store(Request $request){

        if(request()->ajax()){

          $data = request()->validate([
              'main_category' => ['required', 'string', 'max:255'],

           ]);

          \App\productCategory::create([
            'pc_name' => $data['main_category'],


              ]);


          }

  }

  public function create(){


    return view('super.maincategory-add');
  }
  public function viewMain(){

    $mainCategories = DB::table('product_categories')->paginate(10);

    return view('super.maincategory-view', compact('mainCategories'));
  }



  public function deleteSingleMainCategory(){

    if(request()->ajax()){
        $id = request()->validate([
            'id' => ['numeric'],


         ]);
      \App\productCategory::where('pc_id', $id)->delete();
    }


  }
  public function destroyMultipleMainCategories(){

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
            \App\productCategory::where('pc_id', $id)->delete();
        }
      }


    }


  }
  public function showMain(){

    if(request()->ajax()){
      $data = request()->validate([
        'id' => ['numeric'],
     ]);
      $result = \App\productCategory::where('pc_id' , $data['id'])->get();
         return response::json($result);
    }


  }
  public function mainUpdate(Request $request){

    if(request()->ajax()){

      $data = request()->validate([
          'id' => ['numeric'],
          'main_category' => ['required', 'string', 'max:255'],

       ]);

      \App\productCategory::where('pc_id', $data['id'])->update([
        'pc_name' => $data['main_category'],


          ]);


      }

}

   public function product(){

     return $this->hasMany(Product::class);
   }

   public function showCategories(){
    $pCats = \App\productCategory::all();
    $subCats = \App\SubCategory::all();
    $lastCats = \App\lastCategory::all();
    $buyingRequests =\App\BuyingRequest::all();
    $countBuyingRequest = count($buyingRequests);
    if(Auth::check()){
        $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
        $count = count($userMessages);
        return view('front.mobile-categories',compact('pCats','subCats','lastCats' , 'count', 'countBuyingRequest'));
      }else{

        return view('front.mobile-categories',compact('pCats','subCats','lastCats'));
      }


  }
}
