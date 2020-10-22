<?php

namespace App\Http\Controllers;

use App\Fridge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;

class FridgeController extends Controller
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
        $fridge = Fridge::latest()->get();

        if ($request->ajax()) {
            return Datatables::of($fridge)
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
   
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Update Fridge" data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editFridge">Edit</a>';

                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="'.$delete_status.' Fridge" data-stat="'.$status.'" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Delete" class="btn '.$delete_btn.' btn-sm deleteFridge">'.$delete_status.'</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('fridge/fridge', compact('fridge'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Fridge::updateOrCreate([
            'id' => $request->fridge_id
        ],[
            'user_id' => $request->cmb_user,
            'model' => $request->model,
            'description' => $request->description,
            'location' => $request->location,
            'status' => $request->status,
        ]);

        // return response
        $response = [
            'success' => true,
            'message' => 'Fridge saved successfully.',
        ];
        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Fridge  $fridge
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fridge = Fridge::find($id);
        return response()->json($fridge);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\fridge  $fridge
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fridge $fridge)
    {
        $output = '';

        // $fridge->delete();
        if($fridge->is_deleted == 0){
            Fridge::where('id', $fridge->id)->update(["is_deleted" => 1]);
            $output = 'Successfully Deactivated!';
        }else{
            Fridge::where('id', $fridge->id)->update(["is_deleted" => 0]);
            $output = 'Successfully Activated!';
        }

        // return response
        $response = [
            'success', true,
            'message' => $output,
        ];
        return response()->json($response, 200);
    }
}
