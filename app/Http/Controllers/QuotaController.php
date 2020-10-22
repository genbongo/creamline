<?php

namespace App\Http\Controllers;

use App\Quota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;
use App\Traits\GlobalFunction;

class QuotaController extends Controller
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
        $quota = Quota::latest()->get();

        // var_dump($quota);

        if ($request->ajax()) {
            return Datatables::of($quota)
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
   
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Update Quota" data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editQuota">Edit</a>';

                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="'.$delete_status.' Quota" data-stat="'.$status.'" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Delete" class="btn '.$delete_btn.' btn-sm deleteQuota">'.$delete_status.'</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('quota/quota', compact('quota'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Quota::updateOrCreate([
            'id' => $request->quota_id
        ],[
            'year' => $request->quota_year,
            'jan' => $request->quota_jan,
            'feb' => $request->quota_feb,
            'mar' => $request->quota_mar,
            'apr' => $request->quota_apr,
            'may' => $request->quota_may,
            'jun' => $request->quota_jun,
            'jul' => $request->quota_jul,
            'aug' => $request->quota_aug,
            'sep' => $request->quota_sep,
            'oct' => $request->quota_oct,
            'nov' => $request->quota_nov,
            'dev' => $request->quota_dev,
        ]);

        $message = 'Your Quota for Year '.$request->quota_year.' has been set!';

        //call the global function for setting the notification
        $this->set_notification("set_yearly_quotas", $message, Auth::user()->id);

        // return response
        $response = [
            'success' => true,
            'message' => 'Quota saved successfully.',
        ];
        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Quota  $quota
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $quota = Quota::find($id);
        return response()->json($quota);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Quota  $quota
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Quota::find($id)->delete();

        // return response
        $response = [
            'success', true,
            'message' => "Successfully Deleted!",
        ];
        return response()->json($response, 200);
    }
}
