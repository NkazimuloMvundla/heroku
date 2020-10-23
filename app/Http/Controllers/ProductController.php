<?php

namespace App\Http\Controllers;

use App\Product;
use App\Rules\PhotoEditEqualToOne;
use App\Rules\PhotoEditEqualToThree;
use App\Rules\PhotoEditMaxUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Auth;
use DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\File;
use App\Rules\PhotoMaxUpload;
use Response;
use Intervention\Image\Facades\Image;
use validate;

class ProductController extends Controller
{
    public function create()
    {

        $parent_category = \App\productCategory::all();
        $pCats = \App\productCategory::all();
        $subCats = \App\SubCategory::all();
        $lastCats = \App\lastCategory::all();
        $measurementUnits = \App\MeasurementUnit::all();
        $paymentTerms = \App\PaymentTerms::all();
        $buyingRequests = \App\BuyingRequest::where('br_approval_status', 1)->get();
        $countBuyingRequest = count($buyingRequests);
        $user_details = \App\User::where('id', Auth::user()->id)->get();
        Session::put('account', $user_details->first()->account_type);
        $notifications =  DB::table('notifications')->where('user_id', Auth::user()->id)->get();
        $countNotifications = count($notifications);
        Session::put('notifications', $notifications);
        Session::put('count_notifications', $countNotifications);
        if (Auth::check()) {
            $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
            $count = count($userMessages);
            Session::put('user_messages', $userMessages);
            Session::put('user_messages_count', $count);

            return view('admin.add-new-product', compact('pCats', 'subCats', 'lastCats', 'parent_category', 'measurementUnits', 'paymentTerms', 'count', 'countBuyingRequest'));
        } else {

            return view('admin.add-new-product', compact('pCats', 'subCats', 'lastCats', 'parent_category', 'measurementUnits', 'paymentTerms'));
        }
    }

