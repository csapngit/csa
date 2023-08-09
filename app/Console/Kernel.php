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
use App\Commands\TDS\OrderDetail;
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
		$schedule->call(new DailySalesReportMail)
			->at('05:00');

		// $schedule->call('App\Http\Controllers\TDS\TdsController@order', ['date' => Carbon::now()->format('Y-m-d')])
		// 	->at('12:25');


		// $schedule->call(new OrderDetail)
		// 	->at('08:25')
		// 	->days([1, 2, 3, 4, 5, 6]);
		// $schedule->call(new OrderDetail)
		// 	->at('08:55')
		// 	->days([1, 2, 3, 4, 5, 6]);
		// $schedule->call(new OrderDetail)
		// 	->at('09:25')
		// 	->days([1, 2, 3, 4, 5, 6]);
		// $schedule->call(new OrderDetail)
		// 	->at('09:55')
		// 	->days([1, 2, 3, 4, 5, 6]);
		// $schedule->call(new OrderDetail)
		// 	->at('10:25')
		// 	->days([1, 2, 3, 4, 5, 6]);
		// $schedule->call(new OrderDetail)
		// 	->at('10:55')
		// 	->days([1, 2, 3, 4, 5, 6]);
		// $schedule->call(new OrderDetail)
		// 	->at('11:25')
		// 	->days([1, 2, 3, 4, 5, 6]);
		// $schedule->call(new OrderDetail)
		// 	->at('11:55')
		// 	->days([1, 2, 3, 4, 5, 6]);
		// $schedule->call(new OrderDetail)
		// 	->at('12:25')
		// 	->days([1, 2, 3, 4, 5, 6]);
		// $schedule->call(new OrderDetail)
		// 	->at('12:55')
		// 	->days([1, 2, 3, 4, 5, 6]);
		// $schedule->call(new OrderDetail)
		// 	->at('13:25')
		// 	->days([1, 2, 3, 4, 5, 6]);
		// $schedule->call(new OrderDetail)
		// 	->at('13:55')
		// 	->days([1, 2, 3, 4, 5, 6]);
		// $schedule->call(new OrderDetail)
		// 	->at('14:25')
		// 	->days([1, 2, 3, 4, 5, 6]);
		// $schedule->call(new OrderDetail)
		// 	->at('14:55')
		// 	->days([1, 2, 3, 4, 5, 6]);
		// $schedule->call(new OrderDetail)
		// 	->at('15:25')
		// 	->days([1, 2, 3, 4, 5, 6]);
		// $schedule->call(new OrderDetail)
		// 	->at('15:55')
		// 	->days([1, 2, 3, 4, 5, 6]);
		// $schedule->call(new OrderDetail)
		// 	->at('16:25')
		// 	->days([1, 2, 3, 4, 5, 6]);
		// $schedule->call(new OrderDetail)
		// 	->at('16:55')
		// 	->days([1, 2, 3, 4, 5, 6]);
		// $schedule->call(new OrderDetail)
		// 	->at('17:25')
		// 	->days([1, 2, 3, 4, 5, 6]);
		// $schedule->call(new OrderDetail)
		// 	->at('17:55')
		// 	->days([1, 2, 3, 4, 5, 6]);
		// $schedule->call(new OrderDetail)
		// 	->at('18:25')
		// 	->days([1, 2, 3, 4, 5, 6]);
		// $schedule->call(new OrderDetail)
		// 	->at('18:55')
		// 	->days([1, 2, 3, 4, 5, 6]);


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

		// // todo: POST INCENTIVE
		// $schedule->call(new Incentive)
		// 	->at('10:45');

		// // todo: POST INVOICE
		// $schedule->call(new Invoice)
		// 	->at('10:47');

		// // todo: POST OVERDUE
		// $schedule->call(new Overdue)
		// 	->at('10:49');

		// // todo: POST MASTER PRICE
		// $schedule->call(new Price)
		// 	->at('10:51');

		// // todo: POST MASTER PRODUCT
		// $schedule->call(new Product)
		// 	->at('10:53');

		// // todo: POST RETURN
		// $schedule->call(new MasterReturn)
		// 	->at('10:55');

		// // todo: POST SELLER
		// $schedule->call(new Seller)
		// 	->at('10:57');

		// // todo: POST STORE
		// $schedule->call(new MasterStore)
		// 	->at('10:59');

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
