<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Mail\DsrCSAJ;
use App\Services\DailySalesReportService;
use App\Services\DailySalesReportSumatraService;
use App\Services\WorkdayService;
use Illuminate\Support\Facades\Mail;

class DailySalesReportController extends Controller
{
	protected DailySalesReportService $dsrService;

	protected DailySalesReportSumatraService $dsrSumatraService;

	public function __construct()
	{
		$this->dsrService = new DailySalesReportService;

		$this->dsrSumatraService = new DailySalesReportSumatraService;
	}

	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		if (auth()->user()->area == 1) {
			$dates = $this->dsrService->workday();

			$channel_DSRs = $this->dsrService->dsrByChannel_CSAJ();

			$branch_datas = $this->dsrService->dsrByBranch_CSAJ();

			return view('reports.dsr.index', compact('branch_datas', 'channel_DSRs', 'dates'));
		}

		if (auth()->user()->area == 2) {
			$dates = $this->dsrSumatraService->workday();

			$channel_DSRs = $this->dsrSumatraService->dsrByChannel_CSAJ();

			

			$branch_datas = $this->dsrSumatraService->dsrByBranch_CSAJ();

			return view('reports.dsr.index', compact('branch_datas', 'channel_DSRs', 'dates'));
		}
	}

	public function mail()
	{
		Mail::to('csapngit@csahome.com')
			->send(new DsrCSAJ());

		return back();
	}

	public function mailindex()
	{
		$dates = $this->dsrService->workday();

		$channel_DSRs = $this->dsrService->dsrByChannel_CSAJ();

		$branch_datas = $this->dsrService->dsrByBranch_CSAJ();

		return view('mails.dsr', compact('dates', 'channel_DSRs', 'branch_datas'));
	}
}
