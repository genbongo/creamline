<?php

namespace App\Http\Controllers;

use App\Ad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Validator;

class AdController extends Controller
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
        $ads = Ad::latest()->get();

        if ($request->ajax()) {
            return Datatables::of($ads)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $status = '';
                    $delete_status = '';
                    $delete_btn = '';

                    if($row->is_deleted == 0){
                        $status = 0;
                        $delete_status = 'Delete';
                        $delete_btn = 'btn-danger';
                    }else{
                        $status = 1;
                        $delete_status = 'Activate';
                        $delete_btn = 'btn-success';
                    }
   
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Update Ad" data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editArea">Edit</a>';

                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="'.$delete_status.' Ad" data-stat="'.$status.'" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Delete" class="btn '.$delete_btn.' btn-sm deleteArea">'.$delete_status.'</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('ads/ads', compact('ads'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'ads_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        if($validation->passes())
        {
            $image = $request->file('ads_image');
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img/ads'), $new_name);

            //insert to product table
            $productModel = Ad::updateOrCreate([
                'id' => $request->ads_id
            ],[
                'ads_image' => $new_name,
            ]);

            // return response
            $response = [
                'success' => true,
                'message' => 'Ad successfully saved.',
            ];
            return response()->json($response, 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ad  $ads
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ads = Ad::find($id);
        return response()->json($ads);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ad  $ads
     * @return \Illuminate\Http\Response
     */
    // public function destroy(Ad $ads)
    public function destroy($id)
    {
        // $output = '';

        Ad::where('id',$id)->delete();
        // if($ads->is_deleted == 0){
        //     Ad::where('id', $ads->id)->update(["is_deleted" => 1]);
        //     $output = 'Successfully Deactivated!';
        // }else{
        //     Ad::where('id', $ads->id)->update(["is_deleted" => 0]);
        //     $output = 'Successfully Activated!';
        // }

        // return response
        $response = [
            'success', true,
            'message' => "Successfully deleted!",
        ];
        return response()->json($response, 200);
    }
}
