<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Auth;

class SupplierController extends Controller
{



    public function show($supplier_id)
    {
        $decoded_supplier_id = base64_decode($supplier_id);
        $decoded_supplier_id = trim($decoded_supplier_id);
        $sanitized_id = filter_var($decoded_supplier_id, FILTER_SANITIZE_NUMBER_INT);
        if (filter_var($sanitized_id, FILTER_VALIDATE_INT)) {
            $parent_category = \App\productCategory::all();
            $pCats = \App\productCategory::all();
            $subCats = \App\SubCategory::all();
            $lastCats = \App\lastCategory::all();
            $supplier = \App\User::findOrfail($sanitized_id);
            $products = \App\Product::where('pd_u_id', $sanitized_id)->simplePaginate(6);
            $buyingRequests = \App\BuyingRequest::where('br_approval_status', 1)->get();
            $company_images = \App\CompanyImages::where('user_id', $sanitized_id)->get();
            $export_capabilities = \App\ExportCapability::where('user_id', $sanitized_id)->get();
            $certificates = \App\CompanyCertificate::where('user_id', $sanitized_id)->get();
            $count_certificates = count($certificates);
            $count_comp_img = count($company_images);
            $export = count($export_capabilities);
            $pd_images = \App\Photo::all();
            $countBuyingRequest = count($buyingRequests);
                 if(Auth::check()){
                    $favs = \App\my_favorite::where('mf_u_id',Auth::user()->id)->get();
                    $countFavs = count($favs);
                    $fav = $favs->pluck('mf_pd_id'); 
                }
            if (Auth::check()) {
            $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
                $count = count($userMessages);
                return view('front.supplier', compact('pCats', 'subCats', 'lastCats', 'parent_category', 'supplier', 'count', 'countBuyingRequest', 'products', 'company_images', 'count_comp_img', 'export','fav', 'export_capabilities', 'pd_images', 'certificates', 'count_certificates'));
            } else {

                return view('front.supplier', compact('pCats', 'subCats', 'lastCats', 'parent_category', 'supplier', 'products', 'company_images', 'count_comp_img', 'export', 'export_capabilities', 'pd_images', 'certificates', 'count_certificates'));
            }
        } else {
            return redirect("home");
        }
    }
    //
    public function create($product_id, $supplier_id)
    {
        $decoded_supplier_id = base64_decode($supplier_id);
        $decoded_supplier_id = trim($decoded_supplier_id);
        $decoded_product_id = base64_decode($product_id);
        $decoded_product_id = trim($decoded_product_id);
        $sanitized_supplier_id = filter_var($decoded_supplier_id, FILTER_SANITIZE_NUMBER_INT);
        $sanitized_product_id = filter_var($decoded_product_id, FILTER_SANITIZE_NUMBER_INT);
        if (filter_var($sanitized_supplier_id, FILTER_VALIDATE_INT) && filter_var($sanitized_product_id, FILTER_VALIDATE_INT)) {
            $parent_category = \App\productCategory::all();
            $pCats = \App\productCategory::all();
            $subCats = \App\SubCategory::all();
            $lastCats = \App\lastCategory::all();
            $measurementUnits = \App\MeasurementUnit::all();
            $supplier = \App\User::findOrfail($sanitized_supplier_id);
            $product = \App\Product::where('pd_id', $sanitized_product_id);
            $pd_images = \App\Photo::where('pd_photo_id', $sanitized_product_id);
            $buyingRequests = \App\BuyingRequest::where('br_approval_status', 1)->get();
            $countBuyingRequest = count($buyingRequests);
            if (Auth::check()) {
                $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
                $count = count($userMessages);
                return view('front.contact-supplier', compact('pCats', 'subCats', 'lastCats', 'parent_category', 'supplier', 'product', 'measurementUnits', 'pd_images', 'count', 'countBuyingRequest'));
            } else {

                return view('front.contact-supplier', compact('pCats', 'subCats', 'lastCats', 'parent_category', 'supplier', 'product', 'measurementUnits', 'pd_images'));
            }
        } else {
            return redirect("home");
        }
    }
    public function store(Request $request)
    {

        $data = request()->validate([
            'msg_from_id' => ['numeric'],
            'msg_to_id' => ['numeric'],
            'subject' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric'],
            'quantityUnit' => ['required', 'string', 'max:255'],
            'quantity' => ['required', 'numeric'],
            'message' => ['required', 'string', 'max:255'],

        ]);


        \App\Message::create([
            'msg_from_id' => trim($data['msg_from_id']),
            'msg_to_id' => trim($data['msg_to_id']),
            'msg_subject' => trim($data['subject']),
            'msg_body' => trim($data['message']),
            'price' => trim($data['price']),
            'quantity_unit' => trim($data['quantityUnit']),
            'quantity' => trim($data['quantity']),


        ]);


        Session::flash('Contact_Supplier', "Message Was Sent Successfully.");
        return redirect()->back();
    }

    public function showAll()
    {

        $parent_category = \App\productCategory::all();
        $pCats = \App\productCategory::all();
        $subCats = \App\SubCategory::all();
        $lastCats = \App\lastCategory::all();
        $suppliers = \App\User::where('account_type', 'Supplier')->orderBy('status', 'desc')->get();
        $buyingRequests = \App\BuyingRequest::where('br_approval_status', 1)->get();
        $countBuyingRequest = count($buyingRequests);
        if (Auth::check()) {
            $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
            $count = count($userMessages);
            return view('front.suppliers', compact('pCats', 'subCats', 'lastCats', 'parent_category', 'suppliers', 'count', 'countBuyingRequest'));
        } else {

            return view('front.suppliers', compact('pCats', 'subCats', 'lastCats', 'parent_category', 'suppliers'));
        }
    }
}
