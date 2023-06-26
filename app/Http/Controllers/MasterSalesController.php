<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMasterSalesRequest;
use App\Http\Requests\UpdateMasterSalesRequest;
use App\Models\MasterSales;

class MasterSalesController extends Controller
{
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
     * @param  \App\Http\Requests\StoreMasterSalesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMasterSalesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MasterSales  $masterSales
     * @return \Illuminate\Http\Response
     */
    public function show(MasterSales $masterSales)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MasterSales  $masterSales
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterSales $masterSales)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMasterSalesRequest  $request
     * @param  \App\Models\MasterSales  $masterSales
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMasterSalesRequest $request, MasterSales $masterSales)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MasterSales  $masterSales
     * @return \Illuminate\Http\Response
     */
    public function destroy(MasterSales $masterSales)
    {
        //
    }
}
