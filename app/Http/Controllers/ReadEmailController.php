<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class ReadEmailController extends Controller
{
    public function create($emailId)
    {

        $decoded_email_Id = base64_decode($emailId);
        $trimed_email_Id = trim($decoded_email_Id);
        $sanitized_email_id = filter_var($trimed_email_Id, FILTER_SANITIZE_NUMBER_INT);
        if (filter_var($sanitized_email_id, FILTER_VALIDATE_INT)) {
            $userMessages = \App\Message::where('id', $sanitized_email_id)->get();
            if (count($userMessages)  > 0) {
                $msg_from = \App\User::where('id',  $userMessages->first()->msg_from_id);
                $msg_to = \App\User::where('id',  $userMessages->first()->msg_to_id);
                return view('admin.mailbox.read-email', compact('userMessages', 'msg_from', 'msg_to'));
            } else {
                return redirect()->back();
            }
        }
    }

    public function reply_view($message_id)
    {
        $_id = base64_decode($message_id);
        $_id = trim($_id);
        $sanitized_id = filter_var($_id, FILTER_SANITIZE_NUMBER_INT);
        if (filter_var($sanitized_id, FILTER_VALIDATE_INT)) {
            $userMessages = \App\Message::where('id', $sanitized_id)->get();
            if (count($userMessages)  > 0) {
                $msg_from = \App\User::where('id',  $userMessages->first()->msg_from_id);
                $msg_to = \App\User::where('id',  $userMessages->first()->msg_to_id);
                return view('admin.mailbox.reply', compact('userMessages', 'msg_from', 'msg_to'));
            } else {
                return redirect()->back();
            }
        }
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
                'msg_from_id' => trim($data['msg_from_id']),
                'msg_to_id' => trim($data['msg_to_id']),
                'msg_subject' => trim($data['subject']),
                'msg_body' => trim($data['message']),
                'reply_attachment' => $reply_attachment,
                'price' => 0,
                'quantity_unit' => '0',
                'quantity' => 0,
                'msg_read' => 0,

            ]);
        } else {
            \App\Message::create([
                'msg_from_id' => trim($data['msg_from_id']),
                'msg_to_id' => trim($data['msg_to_id']),
                'msg_subject' => trim($data['subject']),
                'msg_body' => trim($data['message']),
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
