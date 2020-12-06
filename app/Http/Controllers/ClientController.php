<?php

namespace App\Http\Controllers;

use App\User;
use App\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DataTables;
use App\Traits\GlobalFunction;

class ClientController extends Controller
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
        $client = User::latest()->where('user_role', "2")->get();

        // echo "<pre>";
        // var_dump($client);
        // echo "</pre>";

        if ($request->ajax()) {
            return Datatables::of($client)
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

                    if($row->is_pending == 1){
                        $status = 2;
                        $delete_status = 'Approve';
                        $delete_btn = 'btn-outline-info';
                    }
   
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Edit Client Profile" data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editClient">Edit</a>';

                    // $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Assign Client" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Assign" class="btn btn-warning btn-sm assignClient">Assign</a>';

                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="'.$delete_status.' Client" data-stat="'.$status.'" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Delete" class="btn '.$delete_btn.' btn-sm deleteClient">'.$delete_status.'</a>';

                    $btn = $btn.' <a href="/client/'.$row->id.'/stores" title="Client Store" class="btn btn-info btn-sm">'.'View Store'.'</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('client/client', compact('client'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->action == 'assign_client'){

            Store::updateOrCreate([
                'user_id' => $request->assign_id,
            ],[
                'user_id' => $request->assign_id,
                'area_id' => $request->area_id,
                'store_name' => "",
                'store_address' => "",
            ]);

            // return response
            $response = [
                'success' => true,
                'message' => 'Successfully Assigned.',
            ];
            return response()->json($response, 200);

        }else if($request->action == 'update_client_profile'){
            User::updateOrCreate([
                'id' => $request->client_id
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

            // return response
            $response = [
                'success' => true,
                'message' => 'Client successfully updated.',
            ];
            return response()->json($response, 200);
        }else{
            User::updateOrCreate([
                'id' => $request->client_id
            ],[
                'fname' => $request->fname,
                'mname' => $request->mname,
                'lname' => $request->lname,
                'email' => $request->email,
                'contact_num' => $request->contact_num,
                'user_role' => 2,   //2 for client
                'is_pending' => 1,   //0 means not pending
                'password' => Hash::make($request->password),
                'address' => "NA",
                'email_verified_at' => "2020-06-08 07:57:47",
                'img' => "NA",
                'remember_token' => "NA"
            ]);

            // return response
            $response = [
                'success' => true,
                'message' => 'Client successfully saved.',
            ];
            return response()->json($response, 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $client
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = User::find($id);
        return response()->json($client);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $client)
    {
        $output = '';

        // $client->delete();
        if($client->is_active == 0){
            User::where('id', $client->id)->update(["is_active" => 1]);
            $output = 'Successfully Activated!';
        }else{
            User::where('id', $client->id)->update(["is_active" => 0]);
            $output = 'Successfully Deactivated!';
        }

        if($client->is_pending == 1){
            //set text message
            $text_message = `Thank you for registering Creamline Products. You're account has been approved and you can now login to our official website. Enjoy!`;

            //send it to customer
            $this->global_itexmo($client->contact_num, $text_message." \n\n\n\n","ST-CREAM343228_LGZPB", '#5pcg2mpi]');
            
            User::where('id', $client->id)->update(["is_pending" => 0, "is_active" => 1]);
            $output = 'Successfully Approved!';
        }

        // return response
        $response = [
            'success', true,
            'message' => $output,
        ];
        return response()->json($response, 200);
    }

    public function storeList($id, Request $request)
    {
        $client = User::find($id);


       if ($request->ajax()) {
            $stores = $client->stores;

            return Datatables::of($stores)
                ->addIndexColumn()
                ->addColumn('area', function($row) {
                    return $row->area->area_name;
                })
                ->addColumn('action', function ($row) {
                    $status = '';
                    $delete_status = '';
                    $delete_btn = '';
                    $btn_label = '';
                    $title = '';

                    if($row->is_deleted == 0){
                        $status = 0;
                        $delete_status = 'Active';
                        $delete_btn = 'btn-danger';
                        $btn_label = 'Deactivate';
                        $btn_type = "deactivate";
                        $title = "Deactivate Store";
                    }else{
                        $status = 0;
                        $delete_status = 'Deactivate';
                        $delete_btn = 'btn-success';
                        $btn_label = 'Activate';
                        $btn_type = "activate";
                        $title = "Activate Store";
                    }
   
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="'.$title.'" data-id="'.$row->id.'" data-original-title="Edit" class="edit btn '.$delete_btn.' btn-sm '.$btn_type.'">'. $btn_label .'</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view("client/store_list", compact('client'));
    }


    public function storeListJson($id)
    {
        $client = User::find($id);

        return response()->json( $client->stores);
    }
}
