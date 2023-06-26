<?php

namespace App\Mail;

use App\Models\User;
use App\Services\DailySalesReportService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DsrCSAJ extends Mailable
{
	use Queueable, SerializesModels;

	protected DailySalesReportService $dsrService;

	private $dates;

	private $channel_DSRs;

	private $branch_datas;

	/**
	 * Create a new message instance.
	 */
	public function __construct()
	{
		$this->dsrService = new DailySalesReportService;
	}

	/**
	 * Build the message.
	 */
	public function build()
	{
		$subjectTitle = 'DSR CSAJ ' . now()->format('d/M/Y');

		$this->dates = $this->dsrService->workday();
		$this->channel_DSRs = $this->dsrService->dsrByChannel_CSAJ();
		$this->branch_datas = $this->dsrService->dsrByBranch_CSAJ();

		return $this->view('mails.dsr', [
			'dates' => $this->dates,
			'channel_DSRs' => $this->channel_DSRs,
			'branch_datas' => $this->branch_datas,
		])
			->subject($subjectTitle);
	}
}
