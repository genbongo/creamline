<?php

namespace App\Http\Controllers;

use App\ProductFileReport;
use App\Product_Report;
use App\ReplacementProduct;
use App\Traits\GlobalFunction;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class OrderReplacementController extends Controller
{
    use GlobalFunction;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::user()->user_role == 99) {
            $file_replacement = Product_Report::all();
        } else {
            $file_replacement = Product_Report::where('client_id', Auth::user()->id)
                                    ->get();            
        }
        if ($request->ajax()) {
            return Datatables::of($file_replacement)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    if ($row->delivery_date != "0000-00-00") {
                        return null;
                    }
                    if ($row->is_replaced == 1) {
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Replace Order" data-id="'.$row->id.'" data-clientid="'.$row->client_id.'" data-original-title="Edit" class="btn btn-success btn-sm setDeliver">Set Delivery</a>&nbsp;';
                    } else {
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Replace Order" data-id="'.$row->id.'" data-clientid="'.$row->client_id.'" data-original-title="Edit" class="btn btn-primary btn-sm editReplacementOrder">Approve</a>&nbsp;';
                        $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Disapprove Replacement" data-id="'.$row->id.'" data-clientid="'.$row->client_id.'" data-original-title="Edit" class="btn btn-danger btn-sm editDisapproveReplacement">Disapprove</a>';
                    }
                    return $btn;
                })
                ->addColumn('client', function($row){
                    return $row->client;
                })
                ->addColumn('status', function($row){
                  return $row->is_replaced;
                })
                ->addColumn('products', function($row) {
                    return $row->products;
                })
                ->addColumn('quantity', function($row) {
                   $total = 0;
                   foreach ($row->products as $value) {
                     $total += $value->quantity;
                   }
                    return $total;
                })
                ->addColumn('images', function($row) {
                    return $row->images;
                })
                ->rawColumns(['status','products','quantity', 'images', 'action'])
                ->make(true);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //store the action
        $action = $request->input("action");

        switch($action){
            //if approve replacement request button is clicked
            case "approve_replacement":
                Product_Report::where('id', $request->input("reportid"))
                                    ->update(["is_replaced" => 1]);
                
                //set message
                $message = 'Your Replacement request # '.$request->input("reportid").' has been accepted. Please be advised accordingly';

                //call the global function for setting the notification
                $this->set_notification("approved_customer_order", $message, $request->input("clientid"));

                return response()->json([
                    'message' => "Order Replacement Approved!",
                ]);
                break;
            case "disapprove_replacement":
                Product_Report::where('id', $request->input("reportid"))->update(["is_replaced" => 2]);
                
                //set message
                $message = 'Your Replacement request # '.$request->input("reportid").' has been disapproved. Please be advised accordingly';

                //call the global function for setting the notification
                $this->set_notification("approved_customer_order", $message, $request->input("clientid"));
                
                return response()->json([
                    'message' => "Order Replacement Disapproved!",
                ]);
                break;
            default:
                echo "do nothing here....";
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product_Report  $file_replacement
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product_report = Product_Report::find($id);
        $product_file_report = ProductFileReport::where('product_report_id', $id)->get();
        
        $data = [
          'product_report' => $product_report,
          'product_file_report' => $product_file_report
        ];

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product_Report  $file_replacement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product_Report $prod_report)
    {
        //do nothing...........
    }

    public function setDeliveryDate(Request $request)
    {
        $deliveryDate = $request->txt_replacement_delivery_date;
        $fileReport = Product_Report::find($request->id);
        $fileReport->delivery_date = $deliveryDate;
        $fileReport->save();

        $clientReport = ProductFileReport::where('product_report_id', '=', $fileReport->id)->first();
        $clientReport->delivery_date = $deliveryDate;

        return response()->json([
            'message' => "Delivery Date Set!",
        ]);
    }

    public function updateProducts(Request $request)
    {
        $products = json_decode($request->props);

        foreach ($products as $product) {
            $prd = ReplacementProduct::find($product->id);
            $prd->quantity = $product->value;
            $prd->save();
        }

        return response()->json('Success');
    }
}
