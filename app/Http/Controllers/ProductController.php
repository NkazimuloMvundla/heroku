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
        $buyingRequests = \App\BuyingRequest::all();
        $countBuyingRequest = count($buyingRequests);
        $user_details = \App\User::where('id', Auth::user()->id)->get();
        Session::put('account', $user_details->first()->account_type);
        if (Auth::check()) {
            $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
            $count = count($userMessages);

            return view('admin.add-new-product', compact('pCats', 'subCats', 'lastCats', 'parent_category', 'measurementUnits', 'paymentTerms', 'count', 'countBuyingRequest'));
        } else {

            return view('admin.add-new-product', compact('pCats', 'subCats', 'lastCats', 'parent_category', 'measurementUnits', 'paymentTerms'));
        }
    }

    public function store(Request $request)
    {


        $data = request()->validate([
            // 'u_id' => ['numeric'],
            'mainCategory' => ['required', 'numeric'],
            'Category' => ['required', 'numeric'],
            'subCategory' => ['required', 'numeric'],
            'Product_Name' => ['required', 'string', 'max:255'],
            'Product_Keyword' => ['required', 'string', 'max:255'],
            'file' => ['required', new PhotoMaxUpload],
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




        $id = DB::table('products')->insertGetId([
            'pd_u_id' => Auth::user()->id,
            'pd_subCategory_id' => $data['subCategory'],
            'pd_category_id' => $data['Category'],
            'pd_name' => $data['Product_Name'],
            'pd_keyword' => $data['Product_Keyword'],
            'pd_listing_description' => $data['listing_description'],
            'pd_min_order_qty' => $data['Minimum_Order_Quantity'],
            'minOrderUnit' => $data['Minimum_order_unit'],
            'min_price' => $data['Min_price'],
            'max_price' => $data['Max_price'],
            'fob_mu_id' => $data['Minimum_unit'],
            'port' => $data['Port'],
            'pd_payment_term' => $data['paymentMethod'],
            'capacity' => $data['supplyQuantity'],
            'pd_supply_ability' => $data['supplyUnit'],
            'supplyPeriod' => $data['supplyPeriod'],
            'pd_delivery_time' => $data['deliveryTime'],


        ]);


        foreach (request()->file('file') as $file) {

            $imgPath = $file->store('pd_images', 'public');

            \App\Photo::create([
                'pd_photo_id' => $id,
                'pd_u_id' => Auth::user()->id,
                'pd_filename' => $imgPath,
                'pd_priority' => 1,

            ]);
        }

        //inserting into pre defined Specs
        if (!empty(request()->stringName) && !empty(request()->stringIds)) {
            $valid = request()->validate([

                'stringIds' => ['nullable', 'string', 'max:255'],
                'stringName' => ['nullable', 'string', 'max:255'],
            ]);

            $spec_option = explode(',', $valid['stringName']);
            $spec_parentIds = explode(',', $valid['stringIds']);

            for ($i = 0; $i < count($spec_option); $i++) {

                \App\SpecOption::create([
                    'product_id' => $id,
                    'spec_parent_id' => $spec_parentIds[$i],
                    'spec_option_name' => $spec_option[$i],


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
                            'spec_subCatid' => $data['subCategory'],
                            'spec_name' => $specParr[$i],
                            'spec_parentCat_id' => $data['mainCategory'],
                        ]);

                        //insert spec option
                        \App\SpecOption::create([
                            'product_id' => $id,
                            'spec_parent_id' => $specParentId,
                            'spec_option_name' => $specCarr[$i],
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
        $parent_category = \App\productCategory::all();
        $measurementUnits = \App\MeasurementUnit::all();
        $paymentTerms = \App\PaymentTerms::all();

        $data = request()->validate([
            'product_id' => ['numeric'],

        ]);
        $product = \App\Product::where('pd_id', $decoded_product_id)->get();
        $pd_images = \App\Photo::where('pd_photo_id', $decoded_product_id)->get();

        $buyingRequests = \App\BuyingRequest::all();
        $countBuyingRequest = count($buyingRequests);
        $specifications = \App\Specification::all();
        $spec_option = \App\SpecOption::where('product_id', $decoded_product_id)->get();
        $user_details = \App\User::where('id', Auth::user()->id)->get();
        Session::put('account', $user_details->first()->account_type);
        if (Auth::check()) {
            $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
            $count = count($userMessages);
            return view('admin.product-edit', compact('parent_category', 'specifications', 'spec_option', 'measurementUnits', 'paymentTerms', 'product', 'pd_images', 'count', 'countBuyingRequest'));
        } else {


            return view('admin.product-edit', compact('specifications', 'spec_option', 'measurementUnits', 'paymentTerms', 'product', 'pd_images'));
        }
    }


    public function update($product_id)
    {
        $decoded_product_id = base64_decode($product_id);
        $data = request()->validate([
            'Product_Name' => ['required', 'string', 'max:255'],
            'Product_Keyword' => ['required', 'string', 'max:255'],
            //  'Product_photo' => ['required', new PhotoMaxUpload],
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

        Product::where('pd_id', $decoded_product_id)->update([
            'pd_name' => $data['Product_Name'],
            'pd_keyword' => $data['Product_Keyword'],
            'pd_listing_description' => $data['listing_description'],
            'pd_min_order_qty' => $data['Minimum_Order_Quantity'],
            'minOrderUnit' => $data['Minimum_order_unit'],
            'min_price' => $data['Min_price'],
            'max_price' => $data['Max_price'],
            'fob_mu_id' => $data['Minimum_unit'],
            'port' => $data['Port'],
            'pd_payment_term' => $payment,
            'capacity' => $data['supplyQuantity'],
            'pd_supply_ability' => $data['supplyUnit'],
            'supplyPeriod' => $data['supplyPeriod'],
            'pd_delivery_time' => $data['deliveryTime'],
            'pd_approval_status' => 0,

        ]);

        //check how many images already exist in the DB with the same ID
        $images = \App\Photo::where('pd_photo_id', $decoded_product_id)->get();
        $countImgs = count($images);
        //IF THERE'S NO IMAGES IN THE DB
        if ($countImgs < 1) {
            request()->validate([
                'Product_photo' => ['required', new PhotoMaxUpload, 'image'],
            ]);
            //IF THERE'S 2 IMAGES IN THE DB, A USER CANT UPLOAD MORE THAN 1 SINCE LIMIT IS 3
        } else if ($countImgs == 2) {
            request()->validate([
                'Product_photo' => [new PhotoMaxUpload, new PhotoEditMaxUpload, 'image'],
            ]);
            //IF THERE'S 3 IMAGES IN THE DB, A USER CANT UPLOAD ANY PHOTO AT ALL SINCE LIMIT IS 3
        } else if ($countImgs == 3) {
            request()->validate([
                'Product_photo' => [new PhotoEditEqualToThree, 'image'],
            ]);
        }
        //IF THERE'S 1 IMAGE IN THE DB, A USER CANT UPLOAD MORE THAN 2 SINCE LIMIT IS 3
        else if ($countImgs == 1) {
            request()->validate([
                'Product_photo' =>  [new PhotoMaxUpload, new PhotoEditEqualToOne, 'image'],
            ]);
        }
        //IF THERE'S NO IMAGES IN THE DB, A USER CANT UPLOAD MORE THAN 3 SINCE LIMIT IS 3
        else {
            request()->validate([
                'Product_photo' => [new PhotoMaxUpload, 'image'],
            ]);
        }
        if (request()->has('Product_photo') && !empty(request()->Product_photo)) {
            $i = 1;
            foreach (request()->file('Product_photo') as $file) {

                $imgPath = $file->store('pd_images', 'public');

                \App\Photo::create([
                    'pd_photo_id' => $decoded_product_id,
                    'pd_u_id' => Auth::user()->id,
                    'pd_filename' => $imgPath,
                    'pd_priority' => $i++,
                ]);
            }
        }



        Session::flash('message', "Product Updated Successfully.");
        return redirect()->back();
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
                // $countP = count($specParr);
                // $countC = count($specCarr);


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
                'priority' => 2,

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
            if (file_exists($absolute)) {
                $success = unlink($absolute);

                if ($success) {
                    \App\Photo::where('id', $data['id'])->delete();
                }
            }
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

            $absolute = '\Users\Judge\freeCodeGram\public\storage' . "\\" . $paths;
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
        $pCats = \App\productCategory::all();
        $subCats = \App\SubCategory::all();
        $lastCats = \App\lastCategory::all();

        $product = \App\Product::where('pd_id', $decoded_product_id)->get();

        $count = count($product);


        $you_may_like = \App\Product::take(8)->where(['pd_approval_status' => 1])->inRandomOrder()->get();

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
        $featured_images = \App\Photo::all();

        $payments = \App\PaymentTerms::all();
        $payment_t = explode(',', $payment_tem);
        $reviews = \App\Review::where(['pd_id' => $pd_id, 'status' => 1])->take(2)->get();

        $buyingRequests = \App\BuyingRequest::all();
        $countBuyingRequest = count($buyingRequests);
        $specifications = \App\Specification::all();
        $spec_option = \App\SpecOption::where('product_id', $decoded_product_id)->get();
        if (Auth::check()) {
        }
        $export_capabilities = \App\ExportCapability::where('user_id', $product->first()->pd_u_id)->get();
        $export = count($export_capabilities);
        $company_images = \App\CompanyImages::where('user_id', $product->first()->pd_u_id)->get();
        $certificates = \App\CompanyCertificate::where('user_id', $product->first()->pd_u_id)->get();
        $count_certificates = count($certificates);
        if (Auth::check()) {
            $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
            $count = count($userMessages);

            return view('front.product-detail', compact('parent', 'pCats', 'subCats', 'lastCats',  'product', 'pd_images', 'featured_images', 'payments', 'payment_t', 'user', 'you_may_like', 'reviews', 'count', 'countBuyingRequest', 'spec_option', 'specifications', 'export', 'export_capabilities', 'company_images', 'certificates', 'count_certificates'));
        } else {


            return view('front.product-detail', compact('parent', 'pCats', 'subCats', 'lastCats',  'product', 'pd_images', 'featured_images', 'payments', 'payment_t', 'user', 'you_may_like', 'reviews', 'spec_option', 'specifications', 'export', 'export_capabilities', 'export', 'export_capabilities', 'company_images', 'certificates', 'count_certificates'));
        }
    }
}
