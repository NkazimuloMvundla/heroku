<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BuyingRequest extends Model
{
   protected $fillable = [
        'br_u_id' , 'br_pc_id', 'br_pc_name', 'br_pd_spec',  'br_attachment',  'br_order_qty',  'br_order_qnty_unit', 'br_expired_date',
    ];

    public function User(){
        return $this->belongsTo(User::class);
    }
}
