<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PendingController extends Controller
{

    /*
    * Create a function that will navigate the user to pending page
    */
    public function pending()
    {
        return view('pending');
    }
}
