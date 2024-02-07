mmen<?php

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
					->dailyAt('05:00');

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

				/*

		// Scheduler Hit Order TDS V2
		$schedule->call(new HitOrder)
			->at('09:00')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new HitOrder)
			->at('09:30')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new HitOrder)
			->at('10:00')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new HitOrder)
			->at('10:30')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new HitOrder)
			->at('11:00')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new HitOrder)
			->at('11:30')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new HitOrder)
			->at('12:00')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new HitOrder)
			->at('12:30')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new HitOrder)
			->at('13:00')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new HitOrder)
			->at('13:30')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new HitOrder)
			->at('14:00')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new HitOrder)
			->at('14:30')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new HitOrder)
			->at('15:00')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new HitOrder)
			->at('15:30')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new HitOrder)
			->at('16:00')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new HitOrder)
			->at('16:30')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new HitOrder)
			->at('17:00')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new HitOrder)
			->at('17:30')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new HitOrder)
			->at('18:00')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new HitOrder)
			->at('18:30')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new HitOrder)
			->at('19:00')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new HitOrder)
			->at('19:30')
			->days([1, 2, 3, 4, 5, 6]);

		//Scheduler CSV Order TDS V2
		$schedule->call(new CSVOrder)
			->at('09:10')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new CSVOrder)
			->at('09:40')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new CSVOrder)
			->at('10:10')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new CSVOrder)
			->at('10:40')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new CSVOrder)
			->at('11:10')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new CSVOrder)
			->at('11:40')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new CSVOrder)
			->at('12:10')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new CSVOrder)
			->at('12:40')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new CSVOrder)
			->at('13:10')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new CSVOrder)
			->at('13:40')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new CSVOrder)
			->at('14:10')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new CSVOrder)
			->at('14:40')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new CSVOrder)
			->at('15:10')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new CSVOrder)
			->at('15:40')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new CSVOrder)
			->at('16:10')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new CSVOrder)
			->at('16:40')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new CSVOrder)
			->at('17:10')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new CSVOrder)
			->at('17:40')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new CSVOrder)
			->at('18:10')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new CSVOrder)
			->at('18:40')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new CSVOrder)
			->at('19:10')
			->days([1, 2, 3, 4, 5, 6]);
		$schedule->call(new CSVOrder)
			->at('19:40')
			->days([1, 2, 3, 4, 5, 6]);


		// 	//BELUM READY
		// 	// todo: POST INCENTIVE
		// 	$schedule->call(new Incentive)
		// 		->at('10:45');

		// 	// todo: POST INVOICE
		// 	$schedule->call(new Invoice)
		// 		->at('10:47');

		// 	// todo: POST OVERDUE
		// 	$schedule->call(new Overdue)
		// 		->at('10:49');

		// 	// todo: POST RETURN
		// 	$schedule->call(new MasterReturn)
		// 		->at('10:55');

		// 	// todo: POST SELLER
		// 	$schedule->call(new Seller)
		// 		->at('10:57');

		// 	// todo: POST VOUCHER
		// 	$schedule->call(new Voucher)
		// 		->at('11:01');

		// Scheduler Hit Order TDS V3
		// 	$schedule->call(new HitOrder)
		// 		->days([1, 2, 3, 4, 5, 6])
		// 		->everyTenMinutes()
		// 		->between('9:00', '19:00');


		// 	//Scheduler CSV Order TDS V3
		// 	$schedule->call(new CSVOrder)
		// 		->days([1, 2, 3, 4, 5, 6])
		// 		->everyFifteenMinutes()
		// 		->between('9:00', '19:15');
		*/
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
