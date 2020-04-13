<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExportCapability extends Model
{
    protected $fillable = [
        'user_id','export_percentage', 'main_markets', 'export_started',
   ];
}
