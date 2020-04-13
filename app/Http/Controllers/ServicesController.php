<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class ServicesController extends Controller
{
 public function create(){
    
    $pCats = \App\productCategory::all();
    $subCats = \App\SubCategory::all();
    $lastCats = \App\lastCategory::all();
     $buyingRequests =\App\BuyingRequest::all();
        $countBuyingRequest = count($buyingRequests);
        if(Auth::check()){
            $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
            $count = count($userMessages);
            return view('front.services', compact('pCats','subCats','lastCats','count', 'countBuyingRequest'));
          }else{
return view('front.services', compact('pCats','subCats','lastCats'));
          }
   
 }
}
