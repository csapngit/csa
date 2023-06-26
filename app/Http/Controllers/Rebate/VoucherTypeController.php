<?php

namespace App\Http\Controllers\Rebate;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVoucherTypeRequest;
use App\Http\Requests\UpdateVoucherTypeRequest;
use App\Models\VoucherType;

class VoucherTypeController extends Controller
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
     * @param  \App\Http\Requests\StoreVoucherTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVoucherTypeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VoucherType  $voucherType
     * @return \Illuminate\Http\Response
     */
    public function show(VoucherType $voucherType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VoucherType  $voucherType
     * @return \Illuminate\Http\Response
     */
    public function edit(VoucherType $voucherType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateVoucherTypeRequest  $request
     * @param  \App\Models\VoucherType  $voucherType
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVoucherTypeRequest $request, VoucherType $voucherType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VoucherType  $voucherType
     * @return \Illuminate\Http\Response
     */
    public function destroy(VoucherType $voucherType)
    {
        //
    }
}
