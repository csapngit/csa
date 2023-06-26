<?php

namespace App\Http\Controllers\Rebate;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOfftakeRequest;
use App\Http\Requests\UpdateOfftakeRequest;
use App\Models\Offtake;

class OfftakeController extends Controller
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
     * @param  \App\Http\Requests\StoreOfftakeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOfftakeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Offtake  $offtake
     * @return \Illuminate\Http\Response
     */
    public function show(Offtake $offtake)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Offtake  $offtake
     * @return \Illuminate\Http\Response
     */
    public function edit(Offtake $offtake)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOfftakeRequest  $request
     * @param  \App\Models\Offtake  $offtake
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOfftakeRequest $request, Offtake $offtake)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Offtake  $offtake
     * @return \Illuminate\Http\Response
     */
    public function destroy(Offtake $offtake)
    {
        //
    }
}
