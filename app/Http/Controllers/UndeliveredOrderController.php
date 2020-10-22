<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DataTables;
use App\Traits\GlobalFunction;

class UndeliveredOrderController extends Controller
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
        $undeliver = DB::table('orders')
                ->join('products', 'orders.product_id', '=', 'products.id')
                ->join('users', 'orders.client_id', '=', 'users.id')
                ->select('products.name', 'products.product_image', 'orders.quantity_ordered',
                    'orders.ordered_total_price', 'orders.created_at', 'orders.is_approved', 'orders.is_completed', 'orders.is_cancelled', 'orders.delivery_date', 'orders.id', 'users.fname', 'users.lname', 'users.contact_num', 'orders.attempt', 'orders.reason')
                ->where('is_cancelled', 1)
                ->get();

        if ($request->ajax()) {
            return Datatables::of($undeliver)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
   
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Update Order" data-id="'.$row->id.'" data-num="'.$row->contact_num.'" data-prodname="'.$row->name.'" data-qty="'.$row->quantity_ordered.'"  data-total="'.$row->ordered_total_price.'" data-original-title="Edit" class="btn btn-primary btn-sm editReschedOrder">Reschedule</a>';

                     return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return json_encode($undeliver);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order_id = $request->input("resched_order_id");
        $amount = $request->input("resched_amount");
        $date_to_display = $request->input("resched_date_to_display");
        $txt_resched_delivery_date = $request->input("txt_resched_delivery_date");
        $contact_num = $request->input("resched_contact");
        // $contact_num = '09232415169';

        $text_message = 'We\'re sorry for the inconvenience. Your Order # '.$order_id.' has been rescheduled to '.$date_to_display.' with purchase amount of PHP '.$amount.'. Thank you for choosing Creamline Products.';

        DB::table('orders')->where('id', $order_id)->update(['is_rescheduled' => 1]);
        DB::table('orders')->where('id', $order_id)->update(['is_cancelled' => 0]);
        DB::table('orders')->where('id', $order_id)->update([ 'attempt' => DB::raw('attempt + 1')]);
        
        // $result = $this->global_itexmo($contact_num, $text_message." \n\n\n\n","ST-CREAM343228_LGZPB", "#5pcg2mpi]");
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
