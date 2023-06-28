<?php

namespace App\Http\Controllers\Reports;

use App\Enums\AreaEnum;
use App\Http\Controllers\Controller;
use App\Mail\DsrCSAJ;
use App\Mail\DsrCSAS;
use App\Services\DailySalesReportService;
use Illuminate\Support\Facades\Mail;

class DailySalesReportController extends Controller
{
	protected DailySalesReportService $dsrService;

	public function __construct()
	{
		$this->dsrService = new DailySalesReportService;
	}

	public function index()
	{
		if (auth()->user()->area == AreaEnum::CSAJ) {
			$dates = $this->dsrService->workday();

			$channel_DSRs = $this->dsrService->dsrByChannel(AreaEnum::CSAJ_TEXT);

			$branch_datas = $this->dsrService->dsrByBranch(AreaEnum::CSAJ_TEXT);

			return view('reports.dsr.index', compact('branch_datas', 'channel_DSRs', 'dates'));
		}

		if (auth()->user()->area == AreaEnum::CSAS) {
			$dates = $this->dsrService->workday();

			$channel_DSRs = $this->dsrService->dsrByChannel(AreaEnum::CSAS_TEXT);

			$branch_datas = $this->dsrService->dsrByBranch(AreaEnum::CSAS_TEXT);

			return view('reports.dsr.index', compact('branch_datas', 'channel_DSRs', 'dates'));
		}
	}

	// Send Email
	public function mail()
	{
		Mail::to('kevin.septian@csahome.com')
			->send(new DsrCSAJ());

		Mail::to('kevin.septian@csahome.com')
			->send(new DsrCSAS());

		return back();
	}

	// Lihat index mail yang akan dikirim
	public function mailIndex()
	{
		if (auth()->user()->area = AreaEnum::CSAJ) {
			$dates = $this->dsrService->workday();

			$channel_DSRs = $this->dsrService->dsrByChannel(AreaEnum::CSAJ_TEXT);

			$branch_datas = $this->dsrByBranch(AreaEnum::CSAJ_TEXT);

			return view('mails.dsr', compact('dates', 'channel_DSRs', 'branch_datas'));
		}

		if (auth()->user()->area == AreaEnum::CSAS) {
			$dates = $this->dsrService->workday();

			$channel_DSRs = $this->dsrService->dsrByChannel(AreaEnum::CSAS_TEXT);

			$branch_datas = $this->dsrService->dsrByBranch(AreaEnum::CSAS_TEXT);

			return view('mails.dsr', compact('dates', 'channel_DSRs', 'branch_datas'));
		}
	}
}
