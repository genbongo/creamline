<?php

namespace App\Http\Controllers;

use App\Order;
use App\Traits\GlobalFunction;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class StaffDashboardController extends Controller
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

        $area = auth()->user()->area;

        $now = date('Y-m-d');

        $order =  $area->orders()->where('delivery_date', '=', $now)->get();

        if ($request->ajax()) {
            return Datatables::of($order)
                ->addIndexColumn()
                ->addColumn('name', function($row) {
                    return $row->client->fname. " " . $row->client->lname;
                })
                ->addColumn('store_name', function($row) {
                    return $row->store->store_name;
                })
                ->addColumn('store_address', function($row) {
                    return $row->store->store_address;
                })
                ->addColumn('action', function ($row) {

                    if (!$row->is_completed && !$row->is_cancelled) {
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Mark this order as completed" data-id="'.$row->id.'" class="btn btn-primary btn-sm editCompleteOrder">Completed</a>&nbsp;';

                        $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Mark this order as cancelled" data-id="'.$row->id.'" class="btn btn-danger btn-sm editCancelOrder">Cancel</a>';

                         return $btn;
                     } else {
                        return null;
                     }
   
                })
                ->addColumn('status', function($row) {
                    if ($row->is_completed) {
                        return '<span class="text-success font-weight-bold">Completed</span>';
                    }

                    if ($row->is_cancelled) {
                        return '<span class="text-danger font-weight-bold">Cancelled</span>';
                    }
                })
                ->rawColumns(['action', 'store_name', 'store_address', 'name', 'status'])
                ->make(true);
        }

        return view('staff.dashboard', compact('order'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //if completed
        if($request->input("action") == "completed"){

            //update the order
            DB::table('orders')->where('id', $request->input("order_id"))->update(['is_completed' => 1]);

            // return response
            $response = [
                'success' => true,
                'message' => 'Order Successfully Completed.',
            ];
            return response()->json($response, 200);
        }

        //if not completed
        if($request->input("action") == "cancel"){

            // if 1 cancelled by client, if 2 cancelled by staff
            $cancelled_by = $request->input("cancel_option");

            if ($cancelled_by == 2) {

                $text_message = 'We\'re sorry for the inconvenience. Your Order # '.$request->input("order_id").'cannot be delivered today to some technical difficulties';
                $this->messageNotification(null , $request->input("order_id"), $text_message);
            }

            //update the order
            DB::table('orders')->where('id', $request->input("order_id"))
                               ->update([
                                    'cancelled_by' => $cancelled_by,
                                    'is_cancelled' => 1,
                                    'reason' => $request->input("reason")
                                ]);

            // return response
            $response = [
                'success' => true,
                'message' => 'Order Successfully Cancelled.',
            ];
            return response()->json($response, 200);
        }
    }

    public function emergency(Request $request)
    {
        $staff = Auth::user();
        $stores = $staff->area->stores;

        foreach ($stores as $store) {
            $now = date('Y-m-d');
            $order = Order::where('store_id', '=', $store->id)
                          ->where('delivery_date', '=', $now)
                          ->where('is_completed', '=', 0)
                          ->where('is_cancelled', '=', 0)
                          ->first();
            if($order) {
               $order->update([
                    'cancelled_by' => 2,
                    'is_cancelled' => 1,
                    'reason' => $request->input("reason")
                ]); 

                $text_message = 'We\'re sorry for the inconvenience. Your Order # '.$order->id.'cannot be delivered today to some technical difficulties';

                $this->messageNotification(null , $request->input("order_id"), $text_message);
            }
        }

        $text_message = 'Delivery from area'.$staff->area->area_name .'cannot be delivered today to some technical difficulties. 
                         Reason: '.
                         $request->reason;

        $this->messageNotification('09123213123' , $request->input("order_id"), $text_message);

        $response = [
            'success' => true,
            'message' => 'Emergency Message Sent!',
        ];
        return response()->json($response, 200);
    }

    public function messageNotification($contact_num = null, $order_id, $text_message)
    {
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

        return;
    }
}
