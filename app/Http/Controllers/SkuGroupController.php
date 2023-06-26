<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSkuGroupRequest;
use App\Http\Requests\UpdateSkuGroupRequest;
use App\Models\SkuGroup;

class SkuGroupController extends Controller
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
     * @param  \App\Http\Requests\StoreSkuGroupRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSkuGroupRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SkuGroup  $skuGroup
     * @return \Illuminate\Http\Response
     */
    public function show(SkuGroup $skuGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SkuGroup  $skuGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(SkuGroup $skuGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSkuGroupRequest  $request
     * @param  \App\Models\SkuGroup  $skuGroup
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSkuGroupRequest $request, SkuGroup $skuGroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SkuGroup  $skuGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(SkuGroup $skuGroup)
    {
        //
    }
}
