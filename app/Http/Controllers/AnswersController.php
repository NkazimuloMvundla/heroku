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
            $id = trim($data['id']);
            $result = \App\Answers::where('id', $id)->get(['id', 'answer']);
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

            $id = trim($data['id']);
            $answer = trim($data['answer']);
            \App\Answers::where('id', $id)->update([
                'answer' => $answer,
            ]);
        }
    }
}
