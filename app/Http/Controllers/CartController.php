<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
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
        $cart = Cart::latest()
                     ->where('user_id', Auth::user()->id)
                     ->where(function($query){
                        $query->where('is_checkout', 0)
                              ->orWhere('is_placed', 0);
                     })
                     ->get();

        if ($request->ajax()) {
            return Datatables::of($cart)
                ->addIndexColumn()
                ->addColumn('select', function(){
                    return false;
                })
                ->addColumn('action', function ($row) {

                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Remove Cart" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Remove" class="btn btn-danger btn-sm deleteCart">Remove</a>';

                    return $btn;
                })
                ->rawColumns(['select', 'action'])
                ->make(true);
        }

        return view('client/cart', compact('cart'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = Product::find($request->product_id);

        $cart = Cart::where('product_id', $request->product_id)
                      ->where('user_id', Auth::user()->id)
                      ->first();

        Cart::updateOrCreate([
            'product_id' => $request->product_id,
            'user_id' => Auth::user()->id,
            'is_checkout' => 0,
        ],[
            
            'product_image' => $product->product_image,
            'product_name' => $request->product_name,
            'product_description' => $request->product_description,
            'size' => $request->size,
            'flavor' => $request->flavor,
            'quantity' => $cart ? $cart->quantity + $request->quantity : $request->quantity,
            'subtotal' => $request->subtotal,
        ]);

        // return response
        $response = [
            'success' => true,
            'message' => 'Cart saved successfully.',
        ];
        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cart = Cart::find($id);
        return response()->json($cart);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        Cart::find($cart->id)->delete();
     
        return response()->json(['message'=>'Cart deleted successfully.']);
    }

    /**
     * Save the data to session from the cart
     */
    public function save_cart(Request $request)
    {
        $carts = Cart::find($request->ids);

        foreach ($carts as $cart) {
            $cart->is_checkout = 1;
            $cart->save();
        }

        // clear first the session named cart_data
        session()->forget('cart_data');

        // store the data into session named cart_data
        session(['cart_data' => $carts]);

        return response()->json(['message'=>'Sucessfully stored in session.']);
    }
}
