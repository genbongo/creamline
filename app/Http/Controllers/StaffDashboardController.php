<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;
use DataTables;

class StaffDashboardController extends Controller
{
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
        $order = DB::table('orders')
                ->join('products', 'orders.product_id', '=', 'products.id')
                ->join('users', 'orders.client_id', '=', 'users.id')
                ->join('stores', 'orders.store_id', '=', 'stores.id')
                ->select('products.name', 'products.product_image', 'orders.quantity_ordered',
                    'orders.ordered_total_price', 'orders.created_at', 'orders.is_approved', 'orders.is_completed', 'orders.is_cancelled', 'orders.delivery_date', 'orders.id', 'users.fname', 'users.lname', 'stores.store_name', 'stores.store_address')
                // ->where('delivery_date', date('Y-m-d'))
                // ->where('is_completed', 0)
                ->get();

        if ($request->ajax()) {
            return Datatables::of($order)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
   
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Mark this order as completed" data-id="'.$row->id.'" class="btn btn-primary btn-sm editCompleteOrder">Completed</a>&nbsp;';

                    $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Mark this order as cancelled" data-id="'.$row->id.'" class="btn btn-danger btn-sm editCancelOrder">Cancel</a>';

                     return $btn;
                })
                ->rawColumns(['action'])
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

            //update the order
            DB::table('orders')->where('id', $request->input("order_id"))->update(['is_cancelled' => 1]);
            DB::table('orders')->where('id', $request->input("order_id"))->update(['reason' => $request->input("reason")]);

            // return response
            $response = [
                'success' => true,
                'message' => 'Order Successfully Cancelled.',
            ];
            return response()->json($response, 200);
        }
    }
}
