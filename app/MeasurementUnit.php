<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MeasurementUnit extends Model
{
  protected $fillable = [
       'mu_id', 'mu_name',  'mu_status', 
   ];
}
