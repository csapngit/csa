<?php

namespace App\Mail;

use App\Models\User;
use App\Services\TrackingPaymentService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TrackingPayment extends Mailable
{
	use Queueable, SerializesModels;

	protected TrackingPaymentService $paymentService;

	/**
	 * Create a new message instance.
	 */
	public function __construct()
	{
		$this->paymentService = new TrackingPaymentService;
	}

	/**
	 * Build the message.
	 */
	public function build()
	{
		$subjectTitle = 'Tracking Payment ' . now()->format('d/M/Y');

		$dates = $this->paymentService->workday();
		// $date = now()->format('d-F-Y H:i:s');
		$trackingpayments = $this->paymentService->TrackingPayment();

		return $this->view('mails.trackingpayment', [
			'dates' => $dates,
			'trackingpayments' => $trackingpayments
		])
			->subject($subjectTitle);
	}
}
