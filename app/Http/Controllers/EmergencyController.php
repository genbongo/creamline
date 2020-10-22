<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;
use App\Traits\GlobalFunction;
use App\Notification;

class EmergencyController extends Controller
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
        return view('admin.emergency');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //get the input
        $contact_num = $request->input("contact");
        $address = $request->input("address");
        $orderID = $request->input("orderID");
        $text_message = $request->input("message");
        $staffFullname = Auth::user()->lname.', '.Auth::user()->fname;

        //declare the notification description for emergency text
        $note_description = 'There was a problem with the Delivery at '.$address.' with Order # '.$orderID.'. Please contact '.$staffFullname.' for more information.';

        //call the global function for setting the notification
        $this->set_notification("emergency_text", $note_description, $orderID);
        
        // $result = $this->global_itexmo($contact_num, $text_message." \n\n\n\n","ST-CAPST343228_559B2", "twy{ccd#)4");
        $result = $this->global_itexmo($contact_num, $text_message." \n\n\n\n","ST-CREAM343228_LGZPB", '#5pcg2mpi]');
        if ($result == ""){
            // echo "iTexMo: No response from server!!!
            // Please check the METHOD used (CURL or CURL-LESS). If you are using CURL then try CURL-LESS and vice versa.   
            // Please CONTACT US for help. ";   
        }else if ($result == 0){
            // echo "Message Sent!";
        }
        else{    
            // echo "Error Num ". $result . " was encountered!";
        }

        // return response
        $response = [
            'success' => true,
            'message' => 'Successfuly sent.',
        ];
        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $area = Area::find($id);
        // return response()->json($area);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function destroy(Area $area)
    {
        // $output = '';

        // // $area->delete();
        // if($area->is_deleted == 0){
        //     Area::where('id', $area->id)->update(["is_deleted" => 1]);
        //     $output = 'Successfully Deactivated!';
        // }else{
        //     Area::where('id', $area->id)->update(["is_deleted" => 0]);
        //     $output = 'Successfully Activated!';
        // }

        // // return response
        // $response = [
        //     'success', true,
        //     'message' => $output,
        // ];
        // return response()->json($response, 200);
    }
}
