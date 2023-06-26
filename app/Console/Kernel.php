<?php

namespace App\Console;

use App\Commands\DailySalesReportMail;
use App\Commands\TDS\Incentive;
use App\Commands\TDS\Invoice;
use App\Commands\TDS\MasterReturn;
use App\Commands\TDS\MasterStore;
use App\Commands\TDS\Overdue;
use App\Commands\TDS\Price;
use App\Commands\TDS\Product;
use App\Commands\TDS\Seller;
use App\Commands\TDS\Voucher;
use Exception;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

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
		$schedule->call(new DailySalesReportMail)
			->at('05:00');
		// ->onSuccess(function () {
		// 	DB::table('sync_reports')->insert([
		// 		'report' => 'DSR',
		// 		'note' => 'Schedule Email, OK',
		// 		'created_at' => now(),
		// 	]);
		// })
		// ->onFailure(function () {
		// 	DB::table('sync_reports')->insert([
		// 		'report' => 'DSR',
		// 		'note' => 'Schedule Email, Failed',
		// 		'created_at' => now(),
		// 	]);
		// });

		//todo: POST INCENTIVE
		// $schedule->call(new Incentive)
		// 	->at('20:30');

		//todo: POST INVOICE
		// $schedule->call(new Invoice)
		// 	->at('20:30');

		//todo: POST OVERDUE
		// $schedule->call(new Overdue)
		// 	->at('20:42');

		//todo: POST MASTER PRICE
		// $schedule->call(new Price)
		// 	->at('20:42');

		//todo: POST MASTER PRODUCT
		// $schedule->call(new Product)
		// 	->at('20:42');

		//todo: POST RETURN
		// $schedule->call(new MasterReturn)
		// 	->at('20:42');

		//todo: POST SELLER
		// $schedule->call(new Seller)
		// 	->at('20:42');

		//todo: POST STORE
		// $schedule->call(new MasterStore)
		// 	->at('20:42');

		//todo: POST VOUCHER
		// $schedule->call(new Voucher)
		// 	->at('20:42');
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