    public function store(Request $request)
    {
        $data = request()->validate([
            'mainCategory' => ['required', 'numeric'],
            'Category' => ['required', 'numeric'],
            'subCategory' => ['required', 'numeric'],
            'Product_Name' => ['required', 'string', 'max:255'],
            'Product_Keyword' => ['required', 'string', 'max:255'],
            'file' => ['array'],
            'file.*' => ['image', 'mimes:jpeg,png', 'max:2048'],
            'listing_description' => ['required', 'string', 'max:255'],
            'Minimum_Order_Quantity' => ['required', 'numeric'],
            'Minimum_order_unit' => ['required', 'string', 'max:255'],
            'Min_price' => ['required', 'numeric'],
            'Max_price' => ['required ', 'gt:Min_price', 'numeric'],
            'Minimum_unit' => ['required', 'string', 'max:255'],
            'Port' => ['required', 'string', 'max:255'],
            'paymentMethod' => ['required'],
            'paymentMethod.*' => ['required', 'string'],

            'supplyQuantity' => ['required', 'numeric'],
            'supplyUnit' => ['required', 'string', 'max:255'],
            'supplyPeriod' => ['required', 'string', 'max:255'],
            'deliveryTime' => ['required', 'string', 'max:255'],


        ]);

        $product = \App\Product::where('pd_u_id', Auth::user()->id)->get();
        if (count($product) == 5 && Auth::user()->membership == "Free Member") {
            \App\Notifications::create([
                'message' => " You are a Free Member, you have reached your limit of 5 product you can upload. Upgrade to Gold membership ",
                'user_id' => Auth::user()->id,
            ]);
        }

        $id = DB::table('products')->insertGetId([
            'pd_u_id' => Auth::user()->id,
            'pd_subCategory_id' => trim($data['subCategory']),
            'pd_category_id' => trim($data['Category']),
            'pd_name' => trim($data['Product_Name']),
            'pd_keyword' => trim($data['Product_Keyword']),
            'pd_listing_description' => trim($data['listing_description']),
            'pd_min_order_qty' => trim($data['Minimum_Order_Quantity']),
            'minOrderUnit' => trim($data['Minimum_order_unit']),
            'min_price' => trim($data['Min_price']),
            'max_price' => trim($data['Max_price']),
            'fob_mu_id' => trim($data['Minimum_unit']),
            'port' => trim($data['Port']),
            'pd_payment_term' => trim($data['paymentMethod']),
            'capacity' => trim($data['supplyQuantity']),
            'pd_supply_ability' => trim($data['supplyUnit']),
            'supplyPeriod' => trim($data['supplyPeriod']),
            'pd_delivery_time' => trim($data['deliveryTime']),


        ]);
        if ($id) {
            \App\AdminNotifications::create([
                'message' => Auth::user()->company_name . " added a new product ",
                'user_id' => Auth::user()->id,
            ]);
        }



        $i = 1;
        foreach (request()->file('file') as $file) {
            $pathToFile = Storage::disk('public')->put('pd_images', $file);
            $image = Image::make(public_path($pathToFile))->fit(250, 250);
            $image->save();
            \App\Photo::create([
                'pd_photo_id' => trim($id),
                'pd_u_id' => Auth::user()->id,
                'pd_filename' => $pathToFile,
                'pd_priority' => $i++,

            ]);
        }
        //get any image from photos and make it a main photo
        $mainImage = \App\Photo::where('pd_photo_id', $id)->get();

        //store the main Image
        \App\Product::where('pd_id', $id)->update([
            'pd_photo' => $mainImage->first()->pd_filename,
        ]);

        //inserting into pre defined Specs
        if (!empty(request()->stringName) && !empty(request()->stringIds)) {
            $valid = request()->validate([

                'stringIds' => ['nullable', 'string', 'max:255'],
                'stringName' => ['nullable', 'string', 'max:255'],
            ]);

            $spec_option = explode(',', trim($valid['stringName']));
            $spec_parentIds = explode(',', trim($valid['stringIds']));

            for ($i = 0; $i < count($spec_option); $i++) {

                \App\SpecOption::create([
                    'product_id' => trim($id),
                    'spec_parent_id' => trim($spec_parentIds[$i]),
                    'spec_option_name' => trim($spec_option[$i]),
                ]);
            }
        }

        //inserting into user defined Specs
        //inserting into specifications first and then get last insert id
        if (!empty(request()->specP) && !empty(request()->specC)) {
            $validate = request()->validate([
                'specP' => ['nullable', 'string', 'max:255'],
                'specC' => ['nullable', 'string', 'max:255'],
            ]);

            $specParr = explode(',', $validate['specP']); //thres 2 here ['Judge', 'steve']
            $specCarr = explode(',', $validate['specC']); //thres 1 here ['judge']
            // $countP = count($specParr);
            // $countC = count($specCarr);


            for ($i = 0; $i < count($specParr); $i++) {
                if (!empty($specParr[$i]) && !empty($specCarr[$i]) && count($specParr) == count($specCarr)) {
                    for ($i = 0; $i < count($specCarr); $i++) {
                        //insert parent specification and get last id
                        $specParentId = DB::table('specifications')->insertGetId([
                            'spec_subCatid' => trim($data['subCategory']),
                            'spec_name' => trim($specParr[$i]),
                            'spec_parentCat_id' => trim($data['mainCategory']),
                        ]);

                        //insert spec option
                        \App\SpecOption::create([
                            'product_id' => trim($id),
                            'spec_parent_id' => trim($specParentId),
                            'spec_option_name' => trim($specCarr[$i]),
                        ]);
                    }
                }
            }
        }




        echo htmlspecialchars('success');

        // Session::flash('message', "Product Added Successfully.");
        // return redirect()->back();

    }
    public function edit($product_id)
    {
        $decoded_product_id = base64_decode($product_id);
        $decoded_product_id = trim($decoded_product_id);
        $sanitized_pd_id = filter_var($decoded_product_id, FILTER_SANITIZE_NUMBER_INT);
        if (filter_var($sanitized_pd_id, FILTER_VALIDATE_INT)) {
            $parent_category = \App\productCategory::all();
            $measurementUnits = \App\MeasurementUnit::all();
            $paymentTerms = \App\PaymentTerms::all();
            $data = request()->validate([
                'product_id' => ['numeric'],
            ]);
            $product = \App\Product::where('pd_id', $sanitized_pd_id)->get();
            $pd_images = \App\Photo::where('pd_photo_id', $sanitized_pd_id)->get();
            $questions = \App\Questions::where('pd_id', $sanitized_pd_id)->get();
            $answers = \App\Answers::all();
            $buyingRequests = \App\BuyingRequest::where('br_approval_status', 1)->get();
            $countBuyingRequest = count($buyingRequests);
            $specifications = \App\Specification::all();
            $spec_option = \App\SpecOption::where('product_id', $sanitized_pd_id)->get();
            $user_details = \App\User::where('id', Auth::user()->id)->get();
            Session::put('account', $user_details->first()->account_type);
            $notifications =  DB::table('notifications')->where('user_id', Auth::user()->id)->get();
            $countNotifications = count($notifications);
            Session::put('notifications', $notifications);
            Session::put('count_notifications', $countNotifications);
            if (Auth::check()) {
                $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
                $count = count($userMessages);
                Session::put('user_messages', $userMessages);
                Session::put('user_messages_count', $count);
                return view('admin.product-edit', compact('parent_category', 'specifications', 'spec_option', 'measurementUnits', 'paymentTerms', 'product', 'pd_images', 'count', 'countBuyingRequest', 'questions', 'answers'));
            } else {

                return view('admin.product-edit', compact('specifications', 'spec_option', 'measurementUnits', 'paymentTerms', 'product', 'pd_images', 'questions', 'answers'));
            }
        } else {
            return redirect("/");
        }
    }


