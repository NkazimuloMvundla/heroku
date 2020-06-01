<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Response;

class QuestionsController extends Controller
{
    public function storeProductFAQ(Request $request)
    {
        $data = request()->validate([
            'pd_id' => ['numeric'],
            'questions' => ['nullable', 'string'],
            'answers' => ['nullable', 'string'],
        ]);
        $data['pd_id'] = trim($data['pd_id']);
        $questions = explode(',', $data['questions']);
        $answers = explode(',', $data['answers']);
        //check if there's already 4 questins in the DB
        $DBquestions = \App\Questions::where('pd_id', $data['pd_id'])->get();
        //if 4 in db,nomre can come
        if (count($DBquestions) == 4) {
            echo htmlspecialchars("The limit is 4 questions per product.");
        }
        //if 3 in db, coming should be 1
        else if (count($DBquestions) == 3 && count($questions) > 1) {
            echo htmlspecialchars("you have 3 , coming is one");
        }
        //if 2 in db , coming should b 2
        else if (count($DBquestions) == 2 && count($questions) > 2) {
            echo htmlspecialchars("you have 2 , coming is 2");
        }
        //if 1 in db , coming shoul b 3
        else if (count($DBquestions) == 1 && count($questions) > 3) {
            echo htmlspecialchars("you have 1 , coming is 3");
        }
        //if 0 in db , coming shoulb b 4
        else if (count($questions) <= 4) {
            if (!empty($questions) && !empty($answers)) {
                for ($i = 0; $i < count($questions); $i++) {


                    //insert questions and get last id
                    $id = DB::table('questions')->insertGetId([
                        'pd_id' => $data['pd_id'],
                        'question' => $questions[$i],
                    ]);

                    //insert answers
                    \App\Answers::create([
                        'pd_id' => $data['pd_id'],
                        'question_id' => $id,
                        'answer' => $answers[$i],
                    ]);
                }

                echo htmlspecialchars('success');
            }
        } else {
            return count($DBquestions) . " " .  count($questions);
        }
    }

    public function getquestion()
    {

        if (request()->ajax()) {
            $data = request()->validate([
                'id' => ['numeric'],
            ]);
            $result = \App\Questions::where('id', trim($data['id']))->get(['id', 'question']);
            return response::json($result);
        }
    }
    public function updateQuestion()
    {

        if (request()->ajax()) {
            $data = request()->validate([
                'id' => ['nullable', 'numeric'],
                'question' =>  ['nullable', 'string', 'max:255'],
            ]);

            \App\Questions::where('id', trim($data['id']))->update([
                'question' => trim($data['question']),

            ]);
        }
    }

    public function deleteQuestionAndAswer()
    {
        if (request()->ajax()) {

            //delete a question
            if (!empty(request()->question_id)) {
                $valid = request()->validate([
                    'question_id' => ['nullable', 'numeric'],

                ]);

                $questions = \App\Questions::where('id', trim($valid['question_id']))->get();
                $question_id = $questions->first()->id;
                \App\Answers::where('question_id', $question_id)->delete();
                \App\Questions::where('id', trim($valid['question_id']))->delete();
            }
        }
    }
}
