<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SellingRequests extends Model
{
    protected $fillable = [
        'sr_u_id', 'sr_pc_id', 'sr_pc_name', 'sr_pd_spec',  'sr_attachment',  'sr_order_qty',  'sr_order_qnty_unit', 'message', 'sr_expired_date',
    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
