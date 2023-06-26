<?php

namespace App\Http\Controllers\Rebate;

use App\Enums\AreaEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProgramRequest;
use App\Http\Requests\UpdateProgramRequest;
use App\Models\FailedImport;
use App\Models\MasterBrand;
use App\Models\Program;
use App\Models\ProgramDetail;
use App\Models\ProgramDisplayType;
use App\Models\ProgramType;
use App\Models\SkuGroup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ProgramController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$programs = Program::with([
			'program_type',
			'program_detail',
			// 'customers',
		])->where('is_active', 1)
			->latest()
			->get();

		return view('rebate.programs.index', compact('programs'));
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		$types = ProgramType::all();

		$areas = AreaEnum::AREA;

		$brands = MasterBrand::all();

		$skuGroups = SkuGroup::all();

		$displayTypes = ProgramDisplayType::all();

		$inventories = DB::table('master_inventories')->get();

		return view('rebate.programs.create', compact('types', 'areas', 'brands', 'skuGroups', 'displayTypes', 'inventories'));
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(StoreProgramRequest $request)
	{
		// dd($request->all());

		try {
			DB::beginTransaction();

			$program = Program::create([
				'area' => $request->area,
				'name' => $request->name,
				'program_type_id' => $request->program_type_id,
				'is_active' => true,
				'valid_from' => $request->valid_from,
				'valid_until' => $request->valid_until,
			]);

			$program->masterInventories()->attach($request->inventoryIds);

			ProgramDetail::create([
				'program_id' => $program->id,
				'master_brand_id' => $request->master_brand_id,
				'program_display_type_id' => $request->program_display_type_id,
				'sku_group_id' => $request->sku_group_id,
				'promo' => $request->promo,
				'depth' => $request->depth,
				'cut_price' => $request->cut_price,
			]);

			DB::commit();

			return redirect()
				->route('programs.index')
				->with('success', __('message.data_saved'));
		} catch (\Throwable $th) {
			DB::rollBack();

			return $th->getMessage();
		}
	}

	/**
	 * Display the specified resource.
	 */
	public function show(Program $program)
	{
		$program->loadCount('customers');

		$inventories = DB::table('program_has_product')
			->join('master_inventories', 'program_has_product.inventory_id', 'master_inventories.InvtID')
			->where('program_has_product.program_id', $program->id)
			->select(
				'program_has_product.inventory_id',
				'master_inventories.Descr',
			)
			->get();

		return view('rebate.programs.show', compact('program', 'inventories'));
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Program $program)
	{
		$types = ProgramType::all();

		$areas = AreaEnum::AREA;

		$brands = MasterBrand::all();

		$skuGroups = SkuGroup::all();

		$displayTypes = ProgramDisplayType::all();

		$inventories = DB::table('master_inventories')->get();

		$programProducts = DB::table('program_has_product')
			->where('program_id', $program->id)
			->get()
			->pluck('inventory_id')
			->toArray();

		$countedProduct = count($programProducts);

		return view(
			'rebate.programs.edit',
			compact(
				'program',
				'types',
				'areas',
				'brands',
				'skuGroups',
				'displayTypes',
				'inventories',
				'programProducts',
				'countedProduct'
			)
		);
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(UpdateProgramRequest $request, Program $program)
	{
		try {
			DB::beginTransaction();

			$program->update([
				'area'        => $request->area,
				'name'        => $request->name,
				'type_id'     => $request->type_id,
				'is_active'   => 1,
				'valid_from'  => $request->valid_from,
				'valid_until' => $request->valid_until,
			]);

			$program->masterInventories()->sync($request->inventoryIds);

			$program->program_detail()->update([
				'master_brand_id' => $request->master_brand_id,
				'program_display_type_id' => $request->program_display_type_id,
				'sku_group_id' => $request->sku_group_id,
				'promo' => $request->promo,
				'depth' => $request->depth,
				'cut_price' => $request->cut_price,
			]);

			DB::commit();

			return redirect()
				->route('programs.index')
				->with('success', __('message.data_updated'));
		} catch (\Throwable $th) {
			DB::rollBack();

			return $th->getMessage();
		}
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Program $program)
	{
		$program->delete();

		$program->masterInventories()->detach();

		return back()->with('success', __('message.data_deleted'));
	}

	public function showCustomers(Program $program)
	{
		$program->loadCount('customers');

		$batchFailedImport = optional(FailedImport::orderByDesc('batch')->first());

		$failedImports = DB::table('failed_imports')
			->where('batch', $batchFailedImport->batch)
			->get();

		return view('rebate.programs.show-customer', compact('program', 'failedImports'));
	}

	public function indexClaimCustomers()
	{
		return view('rebate.imports.claim.index');
	}
}
