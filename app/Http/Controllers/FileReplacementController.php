<?php

namespace App\Http\Controllers;

use App\ProductFileReport;
use App\Product_Report;
use App\ReplacementProduct;
use App\Store;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class FileReplacementController extends Controller
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
        if(Auth::user()->user_role == 99) {
            $file_replacement = Product_Report::where('client_id', Auth::user()->id)
                                    ->get();
        } else {
            $file_replacement = Product_Report::all();
        }

        if ($request->ajax()) {
            return Datatables::of($file_replacement)
                ->addIndexColumn()
                ->addColumn('status', function($row){
                  return $row->is_replaced;
                })
                ->addColumn('products', function($row) {
                    return $row->products;
                })
                ->addColumn('quantity', function($row) {
                   $total = 0;
                   foreach ($row->products as $value) {
                     $total += $value->quantity;
                   }
                    return $total;
                })
                ->addColumn('images', function($row) {
                    return $row->images;
                })
                ->rawColumns(['status', 'quantity', 'images'])
                ->make(true);
        }

        if(Auth::user()->user_role == 2 ) {
            $stores = Auth::user()->stores;
        } else {
            $stores = Store::all();
        }

        return view('file_replacement/index', compact('file_replacement', 'stores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $prodIds = $request->product;
        $size = $request->size;
        $quantity = $request->quantity;

        if($request->hasFile('file_report_image'))
        {
            $allowedfileExtension=['jpg','png', 'jpeg'];
            $files = $request->file('file_report_image');

            $items = Product_Report::create([
                'product_id' => ' ',
                'store_id' => $request->store,
                'size' => ' ',
                'flavor' => ' ',
                'quantity' => ' ',
                'client_id' => Auth::user()->id,
                'is_replaced' => 0,
            ]);

            foreach ($prodIds as $key => $product) {
                ReplacementProduct::create([
                  'product_report_id' => $items->id,
                  'product_id' => $product,
                  'size' => $size[$key],
                  'quantity' => $quantity[$key]
                ]);
            }

            foreach($files as $file){
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $check=in_array($extension,$allowedfileExtension);
                $new_name = rand() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('img/filereport'), $new_name);

                if($check)
                {
                    $fileReports = ProductFileReport::create([
                        'product_report_id' => $items->id,
                        'file_report_image' => $new_name,
                        'quantity' => $request->quantity,
                    ]);
                }
            }

            // return response
            $response = [
                'success' => true,
                'message' => 'File replacement has been sent to the Admin! Please wait for the approval.',
            ];
            return response()->json($response, 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product_Report  $file_replacement
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product_report = Product_Report::find($id);
        $product_file_report = ProductFileReport::where('product_report_id', $id)->get();
        
        $data = [
          'product_report' => $product_report,
          'product_file_report' => $product_file_report
        ];

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product_Report  $file_replacement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product_Report $file_replacement)
    {
        //do nothing......
    }
}
