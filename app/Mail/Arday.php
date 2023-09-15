<?php

namespace App\Mail;

use App\Models\User;
use App\Services\ARDayService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Arday extends Mailable
{
	use Queueable, SerializesModels;

	protected ARDayService $ardaysService;

	/**
	 * Create a new message instance.
	 */
	public function __construct()
	{
		$this->ardaysService = new ARDayService;
	}

	/**
	 * Build the message.
	 */
	public function build()
	{
		$subjectTitle = 'AR Days ' . now()->format('d/M/Y');

		// $dates = $this->paymentService->workday();
		$date = now()->format('d-F-Y H:i:s');
		$daypassed = $this->ardaysService->daypassed();
		$ardays = $this->ardaysService->ARDays();

		return $this->view('mails.arday', [
			'date' => $date,
			'daypassed' => $daypassed,
			'ardays' => $ardays
		])
			->subject($subjectTitle);
	}
}
