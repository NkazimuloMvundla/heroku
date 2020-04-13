<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Response;
use Auth;

class MessageController extends Controller
{
  public function store(Request $request){


        if(request()->ajax()){
         $exist = \App\User::where('id', request()->msg_to_id)->get();
         if(count($exist) > 0){
            $data = request()->validate([
                'msg_from_id' =>['numeric'],
                'msg_to_id' =>['numeric'],
                'subject' => ['required', 'string', 'max:255'],
                'price' => ['required', 'numeric'],
                'quantityUnit' => ['required', 'string', 'max:255'],
                'quantity' => ['required', 'numeric'],
                'comment' => ['required','string', 'max:255'],


             ]);


            \App\ Message::create([
              'msg_from_id' => $data['msg_from_id'],
              'msg_to_id' => $data['msg_to_id'],
              'msg_subject' => $data['subject'],
              'msg_body' => $data['comment'] ,
              'price' =>$data['price'],
              'quantity_unit'=>$data['quantityUnit'],
              'quantity' =>$data['quantity'],


                ]);


         }

        }


  }

  public function destroyEmails(){

    if(request()->ajax()){
        /*
        $data = request()->validate([
            'checked' => ['numeric'],


         ]);

         */
      $ids = request()->checked;
    //  $count = count($ids);
      if(!empty($ids) && is_array($ids)){
        foreach($ids as $id){
            \App\Message::where('id', $id)->delete();
        }
      }


    }


  }

  public function updateStatus(){

    if(request()->ajax()){

        $data = request()->validate([
            'id' => ['numeric'],


         ]);


  \App\Message::where('id' , $data['id'])->update(['msg_read'=> 1]);



    }


  }


  public function show(){

    $allMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 1])->get();
    $count_all_emails = count($allMessages);
    $sentEmails = \App\Message::where('msg_from_id' , Auth::user()->id)->get();
    $count_sent_emails = count($sentEmails);
    $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
    $count_emails = count($userMessages);
    $users = \App\User::all();
    return view('/admin/mailbox/all-emails', compact('allMessages', 'users', 'count_emails','count_sent_emails','count_all_emails'));
  }








}
