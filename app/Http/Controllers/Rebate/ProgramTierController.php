<?php

namespace App\Http\Controllers\Rebate;

use App\Http\Requests\StoreProgramTierRequest;
use App\Http\Requests\UpdateProgramTierRequest;
use App\Models\IncentiveType;
use App\Models\Program;
use App\Models\ProgramTier;
use App\Enums\IncentiveTypeEnum;
use App\Enums\ProgramTypeEnum;
use App\Http\Controllers\Controller;

class ProgramTierController extends Controller
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
	public function create(Program $program)
	{
		$incentiveTypes = IncentiveType::all();

		return view('rebate.tiers.create', compact('program', 'incentiveTypes'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\StoreProgramTierRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreProgramTierRequest $request)
	{
		// dd($request->all());

		// check input field for monthly display
		if ($request->incentive_type_id == IncentiveTypeEnum::PERCENTAGE && $request->monthly_display && $request->cashback > 99) {
			return back()
				->withInput()
				->with('warning', __('message.tiers.failed'));
		}

		// If program type is DISPLAY
		if ($request->type_id == ProgramTypeEnum::REGULAR) {
			ProgramTier::create([
				'program_id'        => $request->program_id,
				'incentive_type_id' => $request->incentive_type_id,
				'name'              => $request->name,
				'display'           => $request->display,
				'monthly_display'   => $request->monthly_display,
				'monthly_volume'    => $request->monthly_volume,
			]);
		}

		// if program type is VOLUME
		if ($request->type_id == ProgramTypeEnum::SESSIONAL) {
			ProgramTier::Create([
				'program_id'        => $request->program_id,
				'name'              => $request->name,
				'incentive_type_id' => $request->incentive_type_id,
				'minimum_pcs'       => $request->minimum_pcs,
				'maximum_pcs'       => $request->maximum_pcs,
				'minimum_purchase'  => $request->minimum_purchase,
				'maximum_purchase'  => $request->maximum_purchase,
				'cashback'          => $request->cashback,
				'monthly_volume'    => $request->monthly_volume,
			]);
		}

		return redirect()
			->route('programs.show', $request->program_id)
			->with('success', __('message.data_saved'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\ProgramTier  $programTier
	 * @return \Illuminate\Http\Response
	 */
	public function show(ProgramTier $programTier)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\ProgramTier  $programTier
	 * @return \Illuminate\Http\Response
	 */
	public function edit(ProgramTier $programTier)
	{
		$incentiveTypes = IncentiveType::all();

		return view('rebate.tiers.edit', compact('programTier', 'incentiveTypes'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\UpdateProgramTierRequest  $request
	 * @param  \App\Models\ProgramTier  $programTier
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateProgramTierRequest $request, ProgramTier $programTier)
	{
		// check input field for monthly display
		if ($request->incentive_type_id == IncentiveTypeEnum::PERCENTAGE && $request->monthly_display > 99) {
			return back()
				->withInput()
				->with('warning', __('message.tiers.data_failed'));
		}

		if ($request->type_id == ProgramTypeEnum::REGULAR) {
			$programTier->update([
				'program_id'        => $request->program_id,
				'incentive_type_id' => $request->incentive_type_id,
				'name'              => $request->name,
				'display'           => $request->display,
				'monthly_display'   => $request->monthly_display,
				'monthly_volume'    => $request->monthly_volume,
			]);
		}

		// if program type is VOLUME
		if ($request->type_id == ProgramTypeEnum::SESSIONAL) {
			$programTier->update([
				'program_id'        => $request->program_id,
				'name'              => $request->name,
				'incentive_type_id' => $request->incentive_type_id,
				'minimum_pcs'       => $request->minimum_pcs,
				'maximum_pcs'       => $request->maximum_pcs,
				'minimum_purchase'  => $request->minimum_purchase,
				'maximum_purchase'  => $request->maximum_purchase,
				'cashback'          => $request->cashback,
				'monthly_volume'    => $request->monthly_volume,
			]);
		}

		return redirect()
			->route('programs.show', $programTier->program->id)
			->with('success', __('message.data_updated'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\ProgramTier  $programTier
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(ProgramTier $programTier)
	{
		$programTier->delete();

		return back()->with('success', __('message.data_deleted'));
	}
}
