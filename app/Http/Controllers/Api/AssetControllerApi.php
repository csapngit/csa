<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAssetRequest;
use App\Http\Resources\AssetResource;
use App\Models\Asset;
use Illuminate\Http\Request;

class AssetControllerApi extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$assets = Asset::query()->latest()->get();

		return AssetResource::collection($assets);
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(StoreAssetRequest $request)
	{
		$asset = Asset::create($this->storeData($request));

		return AssetResource::collection($asset)->additional([
			'message' => __('message.data_saved')
		]);

		//Return json
		// return response()->json($asset);
	}

	/**
	 * Display the specified resource.
	 */
	public function show(Asset $asset)
	{
		return AssetResource::make($asset);
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, Asset $asset)
	{
		$asset->update($this->storeData($request));

		return AssetResource::make($asset)->additional([
			'message' => __('message.data_updated')
		]);
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Asset $asset)
	{
		$asset->delete();

		return response()->json([
			'success' => true,
			'message' => __('message.data_deleted')
		]);
	}

	public function storeData(Request $request)
	{
		$asd = [
			'category_id' => $request->category_id,
			'brand' => $request->brand,
			'serial_number' => $request->serial_number,
			'year' => $request->year,
			'name' => $request->name,
			'division' => $request->division,
			'branch_id' => $request->branch_id,
			'lend_date' => $request->lend_date,
			'return_date' => $request->return_date,
			'description' => $request->description,
		];

		$generateBarcode = rand(10000, 9999999999);

		if ($request->isMethod('POST')) {
			$asd['barcode'] = $generateBarcode;
		}

		return $asd;
	}

	public function exportBarcode(Request $request)
	{
		$barcodeIds = $request->barcodeIds;

		if (!$barcodeIds) {

			$assets = Asset::all();

			return AssetResource::collection($assets);
		}

		$Ids = explode(',', $barcodeIds ?? []);

		$assets = Asset::query()->whereIn('id', $Ids)->latest()->get();

		return AssetResource::collection($assets);
	}
}
