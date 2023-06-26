<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateTargetDsrRequest;
use App\Models\TargetDsr;
use Illuminate\Http\Request;

class TargetDsrController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$targetDsrs = TargetDsr::all();

		// dd($targetDsrs);

		return view('reports.dsr.targets.index', compact('targetDsrs'));
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
		//
	}

	/**
	 * Display the specified resource.
	 */
	public function show(TargetDsr $targetDsr)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(TargetDsr $targetDsr)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(UpdateTargetDsrRequest $request, TargetDsr $targetDsr)
	{
		// dd($request->all());

		$targetDsr->update(['target_sales' => $request->target_sales]);

		return back()->with('success', __('message.data_updated'));
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(TargetDsr $targetDsr)
	{
		//
	}
}