    public function update($product_id)
    {
        $decoded_product_id = base64_decode($product_id);
        $decoded_product_id = trim($decoded_product_id);
        $sanitized_pd_id = filter_var($decoded_product_id, FILTER_SANITIZE_NUMBER_INT);
        if (filter_var($sanitized_pd_id, FILTER_VALIDATE_INT)) {
            $data = request()->validate([
                'Product_Name' => ['required', 'string', 'max:255'],
                'Product_Keyword' => ['required', 'string', 'max:255'],
                'Product_photo' => ['array'],
                'Product_photo.*' => ['image', 'mimes:jpeg,png', 'max:2048'],
                'listing_description' => ['required', 'string', 'max:255'],
                'Minimum_Order_Quantity' => ['required', 'numeric'],
                'Minimum_order_unit' => ['required', 'string', 'max:255'],
                'Min_price' => ['required', 'numeric'],
                'Max_price' => ['required ', 'gt:Min_price', 'numeric'],
                'Minimum_unit' => ['required', 'string', 'max:255'],
                'Port' => ['required', 'string', 'max:255'],
                'paymentMethod' => ['required', 'array'],
                'paymentMethod.*' => ['required', 'string'],
                'supplyQuantity' => ['required', 'numeric'],
                'supplyUnit' => ['required', 'string', 'max:255'],
                'supplyPeriod' => ['required', 'string', 'max:255'],
                'deliveryTime' => ['required', 'string', 'max:255'],

            ]);



            $payment = implode(',', $data['paymentMethod']);

            $update = Product::where('pd_id', $sanitized_pd_id)->update([

                'pd_name' => trim($data['Product_Name']),
                'pd_keyword' => trim($data['Product_Keyword']),
                'pd_listing_description' => trim($data['listing_description']),
                'pd_min_order_qty' => trim($data['Minimum_Order_Quantity']),
                'minOrderUnit' => trim($data['Minimum_order_unit']),
                'min_price' => trim($data['Min_price']),
                'max_price' => trim($data['Max_price']),
                'fob_mu_id' => trim($data['Minimum_unit']),
                'port' => trim($data['Port']),
                'pd_payment_term' => $payment,
                'capacity' => trim($data['supplyQuantity']),
                'pd_supply_ability' => trim($data['supplyUnit']),
                'supplyPeriod' => trim($data['supplyPeriod']),
                'pd_delivery_time' => trim($data['deliveryTime']),
                'pd_approval_status' => 0,


            ]);

            if ($update) {
                \App\AdminNotifications::create([
                    'message' => Auth::user()->company_name . " has updated their product " .  $data['Product_Name'] . " ",
                    'user_id' => Auth::user()->id,
                    'product_id' => $sanitized_pd_id
                ]);
            }


            //check how many images already exist in the DB with the same ID
            $images = \App\Photo::where('pd_photo_id', $sanitized_pd_id)->get();
            $countImgs = count($images);
            //IF THERE'S NO IMAGES IN THE DB
            if ($countImgs < 1) {
                request()->validate([
                    'Product_photo' => ['required', new PhotoMaxUpload],
                ]);
                //IF THERE'S 2 IMAGES IN THE DB, A USER CANT UPLOAD MORE THAN 1 SINCE LIMIT IS 3
            } else if ($countImgs == 2) {
                request()->validate([
                    'Product_photo' => [new PhotoMaxUpload, new PhotoEditMaxUpload],
                ]);
                //IF THERE'S 3 IMAGES IN THE DB, A USER CANT UPLOAD ANY PHOTO AT ALL SINCE LIMIT IS 3
            } else if ($countImgs == 3) {
                request()->validate([
                    'Product_photo' => [new PhotoEditEqualToThree],
                ]);
            }
            //IF THERE'S 1 IMAGE IN THE DB, A USER CANT UPLOAD MORE THAN 2 SINCE LIMIT IS 3
            else if ($countImgs == 1) {
                request()->validate([
                    'Product_photo' =>  [new PhotoMaxUpload, new PhotoEditEqualToOne],
                ]);
            }
            //IF THERE'S NO IMAGES IN THE DB, A USER CANT UPLOAD MORE THAN 3 SINCE LIMIT IS 3
            else {
                request()->validate([
                    'Product_photo' => [new PhotoMaxUpload],
                ]);
            }
            if (request()->has('Product_photo') && !empty(request()->Product_photo)) {
                foreach (request()->file('Product_photo') as $file) {

                    // $imgPath = $file->store('pd_images', 'public');
                    $pathToFile = Storage::disk('public')->put('pd_images', $file);

                    $image = Image::make(public_path($pathToFile))->fit(250, 250);
                    $image->save();
                    \App\Photo::create([
                        'pd_photo_id' => $sanitized_pd_id,
                        'pd_u_id' => Auth::user()->id,
                        'pd_filename' => $pathToFile,

                    ]);
                }
            }
            //check if the main photo is empty then update it
            $mainImage = \App\Product::where('pd_id', $sanitized_pd_id)->get();
            if ($mainImage->first()->pd_photo == NULL) {
                //get any image from photos and make it a main photo
                $PhotoMainImage = \App\Photo::where('pd_photo_id', $sanitized_pd_id)->get();
                //store the main Image
                \App\Product::where('pd_id', $sanitized_pd_id)->update([
                    'pd_photo' => $PhotoMainImage->first()->pd_filename,
                ]);
            }

            Session::flash('message', "Product Updated Successfully.");
            return redirect()->back();
        } else {
            return redirect("/");
        }
    }

