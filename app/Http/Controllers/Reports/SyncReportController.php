<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSyncReportRequest;
use App\Http\Requests\UpdateSyncReportRequest;
use App\Models\SyncReport;

class SyncReportController extends Controller
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
     * @param  \App\Http\Requests\StoreSyncReportRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSyncReportRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SyncReport  $syncReport
     * @return \Illuminate\Http\Response
     */
    public function show(SyncReport $syncReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SyncReport  $syncReport
     * @return \Illuminate\Http\Response
     */
    public function edit(SyncReport $syncReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSyncReportRequest  $request
     * @param  \App\Models\SyncReport  $syncReport
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSyncReportRequest $request, SyncReport $syncReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SyncReport  $syncReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(SyncReport $syncReport)
    {
        //
    }
}
