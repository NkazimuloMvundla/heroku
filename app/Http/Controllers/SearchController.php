<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use DB;
use Auth;

class SearchController extends Controller
{
    function index()
    {
        return view('front.Index');
    }
    public function livesearch(Request $request)
    {
        $term = $request->get('query');
        $count = DB::table('products')->where("pd_name", "LIKE", "%$term%")->orderBy('pd_name')->get();
        $res = count($count);
        if (!empty($term) && $res > 0) {
            $data = DB::table('products')->where("pd_name", "LIKE", "%$term%")->where('pd_approval_status', 1)->get();

            $output = '<ul class="dropdown-menu" id="liveSearch" style="display:block;position:obsolute">';
            foreach ($data as $row) {

                $output .= '<li id="pd_search"><a href="/search/' . htmlspecialchars($row->pd_name) . '">' . htmlspecialchars($row->pd_name) . '</a></li>';
            }
            $output .= '</ul>';

            return response($output);
        }


        /*	foreach($data as $row)
		{
		   $results[] = ['value'=> $row->pd_nameli];
		}

		return response()->json($results);

		*/
    }

    /*public function AjaxSearch()
    {

        if (request()->ajax()) {

            $data = request()->validate([
                'query' => ['string', 'max:255'],
            ]);
            $query  = $data['query'];
            $products = DB::table('products')->where("pd_name", "LIKE", "%$query%")->where('pd_approval_status', 1)->get();
            var_dump($products);
            //   dd($products);
            $pCats = \App\productCategory::all();
            $subCats = \App\SubCategory::all();
            $lastCats = \App\lastCategory::all();
            $pd_images = \App\Photo::all();
            $buyingRequests = \App\BuyingRequest::all();
            $countBuyingRequest = count($buyingRequests);
            if (Auth::check()) {
                $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
                $count = count($userMessages);
                return view('front.search',  compact('pCats', 'subCats', 'lastCats', 'products', 'pd_images', 'count', 'countBuyingRequest'));
            } else {

                return view('front.search',  compact('pCats', 'subCats', 'lastCats', 'products', 'pd_images'));
            }
        }
        dd($products);
    }
    */
    public function search($pd_name)
    {

        $products = DB::table('products')->where("pd_name", "LIKE", "%$pd_name%")->where('pd_approval_status', 1)->get();

        foreach ($products as $key) {
            if ($key->pd_subCategory_id == $products->first()->pd_subCategory_id) {
                break;
                //var_dump($key->pd_subCategory_id);
            }
        }

        $Productcount = count($products);
        $pCats = \App\productCategory::all();
        $subCats = \App\SubCategory::all();
        $lastCats = \App\lastCategory::all();
        $pd_images = \App\Photo::all();
        $buyingRequests = \App\BuyingRequest::all();
        $countBuyingRequest = count($buyingRequests);
        if (Auth::check()) {
            $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
            $count = count($userMessages);

            //return related sub_categories for the searched term
            //$lastCat = \App\lastCategory::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();

            return view('front.search',  compact('Productcount', 'pd_name', 'pCats', 'subCats', 'lastCats', 'products', 'pd_images', 'count', 'countBuyingRequest'));
        } else {

            return view('front.search',  compact('Productcount', 'pd_name', 'pCats', 'subCats', 'lastCats', 'products', 'pd_images'));
        }
    }

    public function formsearch()
    {
        if (empty(request()->search)) {
            return redirect()->back();
        }
        $data = request()->validate([
            'search' => ['string', 'max:255'],
        ]);
        $pd_name  = $data['search'];


        $products = DB::table('products')->where("pd_name", "LIKE", "%$pd_name%")->where('pd_approval_status', 1)->get();
        $Productcount = count($products);

        $you_may_like = \App\Product::take(8)->where('pd_approval_status', 1)->inRandomOrder()->get();
        $pCats = \App\productCategory::all();
        $subCats = \App\SubCategory::all();
        $lastCats = \App\lastCategory::all();
        $pd_images = \App\Photo::all();
        $buyingRequests = \App\BuyingRequest::all();
        $countBuyingRequest = count($buyingRequests);
        if (Auth::check()) {
            $userMessages = \App\Message::where(['msg_to_id' => Auth::user()->id, 'msg_read' => 0])->get();
            $count = count($userMessages);
            return view('front.search',  compact('you_may_like', 'Productcount', 'pd_name', 'pCats', 'subCats', 'lastCats', 'products', 'pd_images', 'count', 'countBuyingRequest'));
        } else {

            return view('front.search',  compact('you_may_like', 'Productcount', 'pd_name', 'pCats', 'subCats', 'lastCats', 'products', 'pd_images'));
        }
    }

    // Admin email search

