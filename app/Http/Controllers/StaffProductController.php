<?php

namespace App\Http\Controllers;

use App\Product;
use App\Stock;
use App\Variation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DataTables;
use Validator;

class StaffProductController extends Controller
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
        $product = DB::table('products')
        ->join('variations', 'products.id', '=', 'variations.product_id')
        ->get();

        if ($request->ajax()) {
            return Datatables::of($product)
                ->addIndexColumn()
                ->make(true);
        }

        return view('product/staff-product', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit_product($id)
    {
        $product = Product::find($id);
        $variation = Variation::where('product_id', $id)->first();
        $stock = Stock::where('product_id', $id)->first();

        $data = [
          'product' => $product,
          'variation' => $variation,
          'stock' => $stock,
        ];

        return response()->json($data);
    }
}
