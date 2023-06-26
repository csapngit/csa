<?php

namespace App\Http\Controllers\Rebate;

use App\Enums\AreaEnum;
use App\Enums\IncentiveTypeEnum;
use App\Enums\StatusKeyEnum;
use App\Exports\GeneratesExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\GenerateExportRequest;
use App\Http\Requests\GenerateImportRequest;
use App\Imports\GeneratesImport;
use App\Models\Generate;
use App\Models\Key;
use App\Models\Program;
use App\Models\Tax;
use Illuminate\Http\Request;
use Mavinoo\Batch\BatchFacade as Batch;
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
  public function generate(Request $request)
  {
    // $generates = DB::table('generates')
    //   ->leftjoin('keys', 'generates.key_id', 'keys.id')
    //   ->leftJoin('customers', 'generates.customer_id', 'customers.customer_id')
    //   ->leftJoin('program_tiers', 'customers.program_tier_id', 'program_tiers.id')
    //   ->leftJoin('offtakes', 'generates.customer_id', 'offtakes.customer_id')
    //   ->leftJoin('master_customers', 'generates.customer_id', 'master_customers.CustId')
    //   ->select(
    //     'generates.id',
    //     'master_customers.Branch',
    //     'generates.program_id',
    //     'generates.customer_id',
    //     'master_customers.Name as name',
    //     'master_customers.SlsperId',
    //     'customers.target',
    //     'program_tiers.incentive_type_id',
    //     'program_tiers.monthly_display',
    //     'program_tiers.monthly_volume',
    //     'generates.is_active_display',
    //     'generates.incentive_display',
    //     'generates.incentive_volume',
    //     'master_customers.S4Future11 as pkp',
    //     'generates.tax_display_pkp',
    //     'generates.tax_display_non_pkp',
    //     'generates.tax_volume_pkp',
    //     'generates.tax_volume_non_pkp',
    //     'master_customers.User4 as is_company',
    //     'generates.tax_company',
    //     'offtakes.totmerch',
    //   )
    //   ->where('keys.status_active', StatusKeyEnum::OPEN)
    //   ->get();

    // $generates = $generates->groupBy(['program_id', 'customer_id'])->toArray();

    $generates = DB::select("
    select c.*, o.*, m.Branch, m.User4, m.S4Future11, m.Name, m.SlsperId from customers c left join
    master_customers m on c.customer_id = m.CustId left join
    (select distinct
    month_date,
    customer_id,
    PGWW = sum(pgww),
    TotMerch=sum(Totmerch),
    TotInvc=sum(TotInv)
    from offtakes (nolock) group by month_date, customer_id) O on c.customer_id = o.customer_id");

    dd($generates);

    $generateData = [];

    $tax = Tax::first();

    foreach ($generates as $keyProgram => $programs) {

      foreach ($programs as $customer_id => $generate) {

        $customerId = $customer_id;

        $totmerch            = 0;
        $incentive_volume    = 0;
        $incentive_display   = 0;
        $tax_display_pkp     = 0;
        $tax_display_non_pkp = 0;
        $tax_company         = 0;
        $tax_volume_pkp      = 0;
        $tax_volume_non_pkp  = 0;

        foreach ($generate as $data) {

          $totmerch += $data->totmerch;

          // Calculate volume incentive
          if ($totmerch >= $data->target) {
            $incentive_volume = ($data->monthly_volume / 100) * $totmerch;

            /**
             * company = 1
             * pkp     = 1
             */
            if ($data->is_company && $data->pkp) {
              $tax_company = ($tax->company / 100) * $incentive_volume;
            }

            /**
             * company = 0
             * pkp     = 1
             */
            if (!$data->is_company && $data->pkp) {
              $tax_volume_pkp = ($tax->volume_pkp / 100) * $incentive_volume;
            }

            /**
             * company = 1
             * pkp     = 0
             */
            if ($data->is_company && !$data->pkp) {
              $tax_volume_non_pkp = ($tax->volume_non_pkp / 100) * $incentive_volume;
            }

            /**
             * company = 0
             * pkp     = 0
             */
            if (!$data->is_company && !$data->pkp) {
              $tax_volume_non_pkp = ($tax->volume_non_pkp / 100) * $incentive_volume;
            }
          } else {
            $incentive_volume = 0;
          }

          // Calculate display incentive with percentage
          if ($data->is_active_display && $data->incentive_type_id == IncentiveTypeEnum::PERCENTAGE) {
            $incentive_display = ($data->monthly_display / 100) * $totmerch;

            if ($data->pkp) {
              $tax_display_pkp = ($tax->display_pkp / 100) * $incentive_display;
            } else {
              $tax_display_non_pkp = ($tax->display_non_pkp / 100) * $incentive_display;
            }
          }

          // Calculate display incentive with nominal
          if ($data->is_active_display && $data->incentive_type_id == IncentiveTypeEnum::NOMINAL) {
            $incentive_display = $data->monthly_display;

            if ($data->pkp) {
              $tax_display_pkp = ($tax->display_pkp / 100) * $incentive_display;
            } else {
              $tax_display_non_pkp = ($tax->display_non_pkp / 100) * $incentive_display;
            }
          }
        }

        $generateData[$keyProgram][] = [
          'id'                  => $data->id,
          'program_id'          => $data->program_id,
          'master_branch_id'    => $data->Branch,
          'customer_id'         => $customerId,
          'name'                => trim($data->name),
          'sales_person'        => trim($data->SlsperId),
          'target'              => $data->target,
          'offtakes'            => $totmerch,
          'incentive_display'   => $incentive_display,
          'incentive_volume'    => $incentive_volume,
          'pkp'                 => $data->pkp,
          'tax_display_pkp'     => $tax_display_pkp,
          'tax_display_non_pkp' => $tax_display_non_pkp,
          'tax_volume_pkp'      => $tax_volume_pkp,
          'tax_volume_non_pkp'  => $tax_volume_non_pkp,
          'is_company'          => $data->is_company,
          'tax_company'         => $tax_company,
        ];
      }
    }

    dd($generateData);

    $generateInstance = new Generate;

    $generateData = collect($generateData)->chunk(500)->toArray();

    $index = 'id';

    foreach ($generateData as $data) {

      foreach ($data as $value) {
        Batch::update($generateInstance, $value, $index);
      }
    }

    return back()->with('success', __('message.generate.success'));
  }

  public function export(GenerateExportRequest $request)
  {
    return Excel::download(new GeneratesExport, 'Generate-Export-Final.xlsx');
  }
}
