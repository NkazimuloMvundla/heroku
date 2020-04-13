<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FaqContent extends Model
{

    protected $fillable = [
        'faq_name', 'faq_heading', 'faq_content',
   ];
}
