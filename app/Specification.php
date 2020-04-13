<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specification extends Model
{
     protected $fillable = [
             'spec_subCatid',  'spec_name', 'spec_parentCat_id',
    ];
}
