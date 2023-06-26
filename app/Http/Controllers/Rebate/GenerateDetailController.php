<?php

namespace App\Http\Controllers;

use App\Models\GenerateDetail;
use App\Http\Requests\StoreGenerateDetailRequest;
use App\Http\Requests\UpdateGenerateDetailRequest;

class GenerateDetailController extends Controller
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
   * @param  \App\Http\Requests\StoreGenerateDetailRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreGenerateDetailRequest $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\GenerateDetail  $generateDetail
   * @return \Illuminate\Http\Response
   */
  public function show(GenerateDetail $generateDetail)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\GenerateDetail  $generateDetail
   * @return \Illuminate\Http\Response
   */
  public function edit(GenerateDetail $generateDetail)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \App\Http\Requests\UpdateGenerateDetailRequest  $request
   * @param  \App\Models\GenerateDetail  $generateDetail
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateGenerateDetailRequest $request, GenerateDetail $generateDetail)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\GenerateDetail  $generateDetail
   * @return \Illuminate\Http\Response
   */
  public function destroy(GenerateDetail $generateDetail)
  {
    //
  }
}
