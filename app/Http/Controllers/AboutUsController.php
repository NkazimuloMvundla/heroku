<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class AboutUsController extends Controller
{
    public function create(){
 	$pCats = \App\productCategory::all();
       $subCats = \App\SubCategory::all();
       $lastCats = \App\lastCategory::all();
        $buyingRequests =\App\BuyingRequest::all();
          $countBuyingRequest = count($buyingRequests);
          $about_us_content = \App\CMS::where('cms_title',  'About us')->get();
    	 if(Auth::check()){
            $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
            $count = count($userMessages);
        return view('front.About-us',compact('pCats','subCats','lastCats', 'count', 'countBuyingRequest', 'about_us_content'));

        }else{
        return view('front.About-us',compact('pCats','subCats','lastCats','about_us_content'));
            
        }
      
    }
}
