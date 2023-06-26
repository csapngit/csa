<?php

namespace App\Exports;

use App\Enums\FormatEnum;
use App\Models\MasterStore;
use App\Models\ProgramImage;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProgramImageExport implements FromCollection, WithHeadings, WithDrawings, ShouldAutoSize, WithEvents, WithColumnWidths, WithStyles
{
	private $store_id;

	private $date;

	private $year;

	public function __construct()
	{
		$this->store_id = request()->store_id;
	}

	public function headings(): array
	{
		$header = [
			'Program',
			'Brand',
			'Variant / Sku Group',
			'Periode',
			'Promo',
			'Depth Master',
			'Depth RO',
			'Harga Normal RO',
			'Harga Promo RO',
			'Potongan RO',
			'Status Valid',
			'Customer ID',
			'Image'
		];

		return $header;
	}

	/**
	 * @return \Illuminate\Support\Collection
	 */
	public function collection()
	{
		$periode = request()->periode;

		$flag = explode('/', $periode);

		$this->date = $flag[0];

		$this->year = $flag[1];

		$programImages = DB::table('program_images')
			->join('programs', 'program_images.program_id', 'programs.id')
			->join('program_details', 'programs.id', 'program_details.program_id')
			->join('master_customers', 'program_images.customer_id', 'master_customers.CustId')
			->join('master_brands', 'program_details.master_brand_id', 'master_brands.id')
			->join('sku_groups', 'program_details.sku_group_id', 'sku_groups.id')
			->select(
				'program_images.id',
				'program_images.program_id',
				'programs.name',
				'master_brands.name as brand_name',
				'sku_groups.name as sku_group_name',
				'programs.valid_from',
				'programs.valid_until',
				'program_details.promo',
				'program_details.depth as depth_master',
				'program_images.depth as depth_ro',
				'program_images.normal_price',
				'program_images.promo_price',
				'program_images.customer_id',
				'master_customers.Name',
				'program_images.text',
			)
			->whereMonth('program_images.created_at', '=', $this->date)
			->whereYear('program_images.created_at', '=', $this->year)
			->where('program_images.customer_id', $this->store_id)
			->orderByDesc('program_images.id')
			->get();

		$programImages = $programImages->map(function ($programImage) {
			return [
				/* Row Excel */
				/* A */ 'program' => $programImage->name,
				/* B */ 'brand' => $programImage->brand_name,
				/* C */ 'group_sku' => $programImage->sku_group_name,
				/* D */ 'periode' => date('d', strtotime($programImage->valid_from)) . ' - ' . date('d F Y', strtotime($programImage->valid_until)),
				/* E */ 'promo' => $programImage->promo,
				/* F */ 'depth_master' => $programImage->depth_master . __('app.operators.percentage'),
				/* G */ 'depth_ro' => $programImage->depth_ro . __('app.operators.percentage'),
				/* H */ 'normal_price' => $programImage->normal_price,
				/* I */ 'promo_price' => $programImage->promo_price,
				/* J */ 'cut_price' => $programImage->normal_price - $programImage->promo_price,
				/* K */ 'status_valid' => $programImage->depth_master ==  $programImage->depth_ro ? 'Valid' : 'Invalid',
				/* L */ 'customer_id' => $programImage->customer_id
			];
		});

		$programImages = $programImages->collect();

		return $programImages;
	}

	public function registerEvents(): array
	{
		return [
			AfterSheet::class => function (AfterSheet $event) {
				$flag = $event->sheet->getDelegate();

				foreach ($this->getDrawings() as $drawing) {
					$drawing->setWorksheet($flag);
				}
			},
		];
	}

	public function drawings()
	{
		return [];
	}

	public function getDrawings()
	{
		$programImages = $this->getImages();

		$dataImage = [];

		$i = 2;

		foreach ($programImages as $key => $value) {
			$drawing = new Drawing();
			$drawing->setPath(public_path("storage/$value->text"));
			$drawing->setHeight(100);
			$drawing->setCoordinates('M' . $i++);
			$drawing->setOffsetX(7);
			$drawing->setOffsetY(7);
			$dataImage[] = $drawing;
		}

		return $dataImage;
	}

	public function columnWidths(): array
	{
		return [
			'M' => 20,
		];
	}

	public function styles(Worksheet $sheet)
	{
		$images = $this->getImages();

		$totalImages = $images->count();

		for ($i = 2; $i <= $totalImages + 1; $i++) {
			$sheet->getRowDimension($i)->setRowHeight(85);
			$sheet->getStyle($i)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
			$sheet->getStyle($i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		}

		$sheet->getStyle(1)->getFont()->setBold(true);

		$sheet->getStyle('A:M')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

		// $sheet->setAutoFilter('A:H');

		// $sheet->getStyle('F')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_PERCENTAGE);
		$sheet->getStyle('H')->getNumberFormat()->setFormatCode(FormatEnum::FORMAT_ACCOUNTING_RP);
		$sheet->getStyle('I')->getNumberFormat()->setFormatCode(FormatEnum::FORMAT_ACCOUNTING_RP);
		$sheet->getStyle('J')->getNumberFormat()->setFormatCode(FormatEnum::FORMAT_ACCOUNTING_RP);
	}

	public function getImages()
	{
		$images = DB::table('program_images')
			->whereMonth('created_at', '=', $this->date)
			->whereYear('created_at', '=', $this->year)
			->where('customer_id', $this->store_id)
			->orderByDesc('id')
			->get();

		return $images;
	}
}
