<?php

namespace App\Http\Controllers\Rebate;

use App\Enums\AreaEnum;
use App\Enums\IncentiveTypeEnum;
use App\Enums\ProgramTypeEnum;
use App\Enums\StatusKeyEnum;
use App\Exports\GeneratesExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\GenerateCalculateRequest;
use App\Http\Requests\GenerateExportRequest;
use App\Http\Requests\GenerateImportRequest;
use App\Imports\GeneratesImport;
use App\Models\Generate;
use App\Models\Key;
use App\Models\Program;
use App\Models\ProgramTier;
use App\Models\Tax;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class GenerateController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$programs = Program::all();

		$areas = AreaEnum::AREA;

		$keys = Key::all();

		return view('rebate.generates.index', compact('programs', 'keys', 'areas'));
	}

	/**
	 * Import file for generate calculate data Customer
	 */
	public function import(GenerateImportRequest $request)
	{
		Excel::import(new GeneratesImport, $request->generateFile);

		return back();
	}

	/**
	 * Handle the incoming request.
	 */
	public function generate(GenerateCalculateRequest $request)
	{
		$area = $request->area;

		$generates = DB::table('customers')
			->leftJoin('displays', 'customers.customer_id', 'displays.customer_id')
			->leftJoin('master_customers', 'customers.customer_id', 'master_customers.CustId')
			->leftJoin('program_tiers', 'customers.program_tier_id', 'program_tiers.id')
			->leftJoin('offtakes', 'customers.customer_id', 'offtakes.customer_id')
			->leftJoin('programs', 'customers.program_id', 'programs.id')
			->select([
				'master_customers.Branch',
				'customers.program_id',
				'programs.type_id',
				'programs.valid_from',
				'customers.customer_id',
				'master_customers.Name as name',
				'customers.target',
				'master_customers.SlsperId',
				'customers.program_tier_id',
				'program_tiers.incentive_type_id',
				'displays.psku',
				'program_tiers.monthly_display',
				'program_tiers.monthly_volume',
				'master_customers.User4 as is_company',
				'master_customers.S4Future11 as pkp',
				'offtakes.totmerch',
				'offtakes.sku_code',
				'offtakes.month_date',
				'customers.can_publish'
			])
			->where('customers.program_id', $request->program_id)
			->get();

		$getTypeId = $generates->first();

		if ($getTypeId->type_id == ProgramTypeEnum::REGULAR) {
			return $this->generateRegular($area, $generates);
		} else {
			return $this->generateSessional($area, $generates);
		}
	}

	public function generateRegular($area, Collection $data)
	{
		$dateOfftake = Carbon::now()->subMonth()->format('Ym');

		$dataCustomers = $data
			->where('month_date', $dateOfftake)
			->groupBy('customer_id')
			->toArray();

		try {
			DB::beginTransaction();

			$generateData = [];

			$tax = Tax::first();

			foreach ($dataCustomers as $customer_id => $generate) {

				$customerIds = $customer_id;

				$totMerch            = 0;
				$incentive_display   = 0;
				$incentive_volume    = 0;
				$tax_display_pkp     = 0;
				$tax_display_non_pkp = 0;
				$tax_volume_pkp      = 0;
				$tax_volume_non_pkp  = 0;
				$tax_company         = 0;

				foreach ($generate as $data) {

					$totMerch += $data->totmerch;

					$pkp = (int) $data->pkp;

					$is_company = (int) $data->is_company;

					// Calculate volume incentive
					if ($totMerch >= $data->target) {
						$incentive_volume = ($data->monthly_volume / 100) * $totMerch;

						/**
						 * company = 1
						 * pkp     = 1
						 */
						if ($is_company && $pkp) {
							$tax_company = ($tax->company / 100) * $incentive_volume;
						}

						/**
						 * company = 0
						 * pkp     = 1
						 */
						if (!$is_company && $pkp) {
							$tax_volume_pkp = ($tax->volume_pkp / 100) * $incentive_volume;
						}

						/**
						 * company = 1
						 * pkp     = 0
						 */
						if ($is_company && !$pkp) {
							$tax_volume_non_pkp = ($tax->volume_non_pkp / 100) * $incentive_volume;
						}

						/**
						 * company = 0
						 * pkp     = 0
						 */
						if (!$is_company && !$pkp) {
							$tax_volume_non_pkp = ($tax->volume_non_pkp / 100) * $incentive_volume;
						}
					} else {
						$incentive_volume = 0;
					}

					// Calculate display incentive with percentage
					if ($data->psku && $data->incentive_type_id == IncentiveTypeEnum::PERCENTAGE) {
						$incentive_display = ($data->monthly_display / 100) * $data->TotMerch;

						if ($pkp) {
							$tax_display_pkp = ($tax->display_pkp / 100) * $incentive_display;
						} else {
							$tax_display_non_pkp = ($tax->display_non_pkp / 100) * $incentive_display;
						}
					}

					// Calculate display incentive with nominal
					if ($data->psku && $data->incentive_type_id == IncentiveTypeEnum::NOMINAL) {
						$incentive_display = $data->monthly_display;

						if ($pkp) {
							$tax_display_pkp = ($tax->display_pkp / 100) * $incentive_display;
						} else {
							$tax_display_non_pkp = ($tax->display_non_pkp / 100) * $incentive_display;
						}
					}
				}

				$generateData[] = [
					'area'                => $area,
					'key_id'              => $this->createKey($area)->id,
					'program_id'          => $data->program_id,
					'master_branch_id'    => $data->Branch,
					'customer_id'         => trim($customerIds),
					'name'                => trim($data->name),
					'sales_person'        => trim($data->SlsperId),
					'target'              => $data->target,
					'offtakes'            => $totMerch,
					'is_active_display'   => $data->psku ?? 0,
					'incentive_display'   => $incentive_display,
					'incentive_volume'    => (float) $incentive_volume,
					'pkp'                 => $pkp,
					'tax_display_pkp'     => $tax_display_pkp,
					'tax_display_non_pkp' => $tax_display_non_pkp,
					'tax_volume_pkp'      => $tax_volume_pkp,
					'tax_volume_non_pkp'  => (float) $tax_volume_non_pkp,
					'is_company'          => $is_company,
					'tax_company'         => $tax_company,
					'printed'             => 0,
					'can_publish'         => $data->can_publish,
				];
			}

			Generate::insert($generateData);

			DB::commit();

			return back()->with('success', __('message.generate.success'));
		} catch (\Exception $e) {
			DB::rollBack();

			return $e->getMessage();

			// return back()->with('warning', __('message.data_warning'));
		}
	}

	public function generateSessional($area, Collection $data)
	{
		$products = Program::with('masterInventories')->where('id', request()->program_id)->get();

		$productIds = [];

		foreach ($products as $product) {
			foreach ($product->masterInventories as $asd) {
				$productIds[] = trim($asd->InvtID);
			}
		}

		$query = Program::query()->where('id', request()->program_id);

		$validFrom = $query->value('valid_from')->format('Ym');

		$validUntil = $query->value('valid_until')->format('Ym');

		$dataCustomers = $data
			->whereBetween('month_date', [$validFrom, $validUntil])
			->whereIn('sku_code', $productIds)
			->groupBy('customer_id')
			->toArray();

		$programTiers = ProgramTier::query()
			->where('program_id', request()->program_id)
			->orderBy('minimum_purchase')
			->get([
				'id',
				'name',
				'minimum_purchase',
				'cashback',
			])
			->toArray();

		try {
			DB::beginTransaction();

			$generateDataSessional = [];

			foreach ($dataCustomers as $customer_id => $generate) {

				$customerIds = $customer_id;

				$totMerch            = 0;
				$incentive_volume    = 0;
				$tax_volume_pkp      = 0;
				$tax_volume_non_pkp  = 0;
				$tax_company         = 0;

				foreach ($generate as $data) {
					$totMerch += $data->totmerch;

					$pkp = (int) $data->pkp;

					$is_company = (int) $data->is_company;

					foreach ($programTiers as $programTier) {
						if ($totMerch >= $programTier['minimum_purchase']) {
							$incentive_volume = ($programTier['cashback'] / 100) * $totMerch;
						}
					}
				}

				$generateDataSessional[] = [
					'area'                => $area,
					'key_id'              => $this->createKey($area)->id,
					'program_id'          => $data->program_id,
					'master_branch_id'    => $data->Branch,
					'customer_id'         => trim($customerIds),
					'name'                => trim($data->name),
					'sales_person'        => trim($data->SlsperId),
					'target'              => $data->target,
					'offtakes'            => $totMerch,
					'is_active_display'   => 0,
					'incentive_display'   => 0,
					'incentive_volume'    => (float) $incentive_volume,
					'pkp'                 => $pkp,
					'tax_display_pkp'     => 0,
					'tax_display_non_pkp' => 0,
					'tax_volume_pkp'      => $tax_volume_pkp,
					'tax_volume_non_pkp'  => $tax_volume_non_pkp,
					'is_company'          => $is_company,
					'tax_company'         => $tax_company,
					'printed'             => 0,
					'can_publish'         => $data->can_publish,
				];
			}

			Generate::insert($generateDataSessional);

			DB::commit();

			return back()->with('success', __('message.generate.success'));
		} catch (\Exception $e) {
			DB::rollBack();

			return $e->getMessage();

			// return back()->with('warning', __('message.data_warning'));
		}
	}

	public function createKey($area)
	{
		// Get date for key date
		$dateKey = Carbon::now()->format('Y-m-d');

		$dateKey = explode('-', $dateKey);

		$year = $dateKey[0];

		$month = $dateKey[1];

		// $date = $dateKey[2];

		$dateKey = $area . '-' . $year . $month;

		$key = Key::updateOrCreate([
			'name'          => $dateKey,
			'status_active' => StatusKeyEnum::OPEN,
		]);

		return $key;
	}

	public function export(GenerateExportRequest $request)
	{
		return Excel::download(new GeneratesExport, 'Generate-Export-Final.xlsx');
	}
}
