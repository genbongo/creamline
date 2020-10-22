<?php

namespace App\Http\Controllers;

use App\ProductFileReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductFileReportController extends Controller
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
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductFileReport  $productFileReport
     * @return \Illuminate\Http\Response
     */
    public function show(ProductFileReport $productFileReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductFileReport  $productFileReport
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductFileReport $productFileReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductFileReport  $productFileReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductFileReport $productFileReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductFileReport  $productFileReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductFileReport $productFileReport)
    {
        //
    }
}
