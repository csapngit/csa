<?php

namespace App\Http\Controllers\Rebate;

use App\Enums\AreaEnum;
use App\Enums\StatusKeyEnum;
use App\Http\Controllers\Controller;
use App\Models\VoucherPublish;
use App\Http\Requests\StoreVoucherPublishRequest;
use App\Http\Requests\UpdateVoucherPublishRequest;
use App\Models\Generate;
use App\Models\Key;
use Illuminate\Support\Facades\DB;

class VoucherPublishController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$areas = AreaEnum::AREA;

		return view('rebate.publishes.index', compact('areas'));
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(StoreVoucherPublishRequest $request)
	{
		$area        = $request->area;

		$customerIds = $request->collect('customer_id')->keys()->all();

		$updateKey = Key::query()
			->where('name', 'like', $area . '%')
			->where('status_um', true)
			->where('status_rm', true);

		switch ($request->action) {
			case 'submit':
				DB::beginTransaction();
				try {
					DB::table('generates')
						->where('area', $area)
						->whereIn('customer_id', $customerIds)
						->update([
							'voucher_publish' => StatusKeyEnum::ACTIVE,
							'start_date'      => $request->start_date,
							'end_date'        => $request->end_date
						]);

					$updateKey
						->where('status_active', StatusKeyEnum::OPEN)
						->update([
							'status_active' => StatusKeyEnum::PUBLISH
						]);

					$updateKey
						->where('status_active', StatusKeyEnum::PUBLISH)
						->update([
							'status_active' => StatusKeyEnum::CLOSE
						]);

					DB::commit();

					return back()->with('success', __('message.data_updated'));
				} catch (\Throwable $th) {
					DB::rollBack();

					return back()->with('danger', __('message.data_warning'));
				}
				break;

			case 'publish_all':
				DB::beginTransaction();
				try {
					DB::table('generates')
						->where('area', $area)
						->update([
							'voucher_publish' => StatusKeyEnum::ACTIVE,
							'start_date'      => $request->start_date,
							'end_date'        => $request->end_date
						]);

					$updateKey
						->where('status_active', StatusKeyEnum::OPEN)
						->update([
							'status_active' => StatusKeyEnum::PUBLISH
						]);

					$updateKey
						->where('status_active', StatusKeyEnum::PUBLISH)
						->update([
							'status_active' => StatusKeyEnum::CLOSE
						]);

					DB::commit();

					return back()->with('success', __('message.data_updated'));
				} catch (\Throwable $th) {
					DB::rollBack();

					return back()->with('danger', __('message.data_warning'));
				}
				break;
		}
	}

	/**
	 * Display the specified resource.
	 */
	public function show(VoucherPublish $voucherPublish)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(VoucherPublish $voucherPublish)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(UpdateVoucherPublishRequest $request, VoucherPublish $voucherPublish)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(VoucherPublish $voucherPublish)
	{
		//
	}

	public function getListVouchers($area)
	{
		$results = DB::table('generates')
			->leftJoin('keys', 'generates.key_id', 'keys.id')
			->select('generates.*')
			->where('area', $area)
			->where('keys.status_active', StatusKeyEnum::OPEN)
			->get();

		return $results;
	}
}
