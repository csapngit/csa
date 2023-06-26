<?php

namespace App\Http\Controllers\Itcsa;

use App\Http\Controllers\Controller;
use App\Models\MasterBranch;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AssetController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$url = env('BASE_API') . '/assets';

		$assets = Http::get($url)->json('data');

		return view('itcsa.assets.index', compact('assets'));
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		$url = env('BASE_API') . '/asset-categories';

		$assetCategories = Http::get($url)->json('data');

		$branches = MasterBranch::all();

		return view('itcsa.assets.create', compact('assetCategories', 'branches'));
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
		$url = env('BASE_API') . '/assets';

		$generateBarcode = rand(10000, 9999999);

		$data = Http::post($url, [
			'barcode' => $generateBarcode,
			'category_id' => $request->category_id,
			'brand' => $request->brand,
			'serial_number' => $request->serial_number,
			'year' => $request->year,
			'name' => $request->name,
			'division' => $request->division,
			'branch_id' => $request->branch_id,
			'lend_date' => $request->lend_date,
			'description' => $request->description,
		]);

		return redirect()->route('itcsa.assets.index')->with('success', $data['message']);
	}

	/**
	 * Display the specified resource.
	 */
	public function show($id)
	{
		$url = env('BASE_API') . "/assets/$id";

		$asset = Http::get($url)->json('data');

		return view('itcsa.assets.show', compact('asset'));
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit($id)
	{
		$url = env('BASE_API') . "/assets/$id";

		$asset = Http::get($url)->json('data');

		$urlCategories = env('BASE_API') . '/asset-categories';

		$assetCategories = Http::get($urlCategories)->json('data');

		return view('itcsa.assets.edit', compact('asset', 'assetCategories'));
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, $id)
	{
		$url = env('BASE_API') . "/assets/$id";

		$returnDate = '';

		if ($request->return_date) {
			$returnDate = Carbon::parse($request->return_date)->format('Y-m-d');
		}

		$data = Http::put($url, [
			'category_id' => $request->category_id,
			'brand' => $request->brand,
			'serial_number' => $request->serial_number,
			'year' => $request->year,
			'name' => $request->name,
			'division' => $request->division,
			'lend_date' => Carbon::parse($request->lend_date)->format('Y-m-d'),
			'return_date' => $returnDate,
		]);

		return redirect()->route('itcsa.assets.index')->with('success', $data->json('message'));
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy($id)
	{
		$url = env('BASE_API') . "/assets/$id";

		Http::delete($url);

		return back()->with('success', __('message.data_deleted'));
	}

	public function exportBarcode(Request $request)
	{
		$url = env('BASE_API') . '/assets-barcode';

		$assets = Http::get($url, [
			'barcodeIds' => $request->selectedBarcodes
		])->json('data');

		$pdf = Pdf::loadView('itcsa.assets.barcode.export', compact('assets'));

		return $pdf->stream();
	}
}
