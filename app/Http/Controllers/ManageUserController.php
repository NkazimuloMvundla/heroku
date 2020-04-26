<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Response;

class ManageUserController extends Controller
{
    public function create()
    {

        $users = DB::table('users')->paginate(50);
        $allusers = \App\User::all();
        $count = count($allusers);

        return view('super.manage-users', compact('users', 'count'));
    }

    public function show(Request $request)
    {

        if (request()->ajax()) {

            $data = request()->validate([
                'id' => ['numeric'],

            ]);


            return $data;
        }
    }



    public function approve(Request $request)
    {

        if (request()->ajax()) {

            $data = request()->validate([
                'id' => ['numeric'],

            ]);


            \App\User::where('id', $data['id'])->update(['status' => 1]);
        }
    }
    /*
    public function assignRole(Request $request)
    {

        if (request()->ajax()) {

            $data = request()->validate([
                'id' => ['numeric'],
                'role' => ['string']

            ]);


            \App\User::where('id', $data['id'])->update(['role' => $data['role']]);
        }
    }
*/


    public function suspend(Request $request)
    {

        if (request()->ajax()) {

            $data = request()->validate([
                'id' => ['numeric'],

            ]);


            \App\User::where('id', $data['id'])->update(['status' => 2]);
        }
    }


    public function destroyMultipleUsers()
    {

        if (request()->ajax()) {
            /*
            $data = request()->validate([
                'checked' => ['numeric'],


             ]);

             */
            $ids = request()->checked;
            //  $count = count($ids);
            if (!empty($ids) && is_array($ids)) {
                //if you are deleting a user, remove photos images, company_images, and certificates
                foreach ($ids as $id) {
                    $user = \App\User::where('id', $id)->get();
                    //delete company_background_img
                    $paths = $user->first()->company_background_img;
                    if ($paths != "") {
                        $absolute = '\Users\Judge\freeCodeGram\public\storage' . "\\" . $paths;
                        if (file_exists($absolute)) {
                            $success = unlink($absolute);
                        }
                    }


                    //delete company_logo -img
                    $paths = $user->first()->company_logo;
                    if ($paths != "") {
                        $absolute = '\Users\Judge\freeCodeGram\public\storage' . "\\" . $paths;
                        if (file_exists($absolute)) {
                            $success = unlink($absolute);
                        }
                    }


                    //delete product photos and remove images
                    $path = \App\Photo::where('pd_u_id', $id)->get();
                    foreach ($path as $imgPath) {
                        $paths = $imgPath->pd_filename; //pd_images\image.png
                        if ($paths != "") {
                            $absolute = '\Users\Judge\freeCodeGram\public\storage' . "\\" . $paths;
                            if (file_exists($absolute)) {
                                $success = unlink($absolute);

                                if ($success) {
                                    \App\Photo::where('pd_u_id', $id)->delete();
                                    \App\Product::where('pd_u_id', $id)->delete();
                                }
                            }
                        }
                    }
                    //delete certificates photos and remove images
                    $CompanyCertificate = \App\CompanyCertificate::where('user_id', $id)->get();
                    foreach ($CompanyCertificate as $imgPath) {
                        if ($paths != "") {
                            $paths = $imgPath->pd_filename; //pd_images\image.png
                            $absolute = '\Users\Judge\freeCodeGram\public\storage' . "\\" . $paths;
                            if (file_exists($absolute)) {
                                $success = unlink($absolute);

                                if ($success) {
                                    \App\CompanyCertificate::where('user_id', $id)->delete();
                                }
                            }
                        }
                    }

                    //delete CompanyImages photos and remove images
                    $CompanyImages = \App\CompanyImages::where('user_id', $id)->get();
                    foreach ($CompanyImages as $imgPath) {
                        $paths = $imgPath->pd_filename; //pd_images\image.png
                        if ($paths != "") {
                            $absolute = '\Users\Judge\freeCodeGram\public\storage' . "\\" . $paths;
                            if (file_exists($absolute)) {
                                $success = unlink($absolute);

                                if ($success) {
                                    \App\CompanyImages::where('user_id', $id)->delete();
                                }
                            }
                        }
                    }
                    \App\User::where('id', $id)->delete();
                }
            }
        }
    }


    public function showUser()
    {

        if (request()->ajax()) {
            $data = request()->validate([
                'id' => ['numeric'],
            ]);
            $result = \App\User::where('id', $data['id'])->get();
            return response::json($result);
        }
    }
}
