<?php

namespace App\Console;

use App\Commands\DailySalesReportMail;
use App\Commands\TrackingPaymentMail;
use App\Commands\ARDayMail;
use App\Commands\TDS\Incentive;
use App\Commands\TDS\Invoice;
use App\Commands\TDS\MasterReturn;
use App\Commands\TDS\MasterStore;
use App\Commands\TDS\Overdue;
use App\Commands\TDS\Price;
use App\Commands\TDS\Product;
use App\Commands\TDS\Seller;
use App\Commands\TDS\Voucher;
use App\Commands\TDS\OrderDetail;
use App\Commands\TDS\HitOrder;
use App\Commands\TDS\CSVOrder;
use App\Mail\TrackingPayment;
use Exception;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		//
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
		//Scheduler DSR
		$schedule->call(new DailySalesReportMail)
			->at('05:00');

		//Scheduler TrackingPayment
		$schedule->call(new TrackingPaymentMail)
			->at('05:02');

		//Scheduler AR Days
		$schedule->call(new ARDayMail)
			->at('05:04');

		//Scheduler Store Master
		$schedule->call(new MasterStore)
			->at('00:00');

		//Scheduler Price Master
		$schedule->call(new Price)
			->at('00:10');

		//Scheduler Product Master
		$schedule->call(new Product)
			->at('00:20');



		//Scheduler Hit Order TDS V2
		$schedule->call(new HitOrder)
			->at('08:20')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new HitOrder)
			->at('08:50')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new HitOrder)
			->at('09:20')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new HitOrder)
			->at('09:50')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new HitOrder)
			->at('10:20')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new HitOrder)
			->at('10:50')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new HitOrder)
			->at('11:20')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new HitOrder)
			->at('11:50')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new HitOrder)
			->at('12:20')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new HitOrder)
			->at('12:50')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new HitOrder)
			->at('13:20')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new HitOrder)
			->at('13:50')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new HitOrder)
			->at('14:20')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new HitOrder)
			->at('14:50')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new HitOrder)
			->at('15:20')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new HitOrder)
			->at('15:50')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new HitOrder)
			->at('16:20')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new HitOrder)
			->at('16:50')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new HitOrder)
			->at('17:20')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new HitOrder)
			->at('17:50')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new HitOrder)
			->at('18:20')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new HitOrder)
			->at('18:50')
			->days([1, 2, 3, 4, 5, 6]);

		//Scheduler CSV Order TDS V2
		$schedule->call(new CSVOrder)
			->at('08:25')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new CSVOrder)
			->at('08:55')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new CSVOrder)
			->at('09:25')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new CSVOrder)
			->at('09:55')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new CSVOrder)
			->at('10:25')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new CSVOrder)
			->at('10:55')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new CSVOrder)
			->at('11:25')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new CSVOrder)
			->at('11:55')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new CSVOrder)
			->at('12:25')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new CSVOrder)
			->at('12:55')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new CSVOrder)
			->at('13:25')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new CSVOrder)
			->at('13:55')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new CSVOrder)
			->at('14:25')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new CSVOrder)
			->at('14:55')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new CSVOrder)
			->at('15:25')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new CSVOrder)
			->at('15:55')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new CSVOrder)
			->at('16:25')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new CSVOrder)
			->at('16:55')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new CSVOrder)
			->at('17:25')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new CSVOrder)
			->at('17:55')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new CSVOrder)
			->at('18:25')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new CSVOrder)
			->at('18:55')
			->days([1, 2, 3, 4, 5, 6]);


		// //BELUM READY
		// // todo: POST INCENTIVE
		// $schedule->call(new Incentive)
		// 	->at('10:45');

		// // todo: POST INVOICE
		// $schedule->call(new Invoice)
		// 	->at('10:47');

		// // todo: POST OVERDUE
		// $schedule->call(new Overdue)
		// 	->at('10:49');

		// // todo: POST RETURN
		// $schedule->call(new MasterReturn)
		// 	->at('10:55');

		// // todo: POST SELLER
		// $schedule->call(new Seller)
		// 	->at('10:57');

		// // todo: POST VOUCHER
		// $schedule->call(new Voucher)
		// 	->at('11:01');
	}

	/**
	 * Register the commands for the application.
	 *
	 * @return void
	 */
	protected function commands()
	{
		$this->load(__DIR__ . '/Commands');

		require base_path('routes/console.php');
	}
}
