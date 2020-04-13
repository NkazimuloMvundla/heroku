<?php

if(!function_exists('checkImg')){

function checkImg($id){
    $images =\App\Photo::where('pd_photo_id',$id )->get();
    $countImgs = count($images);
    if($countImgs < 1){
       request()->validate([

             'Product_photo' => ['required',new PhotoMaxUpload],

         ]);
    }else if($countImgs == 2){
        request()->validate([

            'Product_photo' => [new PhotoMaxUpload, new PhotoEditMaxUpload],

          ]);
     }
     else if($countImgs == 3){
        request()->validate([

            'Product_photo' => [new PhotoMaxUpload, new PhotoEditMaxUpload],

          ]);
     }
     else if($countImgs == 3){
        request()->validate([

            'Product_photo' => [new PhotoEditEqualToThree],

          ]);
     }
     else if($countImgs == 1){
        request()->validate([

            'Product_photo' =>  [new PhotoMaxUpload, new PhotoEditEqualToOne],

          ]);
     } else{
        request()->validate([

            'Product_photo' =>  [new PhotoMaxUpload],

          ]);
     }

}


}
