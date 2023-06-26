<?php

namespace App\Imports;

use App\Enums\StatusKeyEnum;
use App\Models\Generate;
use App\Models\Key;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class GeneratesImport implements ToCollection, WithHeadingRow, WithMultipleSheets
{
  /**
   * Import data from the second sheet
   *
   * The previous[0] sheet is Customers Import
   */
  public function sheets(): array
  {
    return [
      'generate_customers' => new GeneratesImport(),
    ];
  }

  public function collection(Collection $rows)
  {
    $programId = request()->program_id;

    $area      = request()->area;

    // get collection excel data
    $excelData = collect($rows->toArray());

    // get customer Id from excel data
    $excelCustomerIds = $excelData->pluck('customer_id');

    // get customer Id from table customers
    $customers = DB::table('customers')
      ->where('program_id', $programId)
      ->pluck('customer_id')->toArray();

    // check customer id between excel data and table customers
    $diffCustomers = collect($excelCustomerIds)->diff($customers);

    $now = now();

    if ($diffCustomers->first()) {
      return session()->flash('warning', __('message.data_warning'));
    }

    if ($excelCustomerIds->first()) {

      // Get date for key date
      $dateKey = Carbon::now()->format('Y-m-d');
      // $dateKey = '2022-10-01';

      $dateKey = explode('-', $dateKey);

      $year = $dateKey[0];

      $month = $dateKey[1];

      // $date = $dateKey[2];

      $dateKey = $area . '-' . $year . $month;

      $key = Key::updateOrCreate([
        'name'          => $dateKey,
        'status_active' => StatusKeyEnum::OPEN,
      ]);

      $excelData = $excelData->whereIn('customer_id', $excelCustomerIds)->toArray();

      $dataToCreate = [];

      foreach ($excelData as $row) {

        $currentData = DB::table('generates')
          ->where('key_id', $key->id)
          ->where('customer_id', $row['customer_id'])
          ->where('program_id', $programId);

        if ($currentData->first()) {
          $dataToUpdate = [
            'area'              => $area,
            'key_id'            => $key->id,
            'program_id'        => $programId,
            'customer_id'       => $row['customer_id'],
            'is_active_display' => $row['display_active'],
            'created_at'        => $now,
            'updated_at'        => $now,
          ];

          $dataToUpdate = collect($dataToUpdate)->chunk(500)->toArray();

          foreach ($dataToUpdate as $data) {
            $currentData->update($data);
          }
        } else {
          $dataToCreate[] = [
            'area'              => $area,
            'key_id'            => $key->id,
            'program_id'        => $programId,
            'customer_id'       => $row['customer_id'],
            'is_active_display' => $row['display_active'],
            'created_at'        => $now,
            'updated_at'        => $now,
          ];
        }
      }

      $dataToCreate = collect($dataToCreate)->chunk(500)->toArray();

      foreach ($dataToCreate as $data) {
        DB::table('generates')->insert($data);
      }

      return session()->flash('success', __('message.data_uploaded'));
    }
  }
}
