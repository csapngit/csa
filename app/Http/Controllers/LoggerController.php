<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLoggerRequest;
use App\Http\Requests\UpdateLoggerRequest;
use App\Models\Logger;

class LoggerController extends Controller
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
     * @param  \App\Http\Requests\StoreLoggerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLoggerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Logger  $logger
     * @return \Illuminate\Http\Response
     */
    public function show(Logger $logger)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Logger  $logger
     * @return \Illuminate\Http\Response
     */
    public function edit(Logger $logger)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLoggerRequest  $request
     * @param  \App\Models\Logger  $logger
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLoggerRequest $request, Logger $logger)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Logger  $logger
     * @return \Illuminate\Http\Response
     */
    public function destroy(Logger $logger)
    {
        //
    }
}
