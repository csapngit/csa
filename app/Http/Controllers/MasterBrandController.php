<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMasterBrandRequest;
use App\Http\Requests\UpdateMasterBrandRequest;
use App\Models\MasterBrand;

class MasterBrandController extends Controller
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
     * @param  \App\Http\Requests\StoreMasterBrandRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMasterBrandRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MasterBrand  $masterBrand
     * @return \Illuminate\Http\Response
     */
    public function show(MasterBrand $masterBrand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MasterBrand  $masterBrand
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterBrand $masterBrand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMasterBrandRequest  $request
     * @param  \App\Models\MasterBrand  $masterBrand
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMasterBrandRequest $request, MasterBrand $masterBrand)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MasterBrand  $masterBrand
     * @return \Illuminate\Http\Response
     */
    public function destroy(MasterBrand $masterBrand)
    {
        //
    }
}
