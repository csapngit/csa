<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GeneratesExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithStrictNullComparison
{
  public function collection()
  {
    $area      = request()->area;
    $programId = request()->program_id;
    $keyId     = request()->key_id;

    $generates = DB::table('generates')
      ->select(
        'generates.area',
        'generates.customer_id',
        'generates.name',
        'generates.target',
        'generates.offtakes',
        'generates.is_active_display',
        'generates.incentive_display',
        'generates.incentive_volume',
        'generates.pkp',
        'generates.tax_display_pkp',
        'generates.tax_display_non_pkp',
        'generates.tax_volume_pkp',
        'generates.tax_volume_non_pkp',
        'generates.is_company',
        'generates.tax_company',
        'generates.voucher_publish'
      )
      ->where('generates.area', $area)
      ->where('generates.program_id', $programId)
      ->where('generates.key_id', $keyId)
      ->get();

    $data = [];

    $generates = $generates->unique('customer_id')->map(function ($generate) use (&$data) {

      $incentive_display_nett = $generate->incentive_display - $generate->tax_display_pkp - $generate->tax_display_non_pkp;

      $incentive_volume_nett  = $generate->incentive_volume - $generate->tax_company - $generate->tax_volume_pkp - $generate->tax_volume_non_pkp;

      $total_invoice          = $incentive_display_nett + $incentive_volume_nett;

      return $data[] = [
        'area'                   => $generate->area,
        'customer_id'            => $generate->customer_id,
        'name'                   => $generate->name,
        'target'                 => $generate->target,
        'offtakes'               => $generate->offtakes,
        'display_active'         => $generate->is_active_display,
        'incentive_display'      => $generate->incentive_display,
        'incentive_volume'       => $generate->incentive_volume,
        'pkp'                    => $generate->pkp,
        'tax_display_pkp'        => $generate->tax_display_pkp,
        'tax_display_non_pkp'    => $generate->tax_display_non_pkp,
        'incentive_display_nett' => $incentive_display_nett,
        'tax_volume_pkp'         => $generate->tax_volume_pkp,
        'tax_volume_non_pkp'     => $generate->tax_volume_non_pkp,
        'incentive_volume_nett'  => $incentive_volume_nett,
        'is_company'             => $generate->is_company,
        'tax_company'            => $generate->tax_company,
        'total_invoice'          => $total_invoice,
        'voucher_publish'        => $generate->voucher_publish,
      ];
    });

    return $generates;
  }

  public function headings(): array
  {
    return [
      'Area',
      'Customer ID',
      'Name',
      'Target',
      'Offtakes',
      'Display Active',
      'Incentive Display',
      'Incentive Volume',
      'PKP',
      'Potongan Display PKP (2%)',
      'Potongan Display non PKP (4%)',
      'Incentive Display Nett',
      'Potongan Volume PKP (2.5%)',
      'Potongan Volume non PKP (3%)',
      'Incentive Volume Nett',
      'Badan Perusahaan',
      'Potongan Badan (15%)',
      'Total Incentive',
      'Voucher Publish',
    ];
  }

  public function styles(Worksheet $sheet)
  {
    // Set font row 1 :bold
    $sheet->getStyle(1)->getFont()->setBold(true);

    // Set autofilter data
    $sheet->setAutoFilter('A1:R1');

    // Set font alignment
    $sheet->getStyle('A:R')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

    // Set format column
    $sheet->getStyle('D:E')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_ACCOUNTING_USD);
    $sheet->getStyle('G:H')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_ACCOUNTING_USD);
    $sheet->getStyle('J:O')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_ACCOUNTING_USD);
    $sheet->getStyle('Q:R')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_ACCOUNTING_USD);
  }
}
