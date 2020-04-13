<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class SentEmailController extends Controller
{
    public function create()
    {

        //dd($emailId);
        $users = \App\User::all();
        $sentEmails = \App\Message::where('msg_from_id', Auth::user()->id)->orderBy('created_at', 'DESC')->get();
        $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
        $count_emails = count($userMessages);
        $count_sent_emails = count($sentEmails);
        $allMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 1])->get();
        $count_all_emails = count($allMessages);
        $user_details = \App\User::where('id', Auth::user()->id)->get();
        Session::put('account', $user_details->first()->account_type);
        return view('admin.mailbox.sent', compact('sentEmails', 'users', 'count_emails', 'count_sent_emails', 'count_all_emails'));
    }
}
