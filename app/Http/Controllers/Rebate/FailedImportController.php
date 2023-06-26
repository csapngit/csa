<?php

namespace App\Http\Controllers\Rebate;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFailedImportRequest;
use App\Http\Requests\UpdateFailedImportRequest;
use App\Models\FailedImport;

class FailedImportController extends Controller
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
     * @param  \App\Http\Requests\StoreFailedImportRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFailedImportRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FailedImport  $failedImport
     * @return \Illuminate\Http\Response
     */
    public function show(FailedImport $failedImport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FailedImport  $failedImport
     * @return \Illuminate\Http\Response
     */
    public function edit(FailedImport $failedImport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFailedImportRequest  $request
     * @param  \App\Models\FailedImport  $failedImport
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFailedImportRequest $request, FailedImport $failedImport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FailedImport  $failedImport
     * @return \Illuminate\Http\Response
     */
    public function destroy(FailedImport $failedImport)
    {
        //
    }
}
