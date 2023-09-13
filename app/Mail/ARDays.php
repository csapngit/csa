<?php

namespace App\Mail;

use App\Models\User;
use App\Services\ARDaysService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ARDays extends Mailable
{
	use Queueable, SerializesModels;

	protected ARDaysService $ardaysService;

	/**
	 * Create a new message instance.
	 */
	public function __construct()
	{
		$this->ardaysService = new ARDaysService;
	}

	/**
	 * Build the message.
	 */
	public function build()
	{
		$subjectTitle = 'ARDays ' . now()->format('d/M/Y');

		// $dates = $this->paymentService->workday();
		// $date = now()->format('d-F-Y H:i:s');
		$ardays = $this->ardaysService->ARDays();

		return $this->view('mails.trackingpayment', [
			// 'dates' => $dates,
			'ardays' => $ardays
		])
			->subject($subjectTitle);
	}
}
