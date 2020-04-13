<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;

class InboxController extends Controller
{
    public function create()
    {

        $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->orderBy('created_at', 'DESC')->get();
        $sentEmails = \App\Message::where('msg_from_id', Auth::user()->id)->get();
        $count_sent_emails = count($sentEmails);
        $count_emails = count($userMessages);

        $allMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 1])->get();
        $count_all_emails = count($allMessages);

        $users = \App\User::all();
        $user_details = \App\User::where('id', Auth::user()->id)->get();
        Session::put('account', $user_details->first()->account_type);

        return view('admin.mailbox.inbox', compact('userMessages', 'users', 'count_emails', 'count_sent_emails', 'count_all_emails'));
    }
}
