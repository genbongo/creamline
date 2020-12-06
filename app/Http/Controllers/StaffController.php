<?php

namespace App\Http\Controllers;

use App\User;
use App\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DataTables;

class StaffController extends Controller
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
        $staff = User::latest()->where('user_role', "1")->get();

        if ($request->ajax()) {
            return Datatables::of($staff)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $status = '';
                    $delete_status = '';
                    $delete_btn = '';

                    if($row->is_active == 0){
                        $status = 1;
                        $delete_status = 'Activate';
                        $delete_btn = 'btn-success';
                    }else{
                        $status = 0;
                        $delete_status = 'Deactivate';
                        $delete_btn = 'btn-danger';
                    }
   
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="View Staff Profile" data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editStaff">View</a>';

                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Assign Staff" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Assign" class="btn btn-warning btn-sm assignStaff">Assign</a>';

                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="'.$delete_status.' Staff" data-stat="'.$status.'" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Delete" class="btn '.$delete_btn.' btn-sm deleteStaff">'.$delete_status.'</a>';

                     return $btn;
                })
                ->addColumn('area', function ($row) {
                    return $row->area ? $row->area->area_name : 'Not Assigned'; 
                })
                ->rawColumns(['action', 'area'])
                ->make(true);
        }

        return view('staff/staff', compact('staff'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->action == 'assign_staff'){
            $user = User::find($request->assign_id);
            $user->area_id = $request->area_id;
            $user->save();

            $message = 'Successfully Assigned.';

        } else {
            User::updateOrCreate([
                'id' => $request->staff_id
            ],[
                'fname' => $request->fname,
                'mname' => $request->mname,
                'lname' => $request->lname,
                'email' => $request->email,
                'contact_num' => $request->contact_num,
                'address' => "NA",
                'email_verified_at' => "2020-06-08 07:57:47",
                'img' => "NA",
                'remember_token' => "NA"
            ]);

            $message = 'Staff successfully updated.';
        }

        $response = [
            'success' => true,
            'message' => $message
        ];

        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $staff
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $staff = User::find($id);
        return response()->json($staff);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $staff
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $staff)
    {
        $output = '';

        // $staff->delete();
        if($staff->is_active == 0){
            User::where('id', $staff->id)->update(["is_active" => 1]);
            $output = 'Successfully Activated!';
        }else{
            User::where('id', $staff->id)->update(["is_active" => 0]);
            $output = 'Successfully Deactivated!';
        }

        // return response
        $response = [
            'success', true,
            'message' => $output,
        ];
        return response()->json($response, 200);
    }
}