    public function updateSpecs()
    {
        if (request()->ajax()) {

            //inserting into pre defined Specs
            if (!empty(request()->stringName) && !empty(request()->stringIds)) {
                $valid = request()->validate([
                    'id' => ['nullable', 'numeric'],
                    'stringIds' => ['nullable', 'string', 'max:255'],
                    'stringName' => ['nullable', 'string', 'max:255'],
                ]);

                $spec_option = explode(',', $valid['stringName']);
                $spec_parentIds = explode(',', $valid['stringIds']);

                for ($i = 0; $i < count($spec_option); $i++) {

                    \App\SpecOption::create([
                        'product_id' => $valid['id'],
                        'spec_parent_id' => $spec_parentIds[$i],
                        'spec_option_name' => $spec_option[$i],
                        'priority' => 2,



                    ]);
                }
            }

            //inserting into user defined Specs
            //inserting into specifications first and then get last insert id
            if (!empty(request()->specP) && !empty(request()->specC)) {
                $validate = request()->validate([
                    'id' => ['nullable', 'numeric'],
                    'sub' => ['nullable', 'numeric'],
                    'specP' => ['nullable', 'string', 'max:255'],
                    'specC' => ['nullable', 'string', 'max:255'],
                ]);
                $product = \App\Product::where('pd_id', $validate['id'])->get();

                $specParr = explode(',', $validate['specP']); //thres 2 here ['Judge', 'steve']
                $specCarr = explode(',', $validate['specC']); //thres 1 here ['judge']

                for ($i = 0; $i < count($specParr); $i++) {
                    if (!empty($specParr[$i]) && !empty($specCarr[$i]) && count($specParr) == count($specCarr)) {
                        for ($i = 0; $i < count($specCarr); $i++) {
                            //insert parent specification and get last id
                            $specParentId = DB::table('specifications')->insertGetId([
                                'spec_subCatid' => $validate['sub'],
                                'spec_name' => $specParr[$i],
                                'spec_parentCat_id' => null,
                                'priority' => 2,
                            ]);

                            //insert spec option
                            \App\SpecOption::create([
                                'product_id' => $validate['id'],
                                'spec_parent_id' => $specParentId,
                                'spec_option_name' => $specCarr[$i],
                            ]);
                        }
                    }
                }
            }
        }
    }



