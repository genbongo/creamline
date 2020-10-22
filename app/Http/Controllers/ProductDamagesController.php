<?php

namespace App\Http\Controllers;

use App\ProductDamages;
use App\ProductFileDamages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DataTables;
use Validator;
use App\Traits\GlobalFunction;

class ProductDamagesController extends Controller
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
        if(env("DB_CONNECTION") == "pgsql"){
            $file_damage = DB::select("SELECT DISTINCT ON (product_damages.id) products.id AS prodid, product_damages.id AS damageid, product_damages.client_id AS clientid, 
                                products.name AS prodname, product_file_damages.file_damage_image, 
                                product_damages.is_replaced, users.fname, users.lname FROM product_damages 
                                INNER JOIN product_file_damages ON product_damages.id = product_file_damages.product_damage_id 
                                INNER JOIN products ON product_damages.product_id = products.id 
                                INNER JOIN users ON product_damages.client_id = users.id 
                                ORDER BY product_damages.id");
        }else{                        
            $file_damage = DB::table('product_damages')
                ->join('product_file_damages', 'product_damages.id', '=', 'product_file_damages.product_damage_id')
                ->join('products', 'product_damages.product_id', '=', 'products.id')
                ->join('users', 'product_damages.client_id', '=', 'users.id')
                ->select('products.id AS prodid', 'product_damages.id AS damageid', 'product_damages.client_id AS clientid', 'products.name AS prodname', 'product_file_damages.file_damage_image', 'product_damages.is_replaced', 'users.fname', 'users.lname')
                ->groupBy('product_damages.id')
                ->get();
        }
        
        if ($request->ajax()) {
            return Datatables::of($file_damage)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
   
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Replace Order" data-id="'.$row->damageid.'" data-clientid="'.$row->clientid.'" data-original-title="Edit" class="btn btn-primary btn-sm editDamageOrder">Approve</a>&nbsp;';
                    $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Disapprove Damage" data-id="'.$row->damageid.'" data-clientid="'.$row->clientid.'" data-original-title="Edit" class="btn btn-danger btn-sm editDisapproveDamage">Disapprove</a>';

                     return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //store the action
        $action = $request->input("action");

        switch($action){
            //if approve damage request button is clicked
            case "approve_damage":
                ProductDamages::where('id', $request->input("damageid"))->update(["is_replaced" => 1]);
                
                //set message
                $message = 'Your Damage request # '.$request->input("damageid").' has been accepted. Please be advised accordingly';

                //call the global function for setting the notification
                $this->set_notification("approved_customer_order", $message, $request->input("clientid"));

                return response()->json([
                    'message' => "Order Damage Approved!",
                ]);
                break;
            case "disapprove_damage":
                ProductDamages::where('id', $request->input("damageid"))->update(["is_replaced" => 2]);
                
                //set message
                $message = 'Your Damage request # '.$request->input("damageid").' has been disapproved. Please be advised accordingly';

                //call the global function for setting the notification
                $this->set_notification("approved_customer_order", $message, $request->input("clientid"));
                
                return response()->json([
                    'message' => "Order Damage Disapproved!",
                ]);
                break;
            default:
                echo "do nothing here....";
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductDamages  $file_damage
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product_damage = ProductDamages::find($id);
        $product_file_damage = ProductFileDamages::where('product_damage_id', $id)->get();
        
        $data = [
          'product_damage' => $product_damage,
          'product_file_damage' => $product_file_damage
        ];

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductDamages  $file_damage
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductDamages $prod_damage)
    {
        //do nothing...........
    }
}
