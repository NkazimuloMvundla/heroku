<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecOption extends Model
{
    protected $fillable = [
        'product_id', 'spec_parent_id',  'spec_option_name',
    ];
}
