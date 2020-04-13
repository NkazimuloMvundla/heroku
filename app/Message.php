<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
  protected $fillable = [
       'msg_from_id' , 'msg_to_id', 'msg_subject', 'msg_body',  'msg_read','price','reply_attachment', 'quantity_unit','quantity',
   ];

}
