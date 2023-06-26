<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAssetCategoryRequest;
use App\Http\Requests\UpdateAssetCategoryRequest;
use App\Http\Resources\AssetCategoryResource;
use App\Models\AssetCategory;
use Illuminate\Support\Facades\DB;

class AssetCategoryControllerApi extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$assetCategories = AssetCategory::orderByDesc('id')->get();

		return AssetCategoryResource::collection($assetCategories);

		// return response()->json($assetCategories);
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(StoreAssetCategoryRequest $request)
	{
		$category = AssetCategory::create(['name' => $request->name]);

		return AssetCategoryResource::make($category)->additional([
			'message' => __('message.data_saved')
		]);
	}

	/**
	 * Display the specified resource.
	 */
	public function show(AssetCategory $category)
	{
		return AssetCategoryResource::make($category);
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(UpdateAssetCategoryRequest $request, AssetCategory $category)
	{
		$category->update(['name' => $request->name]);

		return AssetCategoryResource::make($category)->additional([
			'message' => __('message.data_updated')
		]);
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(AssetCategory $category)
	{
		DB::beginTransaction();

		try {
			$category->delete();

			DB::commit();

			return response()->json([
				'status' => true,
				'message' => __('message.data_deleted')
			]);
		} catch (\Throwable $th) {
			DB::rollBack();

			return response()->json([
				'status' => false,
				'message' => 'Data Failed Deleted'
			]);
		}
	}
}
