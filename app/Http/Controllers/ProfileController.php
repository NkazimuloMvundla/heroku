<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use App\Rules\PhotoEditEqualToOne;
use App\Rules\PhotoEditEqualToThree;
use App\Rules\PhotoEditMaxUpload;
use App\Rules\PhotoMaxUpload;
use Validator;
use DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user()->name;

        $user_details = \App\User::where('name', $user)->get();
        $ExportCapability = \App\ExportCapability::where('user_id', Auth::user()->id)->get();
        $CompanyCertificate = \App\CompanyCertificate::where('user_id', Auth::user()->id)->get();
        $countExportCapability = count($ExportCapability);
        $notifications =  DB::table('notifications')->where('user_id', Auth::user()->id)->get();
        $countNotifications = count($notifications);
        Session::put('notifications', $notifications);
        Session::put('count_notifications', $countNotifications);
        $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
        $count = count($userMessages);
        Session::put('user_messages', $userMessages);
        Session::put('user_messages_count', $count);
        return view('admin.profile', compact('user_details', 'ExportCapability', 'countExportCapability', 'CompanyCertificate'));
    }

    public function update()
    {


        $data = request()->validate([
            'about_us' => ['required', 'string', 'max:255'],
            'company_address' => ['required', 'string', 'max:255'],
            'zip_code' => ['required', 'numeric', 'digits_between:0,10'],
            'company_name' => ['required', 'string', 'max:255'],
            // 'business_type' => ['required', 'string', 'max:255'],
            'registration_number' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'numeric', 'digits_between:0,10'],



        ]);


        Auth::user()->update([
            'about_us' => trim($data['about_us']),
            'company_address' => trim($data['company_address']),
            'zip_code' => trim($data['zip_code']),
            'company_name' => trim($data['company_name']),
            // 'account_type' =>$data['business_type'],
            'registration_number' => trim($data['registration_number']),
            'phone_number' => trim($data['phone_number']),

        ]);
        Session::flash('message', "Updated Successfully.");
        return redirect()->route('Profile');
    }

    public function showBusinessCard()
    {
        $user = Auth::user()->name;

        $user_details = \App\User::where('name', $user)->get();
        $company_images = \App\CompanyImages::where('user_id', Auth::user()->id)->get();
        $notifications =  DB::table('notifications')->where('user_id', Auth::user()->id)->get();
        $countNotifications = count($notifications);
        Session::put('notifications', $notifications);
        Session::put('count_notifications', $countNotifications);
        $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
        $count = count($userMessages);
        Session::put('user_messages', $userMessages);
        Session::put('user_messages_count', $count);
        return view('admin.business-card', compact('user_details', 'company_images'));
    }


    public function storeCardDetails()
    {


        $data = request()->validate([
            'business_slogan' => ['nullable', 'string', 'max:255'],
            'company_logo' => ['nullable', 'image', 'mimes:jpeg,png', 'max:2048'],
            'business_card_background' => ['nullable', 'image', 'mimes:jpeg,png', 'max:2048']


        ]);


        if (!empty($data['business_slogan']) || $data['business_slogan'] != NULL) {
            //check to see if this field is empty in the DB , if it is then create
            if (Auth::user()->company_slogan == "") {
                Auth::user()->update([
                    'company_slogan' => trim($data['business_slogan']),

                ]);
            } else {
                Auth::user()->update([
                    'company_slogan' => trim($data['business_slogan']),

                ]);
            }
        }
        if (!empty(request()->company_logo) || request()->company_logo != NULL) {

            // $company_logo = request('company_logo')->store('profile', 'public');
            //check to see if this field is empty in the DB , if it is then create
            // $imgPath = $file->store('pd_images', 'public');
            $pathToFile = Storage::disk('public')->put('profile', request()->company_logo);
            $image = Image::make(public_path($pathToFile))->fit(64, 64);
            $image->save();

            if (Auth::user()->company_logo == "") {
                Auth::user()->update([
                    'company_logo' => $pathToFile,

                ]);
            } else {


                $absolute = '\Users\Judge\freeCodeGram\public' . "\\" . Auth::user()->company_logo;
                if (file_exists($absolute)) {
                    $success = unlink($absolute);

                    if ($success) {
                        $data = request()->validate([
                            'company_logo' => ['nullable', 'image', 'mimes:jpeg,png', 'max:2048']
                        ]);


                        Auth::user()->update([
                            'company_logo' => $pathToFile,

                        ]);
                    }
                }
            }
        }
        if (!empty(request()->business_card_background) || request()->business_card_background != NULL) {

            // $business_card_background = request('business_card_background')->store('profile', 'public');

            $pathToFile = Storage::disk('public')->put('profile', request()->business_card_background);

            $image = Image::make(public_path($pathToFile))->fit(200, 130);
            $image->save();
            //check to see if this field is empty in the DB , if it is then create
            if (Auth::user()->company_background_img == "") {
                Auth::user()->update([
                    'company_background_img' =>   $pathToFile,

                ]);
            } else {

                $absolute = '\Users\Judge\freeCodeGram\public' . "\\" . Auth::user()->company_background_img;
                if (file_exists($absolute)) {
                    $success = unlink($absolute);

                    if ($success) {

                        $data = request()->validate([
                            'company_background_img' => ['image', 'mimes:jpeg,png', 'max:2048'],
                        ]);

                        Auth::user()->update([
                            'company_background_img' => $pathToFile,

                        ]);
                    }
                }
            }
        }
        if (!empty(request()->company_images) || request()->company_images != NULL) {
            //check how many images already exist in the DB with the same ID
            $images =  \App\CompanyImages::where('user_id', Auth::user()->id)->get();
            $countImgs = count($images);
            //IF THERE'S NO IMAGES IN THE DB

            if ($countImgs < 1) {
                request()->validate([
                    'company_images' => ['nullable', 'array', new PhotoMaxUpload],
                    'company_images.*' => ['nullable', 'image', 'mimes:jpeg,png', 'max:2048']
                ]);
                //IF THERE'S 2 IMAGES IN THE DB, A USER CANT UPLOAD MORE THAN 1 SINCE LIMIT IS 3
            } else if ($countImgs == 2) {
                request()->validate([
                    'company_images' => [new PhotoMaxUpload, new PhotoEditMaxUpload],

                ]);
                //IF THERE'S 3 IMAGES IN THE DB, A USER CANT UPLOAD ANY PHOTO AT ALL SINCE LIMIT IS 3
            } else if ($countImgs == 3) {
                request()->validate([
                    'company_images' => [new PhotoEditEqualToThree],

                ]);
            }
            //IF THERE'S 1 IMAGE IN THE DB, A USER CANT UPLOAD MORE THAN 2 SINCE LIMIT IS 3
            else if ($countImgs == 1) {
                request()->validate([
                    'company_images' =>  [new PhotoMaxUpload, new PhotoEditEqualToOne],

                ]);
            }
            //IF THERE'S NO IMAGES IN THE DB, A USER CANT UPLOAD MORE THAN 3 SINCE LIMIT IS 3
            else {
                request()->validate([
                    'company_images' => [new PhotoMaxUpload],

                ]);
            }

            foreach (request()->file('company_images') as $file) {

                $imgPath = $file->store('company_images', 'public');

                // $pathToFile = Storage::disk('public')->put('company_images', request()->company_images);

                //check to see if this field is empty in the DB , if it is then create
                $image = Image::make(public_path($imgPath))->fit(1200, 660);
                $image->save();
                //this means ther'es nothing returned, so it empty

                \App\CompanyImages::create([
                    'user_id' => Auth::user()->id,
                    'company_image' => $imgPath,

                ]);
            }
        }
        Session::flash('message', "Updated Successfully.");
        return redirect()->back();
    }

    public function saveCertificates()
    {

        //check how many images already exist in the DB with the same ID
        $images =  \App\CompanyCertificate::where('user_id', Auth::user()->id)->get();
        $countImgs = count($images);
        //IF THERE'S NO IMAGES IN THE DB
        if ($countImgs < 1) {
            request()->validate([
                'file' => ['nullable', 'array', new PhotoMaxUpload],
                'file.*' => ['nullable', 'image'],
            ]);
            //IF THERE'S 2 IMAGES IN THE DB, A USER CANT UPLOAD MORE THAN 1 SINCE LIMIT IS 3
        } else if ($countImgs == 2) {
            request()->validate([
                'file' => [new PhotoMaxUpload, new PhotoEditMaxUpload],
            ]);
            //IF THERE'S 3 IMAGES IN THE DB, A USER CANT UPLOAD ANY PHOTO AT ALL SINCE LIMIT IS 3
        } else if ($countImgs == 3) {
            request()->validate([
                'file' => [new PhotoEditEqualToThree],
            ]);
        }
        //IF THERE'S 1 IMAGE IN THE DB, A USER CANT UPLOAD MORE THAN 2 SINCE LIMIT IS 3
        else if ($countImgs == 1) {
            request()->validate([
                'file' =>  [new PhotoMaxUpload, new PhotoEditEqualToOne],
            ]);
        }
        //IF THERE'S NO IMAGES IN THE DB, A USER CANT UPLOAD MORE THAN 3 SINCE LIMIT IS 3
        else {
            request()->validate([
                'file' => [new PhotoMaxUpload],
            ]);
        }
        foreach (request()->file('file') as $file) {

            $imgPath = $file->store('company_certificate', 'public');

            \App\CompanyCertificate::create([
                'user_id' => Auth::user()->id,
                'filename' => $imgPath,


            ]);
        }
    }

    //delete company certificates

    //delete company images
    public function deleteCompanyCertificate()
    {
        if (request()->ajax()) {
            $data = request()->validate([
                'id' => ['numeric']
            ]);

            $path = \App\CompanyCertificate::where('id', trim($data['id']))->get();
            $paths = $path->first()->filename; //pd_images\image.png

            $absolute = '\Users\Judge\freeCodeGram\public' . "\\" . $paths;
            if (file_exists($absolute)) {
                $success = unlink($absolute);

                if ($success) {
                    \App\CompanyCertificate::where('id', trim($data['id']))->delete();
                }
            }
        }
    }
}
