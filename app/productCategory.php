<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class productCategory extends Model
{
    protected $fillable = [
        'pc_name',
    ];

    public function subcategory(){
    	return $this->belongsTo(productCategory::class , 'pc_id');
    }
}