    public function deleteSpecs()
    {
        if (request()->ajax()) {

            //inserting into pre defined Specs
            if (!empty(request()->id)) {
                $valid = request()->validate([
                    'id' => ['nullable', 'numeric'],

                ]);

                $cats = \App\SpecOption::where('id', $valid['id'])->get();
                $specificationId = $cats->first()->spec_parent_id;
                \App\Specification::where('spec_id', $specificationId)->where('priority', 2)->delete();
                \App\SpecOption::where('id', $valid['id'])->delete();
            }
        }
    }



    public function showSpec()
    {

        if (request()->ajax()) {
            $data = request()->validate([
                'id' => ['numeric'],
            ]);
            //$spec_Parebt = \App\SpecOption::where('id', $data['id'])->get();
            $result = \App\SpecOption::where('id', $data['id'])->get(['id', 'spec_option_name', 'spec_parent_id']);
            return response::json($result);
        }
    }

    public function addSpec()
    {

        if (request()->ajax()) {
            $data = request()->validate([
                'id' => ['nullable', 'numeric'],
                'spec_option_name' =>  ['nullable', 'string', 'max:255'],
            ]);

            \App\SpecOption::where('id', $data['id'])->update([
                'spec_option_name' => $data['spec_option_name'],
                //    'priority' => 2,

            ]);
        }
    }



    public function deleteProductImg()
    {
        if (request()->ajax()) {
            $data = request()->validate([
                'id' => ['numeric']
            ]);

            $path = \App\Photo::where('id', $data['id'])->get();
            $paths = $path->first()->pd_filename; //pd_images\image.png

            $absolute = '\Users\Judge\freeCodeGram\public\storage' . "\\" . $paths;
           // $absolute = '\Users\Judge\freeCodeGram\public' . "\\" . $paths;
            if (file_exists($absolute)) {
                $success = unlink($absolute);

                if ($success) {
                    \App\Photo::where('id', $data['id'])->delete();
                }
            }

            /* $absolute = '\public' . "\\" . $paths;
            if (file_exists($absolute)) {
                $success = unlink($absolute);

                if ($success) {
                    \App\Photo::where('id', $data['id'])->delete();
                }
            }*/



            //check if the main photo is empty then update it
            $mainImage = \App\Product::where('pd_id', $path->first()->pd_photo_id)->get();
            //check ig the photo they want to delete is the main
            if ($mainImage->first()->pd_photo == $paths) {
                \App\Product::where('pd_id', $path->first()->pd_photo_id)->update([
                    'pd_photo' => NULL,
                ]);
            }
            return "No";
        }
    }

