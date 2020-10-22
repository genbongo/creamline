<?php

namespace App\Http\Controllers;

use App\Stock;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class StockController extends Controller
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
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->input();
        //insert to stock table
        $stockModel = Stock::updateOrCreate([
            'id' => $request->stock_id
        ],[
            'quantity' => $request->input("stocks"),
            'threshold' => $request->input("threshold"),
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Stock successfully updated.',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $stock = Stock::where('product_id', $id)->first();
        return response()->json($stock);
    }
}
