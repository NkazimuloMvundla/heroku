<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;

class AnswersController extends Controller
{

    public function getAnswer()
    {

        if (request()->ajax()) {
            $data = request()->validate([
                'id' => ['numeric'],
            ]);
            $result = \App\Answers::where('id', $data['id'])->get(['id', 'answer']);
            return response::json($result);
        }
    }
    public function updateAnswer()
    {

        if (request()->ajax()) {
            $data = request()->validate([
                'id' => ['nullable', 'numeric'],
                'answer' =>  ['nullable', 'string', 'max:255'],
            ]);

            \App\Answers::where('id', $data['id'])->update([
                'answer' => $data['answer'],
                //    'priority' => 2,

            ]);
        }
    }
}
