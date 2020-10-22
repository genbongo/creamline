<?php

namespace App\Http\Controllers;

use App\Product_Report;
use App\ProductFileReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DataTables;
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
        if(env("DB_CONNECTION") == "pgsql"){
            $file_replacement = DB::select("SELECT DISTINCT ON (product_reports.id) products.id AS prodid, product_reports.id AS reportid, 
                                products.name AS prodname, product_file_reports.file_report_image, 
                                product_reports.is_replaced, users.fname, users.lname FROM product_reports 
                                INNER JOIN product_file_reports ON product_reports.id = product_file_reports.product_report_id 
                                INNER JOIN products ON product_reports.product_id = products.id 
                                INNER JOIN users ON product_reports.client_id = users.id 
                                WHERE product_reports.client_id = ".Auth::user()->id."
                                ORDER BY product_reports.id");
        }else{                        
            $file_replacement = DB::table('product_reports')
                ->join('product_file_reports', 'product_reports.id', '=', 'product_file_reports.product_report_id')
                ->join('products', 'product_reports.product_id', '=', 'products.id')
                ->select('products.id AS prodid', 'product_reports.id AS reportid', 'products.name AS prodname', 'product_file_reports.file_report_image', 'product_reports.is_replaced')
                ->groupBy('product_reports.id')
                ->where('product_reports.client_id', Auth::user()->id)
                ->get();
        }

        if ($request->ajax()) {
            return Datatables::of($file_replacement)
                ->addIndexColumn()
                ->make(true);
        }

        return view('file_replacement/index', compact('file_replacement'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->hasFile('file_report_image'))
        {
            $allowedfileExtension=['jpg','png'];
            $files = $request->file('file_report_image');

            $items = Product_Report::create([
                'product_id' => $request->product_id,
                'store_id' => $request->store_id,
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
                $file->move(public_path('img/filereport'), $new_name);

                if($check)
                {
                    $fileReports = ProductFileReport::create([
                        'product_report_id' => $items->id,
                        'file_report_image' => $new_name
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
