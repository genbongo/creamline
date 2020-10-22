<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;
use DataTables;

class TransactionHistoryController extends Controller
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
                ->select('products.name', 'products.product_image', 'orders.quantity_ordered',
                    'orders.ordered_total_price', 'orders.created_at', 'orders.is_approved', 'orders.is_completed', 'orders.delivery_date', 'orders.id')
                ->where('client_id', Auth::user()->id)
                ->get();

        if ($request->ajax()) {
            return Datatables::of($order)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('client.transaction_history', compact('order'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }
}
