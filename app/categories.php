<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class categories extends Model
{
    protected $fillable = [
        'id', 'pc_name',  'pc_id', 'pc_status','pc_image' ,
    ];
   public function productCategory(){
    	return $this->hasMany(categories::class , 'pc_id');
    }
}
