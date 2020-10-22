<?php

namespace App\Http\Controllers;

use App\User;
use App\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DataTables;

class ShopController extends Controller
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

    /*
    * Create a function that will navigate the user to shop page
    */
    public function shop()
    {
        return view('client.shop');
    }

    /**
     * Create a function that will allow the user to save to cart the selected product
     *
     * @param  \App\User  $client
     * @return \Illuminate\Http\Response
     */
    public function save_to_cart(Request $request){

        //if there is no product that were saved yet
        if(session("cart") == null){

            // Store a piece of data in the session...
            session(['cart' => $request->input()]);

            // return response
            $response = [
                'success' => true,
                'message' => 'Successfully added to Cart!',
            ];
            return response()->json($response, 200);

        }else{

            //get the current session for cart
            $cart = session("cart");

            //then push the current product selected
            array_push($cart, $request->input());

            // Store a piece of data in the session...
            session(['cart' => $cart]);

            // return response
            $response = [
                'success' => true,
                'message' => 'Successfully added to Cart!',
            ];
            return response()->json($response, 200);

            // return gettype($cart);
        }

    }
}
