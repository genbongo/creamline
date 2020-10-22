<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DataTables;

class SalesReportController extends Controller
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
        $sales_report = DB::table('orders')
                ->join('products', 'orders.product_id', '=', 'products.id')
                ->join('users', 'orders.client_id', '=', 'users.id')
                ->select('products.name', 'products.product_image', 'orders.quantity_ordered',
                    'orders.ordered_total_price', 'orders.created_at', 'orders.is_approved', 'orders.is_completed', 'orders.is_cancelled', 'orders.delivery_date', 'orders.id', 'users.fname', 'users.lname', 'users.contact_num', 'orders.attempt', 'orders.reason')
                ->where("is_completed", 1)
                ->where("is_rescheduled", 0)
                ->where("is_cancelled", 0)
                ->where("is_replacement", 0)
                ->where("is_approved", 1)
                ->get();

        if ($request->ajax()) {
            return Datatables::of($sales_report)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('order.sales_report', compact('sales_report'));
    }
}
