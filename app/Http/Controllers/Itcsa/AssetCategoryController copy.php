<?php

namespace App\Http\Controllers\Itcsa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AssetCategoryController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$url = env('BASE_API') . '/asset-categories';

		$categories = Http::get($url)->json('data');

		// $categories = json_decode(json_encode($categories));

		// dd($categories);

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
	public function store(Request $request)
	{
		$url = env('BASE_API') . '/asset-categories';

		$data = Http::post($url, [
			'name' => $request->name
		]);

		return redirect()->route('itcsa.asset.categories')->with('success', $data->json('message'));
	}

	/**
	 * Display the specified resource.
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit($id)
	{
		$url = env('BASE_API') . "/asset-categories/$id";

		$category = Http::get($url)->json('data');

		return view('itcsa.assets.categories.edit', compact('category'));
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, $id)
	{
		$url = env('BASE_API') . "/asset-categories/$id";

		$data = Http::put($url, [
			'name' => $request->name
		]);

		return redirect()->route('itcsa.asset.categories')->with('success', $data['message']);
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy($id)
	{
			$url = env('BASE_API') . "/asset-categories/$id";

			$data = Http::delete($url);

			if ($data->json('status') == false) {
				return back()->with('warning', 'Cannot delete this data because constrained in Assets');
			} else {
				return back()->with('success', __('message.data_deleted'));
			}

	}
}
