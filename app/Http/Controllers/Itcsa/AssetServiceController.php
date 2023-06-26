<?php

namespace App\Http\Controllers\Itcsa;

use App\Enums\LogEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAssetServiceRequest;
use App\Http\Requests\UpdateAssetServiceRequest;
use App\Models\Asset;
use App\Models\AssetService;
use App\Models\Logger;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AssetServiceController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$assets = Asset::all();

		$assetServices = AssetService::all();

		return view('itcsa.assets.services.index', compact('assetServices', 'assets'));
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
	public function store(StoreAssetServiceRequest $request)
	{
		$data = $request->all();

		unset($data['_token']);

		$dataJson = json_encode($data);

		try {
			DB::beginTransaction();

			$service = AssetService::create([
				'asset_id' => $request->asset_id,
				'service_date' => $request->service_date,
				'description' => $request->description,
			]);

			DB::commit();

			Logger::create([
				'reference_id' => $service->id,
				'reference_type' => LogEnum::ASSET_SERVICE,
				'action' => LogEnum::CREATE,
				'executor_id' => auth()->user()->id,
				'data' => $dataJson,
				'executed_at' => $service->created_at,
			]);

			return back()->with('success', __('message.data_saved'));
		} catch (\Throwable $th) {
			DB::rollBack();

			return back()->with('warning', __('message.data_warning'));
		}
	}

	/**
	 * Display the specified resource.
	 */
	public function show(AssetService $assetService)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(AssetService $assetService)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(UpdateAssetServiceRequest $request, AssetService $assetService)
	{
		$data = $request->all();

		unset($data['_token']);

		$dataJson = json_encode($data);

		try {
			DB::beginTransaction();

			$serviceDate = $request->service_date;

			$returnDate = $request->return_date;

			if (Carbon::parse($returnDate)->lt($serviceDate)) {
				return back()->with('warning', __('message.itcsa.services.failed'));
			}

			$assetService->update([
				'asset_id' => $request->asset_id,
				'service_date' => $request->service_date,
				'description' => $request->description,
				'return_date' => $request->return_date,
			]);

			DB::commit();

			Logger::create([
				'reference_id' => $assetService->id,
				'reference_type' => LogEnum::ASSET_SERVICE,
				'action' => LogEnum::UPDATE,
				'executor_id' => auth()->user()->id,
				'data' => $dataJson,
				'executed_at' => $assetService->created_at,
			]);

			return back()->with('success', __('message.data_updated'));
		} catch (\Throwable $th) {
			DB::rollBack();

			return back()->with('warning', __('message.data_warning'));
		}
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(AssetService $assetService)
	{
		$dataJson = json_encode([
			'id' => $assetService->id,
			'asset_id' => $assetService->asset_id,
			'service_date' => $assetService->service_date->format('Y-m-d'),
			'description' => $assetService->description,
			'return_date' => optional($assetService->return_date)->format('Y-m-d'),
		]);

		try {
			DB::beginTransaction();

			$assetService->delete();

			DB::commit();

			Logger::create([
				'reference_id' => $assetService->id,
				'reference_type' => LogEnum::ASSET_SERVICE,
				'action' => LogEnum::DELETE,
				'executor_id' => auth()->user()->id,
				'data' => $dataJson,
				'executed_at' => $assetService->deleted_at,
			]);

			return back()->with('success', __('message.data_deleted'));
		} catch (\Throwable $th) {
			DB::rollBack();

			return back()->with('warning', __('message.data_warning'));
		}
	}
}
