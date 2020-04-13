<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class ReadEmailController extends Controller
{
    public function create($emailId)
    {

        $email_Id = base64_decode($emailId);
        $userMessages = \App\Message::where('id', $email_Id)->get();
        if (count($userMessages)  > 0) {
            $msg_from = \App\User::where('id',  $userMessages->first()->msg_from_id);
            $msg_to = \App\User::where('id',  $userMessages->first()->msg_to_id);
            return view('admin.mailbox.read-email', compact('userMessages', 'msg_from', 'msg_to'));
        } else {
            return redirect()->back();
        }
    }

    public function reply_view($message_id)
    {
        $userMessages = \App\Message::where('id', $message_id)->get();
        $msg_from = \App\User::where('id',  $userMessages->first()->msg_from_id);
        $msg_to = \App\User::where('id',  $userMessages->first()->msg_to_id);
        return view('admin.mailbox.reply', compact('userMessages', 'msg_from', 'msg_to'));
    }



    public function store(Request $request)
    {

        $data = request()->validate([
            'msg_from_id' => ['numeric'],
            'msg_to_id' => ['numeric'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:255'],
            'reply_attachment' => ['nullable'],

        ]);

        if (request()->has('reply_attachment') && !empty(request()->reply_attachment)) {

            $reply_attachment = request('reply_attachment')->store('reply_attachment', 'public');

            \App\Message::create([
                'msg_from_id' => $data['msg_from_id'],
                'msg_to_id' => $data['msg_to_id'],
                'msg_subject' => $data['subject'],
                'msg_body' => $data['message'],
                'reply_attachment' => $reply_attachment,
                'price' => 0,
                'quantity_unit' => '0',
                'quantity' => 0,
                'msg_read' => 0,

            ]);
        } else {
            \App\Message::create([
                'msg_from_id' => $data['msg_from_id'],
                'msg_to_id' => $data['msg_to_id'],
                'msg_subject' => $data['subject'],
                'msg_body' => $data['message'],
                'price' => 0,
                'quantity_unit' => '0',
                'quantity' => 0,
                'msg_read' => 0,

            ]);
        }







        Session::flash('sent-success-message', "Message sent successfully.");
        return redirect()->back();
    }
}
