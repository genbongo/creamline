<?php

namespace App\Http\Controllers;

use App\Order;
use App\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DataTables;
use App\Traits\GlobalFunction;

class OrderController extends Controller
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
        $pending = DB::table('orders')
                ->join('products', 'orders.product_id', '=', 'products.id')
                ->join('users', 'orders.client_id', '=', 'users.id')
                ->select('products.id AS prodID', 'products.name', 'products.product_image', 'orders.quantity_ordered',
                    'orders.ordered_total_price', 'orders.created_at', 'orders.is_approved', 'orders.is_completed', 'orders.delivery_date', 'orders.id', 'users.fname', 'users.lname', 'users.contact_num', 'orders.client_id')
                ->where('is_approved', 0)
                ->get();

        if ($request->ajax()) {
            return Datatables::of($pending)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
   
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Update Order" data-id="'.$row->id.'" data-prodid="'.$row->prodID.'" data-num="'.$row->contact_num.'" data-prodname="'.$row->name.'" data-qty="'.$row->quantity_ordered.'"  data-total="'.$row->ordered_total_price.'"  data-client="'.$row->client_id.'" data-original-title="Edit" class="btn btn-primary btn-sm editPendingOrder">Approve</a>';

                     return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('order.order', compact('pending'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $order_id = $request->input("pending_order_id");
        $product_id = $request->input("pending_product_id");
        $product_qty = $request->input("pending_product_qty");
        $amount = $request->input("pending_amount");
        $date_to_display = $request->input("pending_date_to_display");
        $delivery_date = $request->input("delivery_date");
        $contact_num = $request->input("pending_contact");
        $client_id = $request->input("pending_client_id");
        // $contact_num = '09232415169';

        $text_message = 'Thank you for ordering Creamline Products. Your Order # '.$order_id.' has been accepted. Total amount purchased of PHP '.$amount.'. Please expect it to be delivered on '.$date_to_display.'.';

        if(env("DB_CONNECTION") == "pgsql"){
            $current_quantity = DB::table('stocks')
                ->where('id', $product_id)
                ->select('*')
                ->get();

            $deducted_qty = intval($current_quantity[0]->quantity) - intval($product_qty);

            Stock::where('id', $product_id)->update([ 'quantity' => $deducted_qty]);
        }else{
            Stock::where('id', $product_id)->update([ 'quantity' => DB::raw('quantity - "'.$product_qty.'"')]);
        }
        Order::where('id', $order_id)->update(['is_approved' => 1]);
        Order::where('id', $order_id)->update(['delivery_date' => $delivery_date]);

        //call the global function for setting the notification
        $this->set_notification("approved_customer_order", $text_message, $client_id);
        
        // $result = $this->global_itexmo($contact_num, $text_message." \n\n\n\n","ST-CAPST343228_559B2", "twy{ccd#)4");
        $result = $this->global_itexmo($contact_num, $text_message." \n\n\n\n","ST-CREAM343228_LGZPB", '#5pcg2mpi]');
        if ($result == ""){
            // echo "iTexMo: No response from server!!!
            // Please check the METHOD used (CURL or CURL-LESS). If you are using CURL then try CURL-LESS and vice versa.   
            // Please CONTACT US for help. ";   
        }else if ($result == 0){
            // echo "Message Sent!";
        }
        else{    
            // echo "Error Num ". $result . " was encountered!";
        }

        // return response
        $response = [
            'success' => true,
            'message' => 'Order successfully approved.',
        ];
        return response()->json($response, 200);

    }
}
