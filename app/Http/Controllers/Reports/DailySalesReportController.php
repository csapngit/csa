<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Mail\DsrCSAJ;
use App\Services\DailySalesReportService;
use App\Services\WorkdayService;
use Illuminate\Support\Facades\Mail;

class DailySalesReportController extends Controller
{
	protected DailySalesReportService $dsrService;

	public function __construct()
	{
		$this->dsrService = new DailySalesReportService;
	}

	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$dates = $this->dsrService->workday();

		$channel_DSRs = $this->dsrService->dsrByChannel_CSAJ();

		$branch_datas = $this->dsrService->dsrByBranch_CSAJ();

		return view('reports.dsr.index', compact('branch_datas', 'channel_DSRs', 'dates'));
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
