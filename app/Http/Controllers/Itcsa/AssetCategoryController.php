<?php

namespace App\Http\Controllers\Itcsa;

use App\Enums\LogEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAssetCategoryRequest;
use App\Http\Requests\UpdateAssetCategoryRequest;
use App\Models\AssetCategory;
use App\Models\Logger;
use Illuminate\Support\Facades\DB;

class AssetCategoryController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$categories = AssetCategory::query()->latest()->get();

		return view('itcsa.assets.categories.index', compact('categories'));
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		return view('itcsa.assets.categories.create');
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(StoreAssetCategoryRequest $request)
	{
		$dataJson = json_encode($request->validated());

		try {
			DB::beginTransaction();

			$assetCategory = AssetCategory::create(['name' => $request->name]);

			DB::commit();

			Logger::create([
				'reference_id' => $assetCategory->id,
				'reference_type' => LogEnum::ASSET_CATEGORY,
				'action' => LogEnum::CREATE,
				'executor_id' => auth()->user()->id,
				'data' => $dataJson,
				'executed_at' => $assetCategory->created_at,
			]);

			return redirect()->route('itcsa.asset.categories')->with('success', __('message.data_saved'));
		} catch (\Throwable $th) {
			DB::rollBack();

			return redirect()->route('itcsa.asset.categories')->with('warning', __('message.data_warning'));
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(AssetCategory $assetCategory)
	{
		return view('itcsa.assets.categories.edit', compact('assetCategory'));
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(UpdateAssetCategoryRequest $request, AssetCategory $assetCategory)
	{
		$dataJson = json_encode($request->validated());

		try {
			DB::beginTransaction();

			$assetCategory->update(['name' => $request->name]);

			DB::commit();

			Logger::create([
				'reference_id' => $assetCategory->id,
				'reference_type' => LogEnum::ASSET_CATEGORY,
				'action' => LogEnum::UPDATE,
				'executor_id' => auth()->user()->id,
				'data' => $dataJson,
				'executed_at' => $assetCategory->updated_at,
			]);

			return redirect()->route('itcsa.asset.categories')->with('success', __('message.data_updated'));
		} catch (\Throwable $th) {
			DB::rollBack();

			return redirect()->route('itcsa.asset.categories')->with('warning', __('message.data_warning'));
		}
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(AssetCategory $assetCategory)
	{
		$dataJson = json_encode([
			'id' => $assetCategory->id,
			'name' => $assetCategory->name,
		]);

		$hasRelation = count($assetCategory->assets);

		try {
			DB::beginTransaction();

			if ($hasRelation == 0) {
				$assetCategory->delete();

				DB::commit();

				Logger::create([
					'reference_id' => $assetCategory->id,
					'reference_type' => LogEnum::ASSET_CATEGORY,
					'action' => LogEnum::DELETE,
					'executor_id' => auth()->user()->id,
					'data' => $dataJson,
					'executed_at' => $assetCategory->deleted_at,
				]);

				return back()->with('success', __('message.data_deleted'));
			} else {
				return back()->with('warning', 'Cannot delete this data because constrained in Assets');
			}
		} catch (\Throwable $th) {
			DB::rollBack();

			return $th->getMessage();

			return back()->with('warning', 'Cannot delete this data because constrained in Assets');
		}
	}
}
