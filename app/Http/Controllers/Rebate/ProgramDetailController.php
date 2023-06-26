<?php

namespace App\Http\Controllers\Rebate;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProgramDetailRequest;
use App\Http\Requests\UpdateProgramDetailRequest;
use App\Models\ProgramDetail;

class ProgramDetailController extends Controller
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
     * @param  \App\Http\Requests\StoreProgramDetailRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProgramDetailRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProgramDetail  $programDetail
     * @return \Illuminate\Http\Response
     */
    public function show(ProgramDetail $programDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProgramDetail  $programDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(ProgramDetail $programDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProgramDetailRequest  $request
     * @param  \App\Models\ProgramDetail  $programDetail
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProgramDetailRequest $request, ProgramDetail $programDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProgramDetail  $programDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProgramDetail $programDetail)
    {
        //
    }
}
