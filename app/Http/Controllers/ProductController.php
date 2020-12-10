<?php

namespace App\Http\Controllers;

use App\Product;
use App\Stock;
use App\Variation;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Validator;

class ProductController extends Controller
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
        $product = Product::latest()->get();

        if ($request->ajax()) {
            return Datatables::of($product)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $status = '';
                    $delete_status = '';
                    $delete_btn = '';

                    if($row->is_deleted == 0){
                        $status = 0;
                        $delete_status = 'Sold Out';
                        $delete_btn = 'btn-danger';
                    }else{
                        $status = 1;
                        $delete_status = 'Available';
                        $delete_btn = 'btn-success';
                    }
   
                    $btn = '<a href="product/'.$row->id.'/edit" data-toggle="tooltip" data-placement="top" title="Update Product" data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">Edit</a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Stock" data-toggle="tooltip" data-id="'.$row->id.'" data-name="'.$row->name.'" data-original-title="Stock" class="btn btn-warning btn-sm StockProduct">Stock</a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="'.$delete_status.' Product" data-stat="'.$status.'" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Delete" class="btn '.$delete_btn.' btn-sm deleteProduct">'.$delete_status.'</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('product/product', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        //if there is a product image selected
        if($request->hasFile("product_image")){
            $validation = Validator::make($request->all(), [
                'product_image.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120'
            ]);

            if($validation->passes())
            {
                $image = $request->file('product_image')[0];

                $new_name = rand() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('img/product'), $new_name);

                //insert to product table
                $productModel = Product::updateOrCreate([
                    'id' => $request->product_id
                ],[
                    'name' => $request->name,
                    'description' => $request->description,
                    'product_image' => $new_name,
                ]);

                //

                $images = $request->file('product_image');

                foreach ($images as $key => $image) {
                    if($key != 0 )
                    {
                        $file_name = rand() . '.' . $image->getClientOriginalExtension();
                        $image->move(public_path('img/product'), $file_name);

                        $productModel->images()->create([
                            'path' => $file_name
                        ]); 
                    }
                }
               
                //insert to stock table
                $stockModel = Stock::updateOrCreate([
                    'id' => $request->stock_id
                ],[
                    'product_id' => $productModel->id,
                    'quantity' => 0,
                    'threshold' => 0,
                ]);

                //-------------get the value for price----------------//
                $price_value = '';
                $size_value = explode(",", $request->size);
                $price_value = ProductController::return_price_value($size_value);

                //insert to variation table
                Variation::updateOrCreate([
                    'id' => $request->product_id
                ],[
                    'product_id' => $productModel->id,
                    'size' => str_replace(" ", "", $request->size),
                    'flavor' => str_replace(" ", "", $request->flavor),
                    'price' => $request->price ? $request->price : $price_value,
                ]);

                return response()->json([
                    'message'   => 'Image Successfully Uploaded.',
                    'uploaded_image' => '<img src="/images/'.$new_name.'" class="img-thumbnail" width="300" />',
                    'class_name'  => 'alert-success'
                ]);
            }
            else
            {
                return response()->json([
                    'message'   => $validation->errors()->all(),
                    'uploaded_image' => '',
                    'class_name'  => 'alert-danger'
                ]);
            }
        }else{

            if($request->action == "update_price"){
                //insert to variation table
                Variation::where("product_id", $request->product_id)->update([
                    'price' => $request->price
                ]);

                // return response
                $response = [
                    'success' => true,
                    'message' => 'Price successfully saved.',
                ];

                return $response;

            }else if($request->action == "update_size_flavor"){

                //-------------get the value for price----------------//
                $price_value = '';
                $size_value = explode(",", $request->size);

                $size_value = Arr::where($size_value, function ($value, $key){
                    return $value != '';
                });

                $price_value = ProductController::return_price_value($size_value);

                //insert to variation table
                Variation::where("product_id", $request->product_id)->update([
                    'size' => $request->size, 
                    'flavor' => $request->flavor,
                    'price' => $request->price ? $request->price : $price_value,
                ]);

                // return response
                $response = [
                    'success' => true,
                    'message' => 'Variations successfully saved.',
                ];

                return $response;

            }else{

                Product::updateOrCreate([
                    'id' => $request->product_id
                ],[
                    'name' => $request->name,
                    'description' => $request->description
                ]);

                // return response
                $response = [
                    'success' => true,
                    'message' => 'Product successfully saved.',
                ];

                return $response;
            }
        }
    }

    //create a function that will return the data for 
    public function return_price_value($size_value){
        
        if(count($size_value) == 1) $price_value = '0,';
        if(count($size_value) == 2) $price_value = '0,0,';
        if(count($size_value) == 3) $price_value = '0,0,0,';
        if(count($size_value) == 4) $price_value = '0,0,0,0,';
        if(count($size_value) == 5) $price_value = '0,0,0,0,0,';
        if(count($size_value) == 6) $price_value = '0,0,0,0,0,0,';
        if(count($size_value) == 7) $price_value = '0,0,0,0,0,0,0,';
        if(count($size_value) == 8) $price_value = '0,0,0,0,0,0,0,0,';
        if(count($size_value) == 9) $price_value = '0,0,0,0,0,0,0,0,0,';
        if(count($size_value) == 10) $price_value = '0,0,0,0,0,0,0,0,0,0,';

        //return the data
        return $price_value;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit_product($id)
    {
        $product = Product::with('images')->find($id);
        $variation = Variation::where('product_id', $id)->first();
        $stock = Stock::where('product_id', $id)->first();

        $data = [
          'product' => $product,
          'variation' => $variation,
          'stock' => $stock,
        ];

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        $variation = Variation::where('product_id', $id)->first();
        $stock = Stock::where('product_id', $id)->first();

        $data = [
          'product' => $product,
          'variation' => $variation,
          'stock' => $stock,
        ];

        return view('product.edit')->with($data);



        // // return response
        // $response = [
        //     'success' => true,
        //     'product_id' => $product->id,
        //     'product_name' => $product->name,
        //     'product_description' => $product->description,
        //     'variation_data' => $variation,
        //     // 'message' => 'Product saved successfully.',
        // ];

        // return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $output = '';

        // $product->delete();
        if($product->is_deleted == 0){
            Product::where('id', $product->id)->update(["is_deleted" => 1]);
            $output = 'Successfully Deactivated!';
        }else{
            Product::where('id', $product->id)->update(["is_deleted" => 0]);
            $output = 'Successfully Activated!';
        }

        // return response
        $response = [
            'success', true,
            'message' => $output,
        ];
        return response()->json($response, 200);
    }

    public function getSizes($id)
    {
        $variation =  Variation::where('product_id', $id)->first();

        $sizes = explode(',', $variation->size);

        $formatted = array_map(function($size) {
            $size = $size;
            if ($size) {
                return (int) $size;
            }
        }, $sizes);

        return response()->json($formatted);
    }
}
