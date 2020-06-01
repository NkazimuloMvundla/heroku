<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Response;
use Session;

class FaqController extends Controller
{
    public function create()
    {

        return view('super.add-faq');
    }

    public function store(Request $request)
    {

        if (request()->ajax()) {

            $data = request()->validate([
                'faq_name' => ['required', 'string', 'max:255'],


            ]);

            \App\Faq::create([
                'faq_name' => trim($data['faq_name']),



            ]);
        }
    }

    public function viewFaq()
    {

        $faqs = DB::table('faqs')->paginate(20);


        return view('super.faq-view', compact('faqs'));
    }
    public function showFaq()
    {

        if (request()->ajax()) {
            $data = request()->validate([
                'id' => ['numeric'],
            ]);
            $result = \App\Faq::where('id', trim($data['id']))->get();
            return response::json($result);
        }
    }
    public function faqUpdate(Request $request)
    {

        if (request()->ajax()) {

            $data = request()->validate([
                'id' => ['numeric'],
                'faq_name' => ['required', 'string', 'max:255'],

            ]);

            \App\Faq::where('id', trim($data['id']))->update([
                'faq_name' => trim($data['faq_name']),
            ]);
        }
    }

    public function deleteSinglefaq()
    {

        if (request()->ajax()) {
            $id = request()->validate([
                'id' => ['numeric'],


            ]);
            \App\Faq::where('id', trim($id))->delete();
        }
    }

    public function destroyMultipleFaq()
    {

        if (request()->ajax()) {
            $data = request()->validate([
                'checked' => ['array'],
                'checked.*' => ['numeric'],
            ]);

            foreach ($data['checked'] as $id) {
                \App\Faq::where('id', trim($id))->delete();
            }
        }
    }

    public function addFaqContent()
    {

        $faqs = DB::table('faqs')->get();

        return view('super.add-faq-content', compact('faqs'));
    }

    public function storeFaqContent(Request $request)
    {



        $data = request()->validate([
            'faq_name' => ['required', 'string', 'max:255'],
            'faq_heading' => ['required', 'string', 'max:255'],
            'faq_content' => ['required', 'string'],

        ]);


        \App\FaqContent::create([
            'faq_name' => trim($data['faq_name']),
            'faq_heading' => trim($data['faq_heading']),
            'faq_content' => trim($data['faq_content']),

        ]);


        Session::flash('addFaqcontent', "Content Added Successfully.");
        return redirect()->back();
    }

    public function edit($faq_name)
    {

        $data = request()->validate([
            'faq_name' => ['string'],

        ]);

        $faqs = DB::table('faqs')->get();
        $faq = \App\FaqContent::where('faq_name', trim($data['faq_name']));
        return view('super.edit-faq-content', compact('faq', 'faqs'));
    }
    public function faqContentUpdate(Request $request)
    {

        if (request()->ajax()) {

            $data = request()->validate([
                'faq_name' => ['required', 'string', 'max:255'],
                'faq_heading' => ['required', 'string', 'max:255'],
                'faq_content' => ['required', 'string'],

            ]);


            \App\FaqContent::where('faq_name', $data['faq_name'])->update([
                'faq_name' => trim($data['faq_name']),
                'faq_heading' => trim($data['faq_heading']),
                'faq_content' => trim($data['faq_content']),

            ]);
        }
    }
}
