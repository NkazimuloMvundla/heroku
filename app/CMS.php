<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CMS extends Model
{
    protected $fillable = [
        'id' , 'cms_title', 'cms_page', 'cms_content',  'cms_banner','cms_status',
    ];
}
