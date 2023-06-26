<?php

namespace App\Http\Controllers\Rebate;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIncentiveTypeRequest;
use App\Http\Requests\UpdateIncentiveTypeRequest;
use App\Models\IncentiveType;

class IncentiveTypeController extends Controller
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
     * @param  \App\Http\Requests\StoreIncentiveTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreIncentiveTypeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\IncentiveType  $incentiveType
     * @return \Illuminate\Http\Response
     */
    public function show(IncentiveType $incentiveType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\IncentiveType  $incentiveType
     * @return \Illuminate\Http\Response
     */
    public function edit(IncentiveType $incentiveType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateIncentiveTypeRequest  $request
     * @param  \App\Models\IncentiveType  $incentiveType
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateIncentiveTypeRequest $request, IncentiveType $incentiveType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\IncentiveType  $incentiveType
     * @return \Illuminate\Http\Response
     */
    public function destroy(IncentiveType $incentiveType)
    {
        //
    }
}