    //delete company images
    public function deleteCompanyImg()
    {
        if (request()->ajax()) {
            $data = request()->validate([
                'id' => ['numeric']
            ]);

            $path = \App\CompanyImages::where('id', $data['id'])->get();
            $paths = $path->first()->company_image; //pd_images\image.png

            //$absolute = '\Users\Judge\freeCodeGram\public\storage' . "\\" . $paths;
            $absolute = '\Users\Judge\freeCodeGram\public' . "\\" . $paths;
            if (file_exists($absolute)) {
                $success = unlink($absolute);

                if ($success) {
                    \App\CompanyImages::where('id', $data['id'])->delete();
                }
            }
        }
    }
    public function showProductDetails($product_id)
    {

        $decoded_product_id = base64_decode($product_id);
        $decoded_product_id =  trim($decoded_product_id);
        $sanitized_product_id = filter_var($decoded_product_id, FILTER_SANITIZE_NUMBER_INT);

        if (filter_var($sanitized_product_id, FILTER_VALIDATE_INT)) {

            $pCats = \App\productCategory::all();
            $subCats = \App\SubCategory::all();
            $lastCats = \App\lastCategory::all();
            $product = \App\Product::where('pd_id', $sanitized_product_id)->get();
            $count = count($product);


            foreach ($product as $pro) {

                $pd_id = $pro['pd_id'];
                $payment_tem = $pro['pd_payment_term'];
                $pd_u_id = $pro['pd_u_id'];
                $pd_category_id = $pro['pd_category_id'];
            }
            if ($count > 0 && $count < 2) {
                $user = \App\User::where('id', $pd_u_id)->get();
            } else {
                return redirect()->back();
            }
            $pd_images = \App\Photo::all();
            $cats = \App\SubCategory::where('id', $pd_category_id)->get();

            if (count($cats) > 0) {
                $parent = \App\productCategory::where('pc_id', $cats->first()->pc_id)->get();
            } else {
                return redirect()->back();
            }
            //join subcats with current product id
            $subcategory = DB::table('products')
                ->join('sub_categories', 'sub_categories.id', '=', 'products.pd_category_id')->where('sub_categories.id', $product->first()->pd_category_id)->get()->first();
            //join last_categories with current product id
            $last_categories = DB::table('products')
                ->join('last_categories', 'last_categories.id', '=', 'products.pd_subCategory_id')->where('last_categories.id', $product->first()->pd_subCategory_id)->get()->first();

            $you_may_like = DB::table('products')->take(8)->inRandomOrder()->get();
                if(Auth::check()){
                    $favs = \App\my_favorite::where('mf_u_id',Auth::user()->id)->get();
                    $countFavs = count($favs);
                    $fav = $favs->pluck('mf_pd_id'); 
                }
            $featured_images = \App\Photo::all(); 
            $payments = \App\PaymentTerms::all();
            $payment_t = explode(',', $payment_tem);
            $reviews = \App\Review::where(['pd_id' => $pd_id, 'status' => 1])->take(2)->get();
            $buyingRequests = \App\BuyingRequest::where('br_approval_status', 1)->get();
            $countBuyingRequest = count($buyingRequests);
            $specifications = \App\Specification::all();
            $spec_option = \App\SpecOption::where('product_id', $sanitized_product_id)->get();
            $export_capabilities = \App\ExportCapability::where('user_id', $product->first()->pd_u_id)->get();
            $export = count($export_capabilities);
            $company_images = \App\CompanyImages::where('user_id', $product->first()->pd_u_id)->get();
            $count_comp_img = count($company_images);
            $certificates = \App\CompanyCertificate::where('user_id', $product->first()->pd_u_id)->get();
            $count_certificates = count($certificates);
            $questions = \App\Questions::where('pd_id', $sanitized_product_id)->get();
            $answers = \App\Answers::all();
            if (Auth::check()) {
                $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
                $count = count($userMessages);

                return view('front.product-detail', compact('parent', 'pCats', 'subCats', 'lastCats',  'product', 'pd_images', 'featured_images', 'payments', 'payment_t', 'user', 'you_may_like', 'reviews', 'count', 'countBuyingRequest', 'spec_option', 'specifications', 'export', 'export_capabilities', 'company_images', 'certificates', 'count_certificates', 'subcategory', 'last_categories', 'fav', 'count_comp_img', 'questions', 'answers'));
            } else {
                return view('front.product-detail', compact('parent', 'pCats', 'subCats', 'lastCats',  'product', 'pd_images', 'featured_images', 'payments', 'payment_t', 'user', 'you_may_like', 'reviews', 'spec_option', 'specifications', 'export', 'export_capabilities', 'export', 'export_capabilities', 'company_images', 'certificates', 'count_certificates', 'subcategory', 'last_categories', 'count_comp_img', 'questions', 'answers'));
            }
        } else {
            return redirect("/");
        }
    }

    public function productAnalytics($product_id)
    {
        $decoded_product_id = base64_decode($product_id);
        $data = request()->validate([
            'product_id' => ['numeric'],

        ]);
        $product = \App\Product::where('pd_id', $decoded_product_id)->get();
        $pd_images = \App\Photo::where('pd_photo_id', $decoded_product_id)->get();

        $buyingRequests = \App\BuyingRequest::where('br_approval_status', 1)->get();
        $countBuyingRequest = count($buyingRequests);
        $user_details = \App\User::where('id', Auth::user()->id)->get();
        Session::put('account', $user_details->first()->account_type);
        $notifications = \App\Notifications::where('user_id', Auth::user()->id)->get();
        $countNotifications = count($notifications);
        Session::put('notifications', $notifications);
        Session::put('count_notifications', $countNotifications);
        $result = \App\Review::where(['pd_id' => $decoded_product_id, 'status' => 1])->get();
        if (Auth::check()) {
            $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
            $count = count($userMessages);
            Session::put('user_messages', $userMessages);
            Session::put('user_messages_count', $count);
            return view('admin.product-analytics', compact('pd_images', 'count', 'countBuyingRequest', 'product', 'result'));
        } else {

            return view('admin.product-analytics', compact('product', 'pd_images'));
        }
    }
}
