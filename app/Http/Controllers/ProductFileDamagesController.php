<?php

namespace App\Http\Controllers;

use App\ProductDamages;
use App\ProductFileDamages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DataTables;
use Validator;

class ProductFileDamagesController extends Controller
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
        if(env("DB_CONNECTION") == "pgsql"){
            $file_damage = DB::select("SELECT DISTINCT ON (product_damages.id) products.id AS prodid, product_damages.id AS damageid, 
                                products.name AS prodname, product_file_damages.file_damage_image, 
                                product_damages.is_replaced, users.fname, users.lname FROM product_damages 
                                INNER JOIN product_file_damages ON product_damages.id = product_file_damages.product_damage_id 
                                INNER JOIN products ON product_damages.product_id = products.id 
                                INNER JOIN users ON product_damages.client_id = users.id 
                                WHERE product_damages.client_id = ".Auth::user()->id."
                                ORDER BY product_damages.id");
        }else{                        
            $file_damage = DB::table('product_damages')
                ->join('product_file_damages', 'product_damages.id', '=', 'product_file_damages.product_damage_id')
                ->join('products', 'product_damages.product_id', '=', 'products.id')
                ->select('products.id AS prodid', 'product_damages.id AS damageid', 'products.name AS prodname', 'product_file_damages.file_damage_image', 'product_damages.is_replaced')
                ->groupBy('product_damages.id')
                ->where('product_damages.client_id', Auth::user()->id)
                ->get();
        }

        if ($request->ajax()) {
            return Datatables::of($file_damage)
                ->addIndexColumn()
                ->make(true);
        }

        return view('file_damages/index', compact('file_damage'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->hasFile('file_damage_image'))
        {
            $allowedfileExtension=['jpg','png'];
            $files = $request->file('file_damage_image');

            $items = ProductDamages::create([
                'order_id' => $request->order_id,
                'product_id' => $request->product_id,
                'size' => $request->size_id,
                'flavor' => $request->flavor_id,
                'client_id' => Auth::user()->id,
                'is_replaced' => 0,
            ]);

            foreach($files as $file){
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $check=in_array($extension,$allowedfileExtension);
                $new_name = rand() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('img/filedamage'), $new_name);

                if($check)
                {
                    $fileReports = ProductFileDamages::create([
                        'product_damage_id' => $items->id,
                        'file_damage_image' => $new_name
                    ]);
                }
            }

            // return response
            $response = [
                'success' => true,
                'message' => 'File damage has been sent to the Admin! Please wait for the approval.',
            ];
            return response()->json($response, 200);
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
    public function destroy(ProductDamages $file_damage)
    {
        //do nothing......
    }
}