    public function AdminEmailSearch(Request $request)
    {
        if ($request->ajax() && $request->get('query') != '') {
            $output = '';
            $search = request()->validate([
                'query' => ['string', 'max:255'],
            ]);

            $query = $search['query'];

            $data = DB::table('messages')
                ->where('msg_subject', 'like', '%' . $query . '%')->where('msg_to_id', Auth::user()->id)
                //    ->orWhere(['msg_body', 'like', '%'.$query.'%' , 'id' => Auth::user()->id])
                ->orderBy('id', 'desc')
                ->get();

            $total_row = $data->count();
            if ($total_row > 0) {
                $output .= '
       <div>
       <thead>
       <tr>
       <th>From : </th>
       <th>Subject : </th>
       <th>Date : </th>
       </tr>
       </thead>
       </div>

       ';


                foreach ($data as $row) {
                    $user = \App\User::where('id', $row->msg_from_id)->get();

                    $output .= '

        <tr class="success">

         <td style="padding:9px;">' . htmlspecialchars($user->first()->company_name) . '</td>
         <td style="padding:9px;"><a href="/admin/mailbox/inbox/read/' . htmlspecialchars($row->id) . '" onclick="updateStatus(' . htmlspecialchars($row->id) . ');">' . htmlspecialchars($row->msg_subject) . '</a></td>
         <td style="padding:9px;">' . htmlspecialchars($row->created_at) . '</td>
        </tr>
        ';
                }
            } else {
                $output = '
       <tr>
        <td align="center" colspan="5">No Data Found</td>
       </tr>
       ';
            }
            $data = array(
                'table_data'  => $output,
                'total_data'  => $total_row
            );

            echo json_encode($data);
        }
    }


    public function AdminAllEmailSearch(Request $request)
    {
        if ($request->ajax() && $request->get('query') != '') {
            $output = '';
            $search = request()->validate([
                'query' => ['string', 'max:255'],
            ]);

            $query = $search['query'];

            $data = DB::table('messages')
                ->where('msg_subject', 'like', '%' . $query . '%')->where('msg_to_id', Auth::user()->id)->where('msg_read', 1)
                //    ->orWhere(['msg_body', 'like', '%'.$query.'%' , 'id' => Auth::user()->id])
                ->orderBy('id', 'desc')
                ->get();

            $total_row = $data->count();
            if ($total_row > 0) {
                $output .= '
       <div>
       <thead>
       <tr>
       <th>From : </th>
       <th>Subject : </th>
       <th>Date : </th>
       </tr>
       </thead>
       </div>

       ';


                foreach ($data as $row) {
                    $user = \App\User::where('id', $row->msg_from_id)->get();

                    $output .= '

        <tr class="success">

         <td style="padding:9px;">' . htmlspecialchars($user->first()->company_name) . '</td>
         <td style="padding:9px;"><a href="/admin/mailbox/inbox/read/' . htmlspecialchars($row->id) . '" onclick="updateStatus(' . htmlspecialchars($row->id) . ');">' . htmlspecialchars($row->msg_subject) . '</a></td>
         <td style="padding:9px;">' . htmlspecialchars($row->created_at) . '</td>
        </tr>
        ';
                }
            } else {
                $output = '
       <tr>
        <td align="center" colspan="5">No Data Found</td>
       </tr>
       ';
            }
            $data = array(
                'table_data'  => $output,
                'total_data'  => $total_row
            );

            echo json_encode($data);
        }
    }


    public  function AdminSentEmailSearch(Request $request)
    {
        if ($request->ajax() && $request->get('query') != '') {
            $output = '';
            $search = request()->validate([
                'query' => ['string', 'max:255'],
            ]);

            $query = $search['query'];

            $data = DB::table('messages')
                ->where('msg_subject', 'like', '%' . $query . '%')->where('msg_from_id', Auth::user()->id)
                //    ->orWhere(['msg_body', 'like', '%'.$query.'%' , 'id' => Auth::user()->id])
                ->orderBy('id', 'desc')
                ->get();

            $total_row = $data->count();
            if ($total_row > 0) {
                $output .= '
        <div >
        <thead>
        <tr>
        <th>To : </th>
        <th>Subject : </th>
        <th>Date : </th>
        </tr>
        </thead>
        </div> ';

                foreach ($data as $row) {
                    $user = \App\User::where('id', $row->msg_to_id)->get();

                    $output .= '

        <tr class="success">

         <td style="padding:9px;">' . htmlspecialchars($user->first()->company_name) . '</td>
         <td style="padding:9px;"><a href="/admin/mailbox/inbox/read/' . htmlspecialchars($row->id) . '">' . htmlspecialchars($row->msg_subject) . '</a></td>
         <td style="padding:9px;">' . htmlspecialchars($row->created_at) . '</td>
        </tr>
        ';
                }
            } else {
                $output = '
       <tr>
        <td align="center" colspan="5">No Data Found</td>
       </tr>
       ';
            }
            $data = array(
                'table_data'  => $output,
                'total_data'  => $total_row
            );

            echo json_encode($data);
        }
    }
}
