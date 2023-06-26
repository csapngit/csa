<?php

namespace App\Http\Controllers\Itcsa;

use App\Enums\LogEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAssetRequest;
use App\Http\Requests\UpdateAssetRequest;
use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\AssetService;
use App\Models\Division;
use App\Models\Logger;
use App\Models\MasterBranch;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssetController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$jakartaAssets = $this->getAssetArea('CSAJ');

		$sumatraAssets = $this->getAssetArea('CSAS');

		$assetForServices = DB::table('assets')
			->leftJoin('asset_services', 'assets.id', 'asset_services.asset_id')
			->where('assets.deleted_at', NULL)
			->orderByDesc('assets.id')
			->select(
				'assets.id',
				'assets.barcode',
				'assets.brand',
				'asset_services.service_date',
				'asset_services.return_date',
			)
			->get();

		return view('itcsa.assets.index', compact('jakartaAssets', 'sumatraAssets', 'assetForServices'));
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		$assetCategories = AssetCategory::all();

		$branches = MasterBranch::all();

		$divisions = Division::all();

		return view('itcsa.assets.create', compact(
			'assetCategories',
			'branches',
			'divisions'
		));
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(StoreAssetRequest $request)
	{
		$purchase_date = Carbon::parse($request->purchase_date);

		$lend_date = Carbon::parse($request->lend_date);

		if ($lend_date->lt($purchase_date)) {
			return back()
			->withInput()
			->with('warning', __('message.itcsa.assets.failed_lend_date'));
		}

		$data = $request->all();

		unset($data['_token']);

		$dataJson = json_encode($data);

		DB::beginTransaction();

		// if ($request->lend_date) {
		// 	# code...
		// }

		try {

			$generateBarcode = rand(10000, 9999999);

			$asset = Asset::create([
				'barcode' => $generateBarcode,
				'category_id' => $request->category_id,
				'brand' => $request->brand,
				'serial_number' => $request->serial_number,
				'purchase_date' => $request->purchase_date,
				'name' => $request->name,
				'division_id' => $request->division_id,
				'branch_id' => $request->branch_id,
				'lend_date' => $request->lend_date,
				'description' => $request->description,
			]);

			DB::commit();

			Logger::create([
				'reference_id' => $asset->id,
				'reference_type' => LogEnum::ASSET,
				'action' => LogEnum::CREATE,
				'executor_id' => auth()->user()->id,
				'data' => $dataJson,
				'executed_at' => $asset->created_at,
			]);

			return redirect()->route('itcsa.assets.index')->with('success', __('message.data_saved'));
		} catch (\Throwable $th) {
			DB::rollBack();

			return redirect()->route('itcsa.assets.index')->with('warning', __('message.data_warning'));
		}
	}

	/**
	 * Display the specified resource.
	 */
	public function show(Asset $asset)
	{
		return view('itcsa.assets.show', compact('asset'));
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Asset $asset)
	{
		$asset = $asset->toArray();

		$assetCategories = AssetCategory::all()->toArray();

		$branches = MasterBranch::all()->toArray();

		$divisions = Division::all()->toArray();

		return view('itcsa.assets.edit', compact(
			'asset',
			'assetCategories',
			'branches',
			'divisions',
		));
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(UpdateAssetRequest $request, Asset $asset)
	{
		$data = $request->all();

		unset($data['_token']);

		$dataJson = json_encode($data);

		DB::beginTransaction();

		try {

			$lendDate = Carbon::parse($request->lend_date);

			$returnDate = null;

			if ($request->return_date) {
				$returnDate = Carbon::parse($request->return_date);
			}

			if (optional($returnDate)->lt($lendDate)) {
				return back()->with('warning', __('message.itcsa.assets.failed_return_date'));
			}

			$asset->update([
				'category_id' => $request->category_id,
				'brand' => $request->brand,
				'serial_number' => $request->serial_number,
				'purchase_date' => Carbon::parse($request->purchase_date)->format('Y-m-d'),
				'name' => $request->name,
				'division_id' => $request->division_id,
				'branch_id' => $request->branch_id,
				'lend_date' => $lendDate->format('Y-m-d'),
				'return_date' => $returnDate,
				'description' => $request->description,
			]);

			DB::commit();

			Logger::create([
				'reference_id' => $asset->id,
				'reference_type' => LogEnum::ASSET,
				'action' => LogEnum::UPDATE,
				'executor_id' => auth()->user()->id,
				'data' => $dataJson,
				'executed_at' => $asset->created_at,
			]);

			return redirect()->route('itcsa.assets.index')->with('success', __('message.data_updated'));
		} catch (\Throwable $th) {
			DB::rollBack();

			return redirect()->route('itcsa.assets.index')->with('success', __('message.data_warning'));
		}
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Asset $asset)
	{
		$dataJson = json_encode([
			'id' => $asset->id,
			'barcode' => $asset->barcode,
			'category_id' => $asset->category_id,
			'brand' => $asset->brand,
			'serial_number' => $asset->serial_number,
			'purchase_date' => $asset->purchase_date->format('Y-m-d'),
			'name' => $asset->name,
			'division_id' => $asset->division_id,
			'branch_id' => $asset->branch_id,
			'lend_date' => $asset->lend_date->format('Y-m-d'),
			'description' => $asset->description,
			'return_date' => optional($asset->return_date)->format('Y-m-d'),
		]);

		try {
			DB::beginTransaction();

			$asset->delete();

			AssetService::query()->where('asset_id', $asset->id)->delete();

			DB::commit();

			Logger::create([
				'reference_id' => $asset->id,
				'reference_type' => LogEnum::ASSET,
				'action' => LogEnum::DELETE,
				'executor_id' => auth()->user()->id,
				'data' => $dataJson,
				'executed_at' => $asset->deleted_at,
			]);

			return back()->with('success', __('message.data_deleted'));
		} catch (\Throwable $th) {
			DB::rollBack();

			return back()->with('warning', __('message.data_warning'));
		}
	}

	public function exportBarcode(Request $request)
	{
		$barcodeIds = $request->selectedBarcodes;

		$ids = explode(',', $barcodeIds ?? '');

		// $assets = Asset::query()->whereIn('id', $ids)->latest()->get();

		$assets = DB::table('assets')->whereIn('id', $ids)->latest()->get();

		// dd($assets);

		$pdf = Pdf::loadView('itcsa.assets.barcode.export', compact('assets'));

		return $pdf->stream();
	}

	/**
	 * get Area with choice only: CSAJ|CSAS
	 */
	public function getAssetArea(string $area)
	{
		$assets = DB::table('assets')
			->join('asset_categories', 'assets.category_id', 'asset_categories.id')
			->join('divisions', 'assets.division_id', 'divisions.id')
			->join('master_branches', 'assets.branch_id', 'master_branches.id')
			->select(
				'assets.id',
				'master_branches.Area',
				'assets.barcode',
				'asset_categories.name as category_name',
				'assets.brand',
				'assets.serial_number',
				'assets.purchase_date',
				'assets.name as asset_name',
				'divisions.name as division_name',
				'master_branches.BranchName',
				'assets.lend_date',
				'assets.return_date',
				'assets.description',
				'assets.deleted_at',
			)
			->where('master_branches.Area', $area)
			->where('assets.deleted_at', null)
			->orderByDesc('assets.id')
			->get();

		return $assets;
	}
}
