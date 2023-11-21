<?php

use App\Commands\TDS\HitOrder;
use App\Http\Controllers\Admin\AppAutorisasiController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DynamicSelectController;
use App\Http\Controllers\Rebate\CustomerController;
use App\Http\Controllers\Rebate\GenerateController;
use App\Http\Controllers\Rebate\LogoutController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\Itcsa\AssetCategoryController;
use App\Http\Controllers\Itcsa\AssetController;
use App\Http\Controllers\Itcsa\AssetServiceController;
use App\Http\Controllers\Logistic\DelmanController;
use App\Http\Controllers\Rebate\ProgramController;
use App\Http\Controllers\Rebate\ProgramImageController;
use App\Http\Controllers\Rebate\ProgramTierController;
use App\Http\Controllers\Rebate\VoucherPublishController;
use App\Http\Controllers\Rebate\VoucherApproveController;
use App\Http\Controllers\Rebate\VoucherPrintController;
use App\Http\Controllers\Reports\ARDayController;
use App\Http\Controllers\Reports\DailySalesReportController;
use App\Http\Controllers\Reports\SoMonitoringController;
use App\Http\Controllers\Reports\TargetDsrController;
use App\Http\Controllers\Reports\TrackingPaymentController;
use App\Http\Controllers\Reports\TargetTrackingPaymentController;
use App\Http\Controllers\Reports\TargetArdayController;
use App\Http\Controllers\Reports\ReportMailerController;
use App\Http\Controllers\Order\HitOrderController;
use App\Http\Controllers\TDS\IncentiveController;
use App\Http\Controllers\TDS\PromotionPriceController;
use App\Http\Controllers\TDS\TdsController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {`
//     return view('welcome');
// });
Route::controller(HitOrderController::class)->prefix('order')->group(function () {
	Route::get('hitorder', 'hitorder')->name('order.hitorder');
	Route::get('csvorder', 'csvorder')->name('order.csvorder');
	// Route::get('csvmanual/{orderno}', 'csvmanual');
	// Route::post('csvmanual', 'postcsvmanual')->name('order.csvmanual');
});

Route::name('sendmail.')->prefix('sendmail')->group(function () {
	Route::get('dsr', [DailySalesReportController::class, 'mail'])->name('dsr.mail');
	Route::get('trackingpayment', [TrackingPaymentController::class, 'mail'])->name('trackingpayment.mail');
});

Route::get('/', function () {
	return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {

	Route::get('/', function () {
		// dd(request()->ip());

		return view('pages.dashboard');
	})->name('dashboard');

	Route::prefix('logistic')->group(function () {
		Route::prefix('delman')->group(function () {
			Route::resource('/routes', DelmanController::class, [
				'names' => [
					'index' => 'delman-routes',
					'create' => 'delman-routes.create',
					'store' => 'delman-routes',
					'edit' => 'delman-routes.edit',
					'show' => 'delman-routes.show'
				],
				'except' => ['destroy']
			]);
		});
	});

	Route::get('/quick-search', [PagesController::class, 'quickSearch'])->name('quick-search');

	//todo: users
	Route::resource('users', UserController::class);
	Route::resource('authorizations', AppAutorisasiController::class);

	//todo: programs
	Route::get('programs/{program}/show', [ProgramController::class, 'show'])->name('programs.show');
	Route::resource('programs', ProgramController::class)->except('show');
	Route::controller(ProgramController::class)->group(function () {
		Route::get('program-customers/{program}', 'showCustomers')->name('programs.customers');
		Route::get('claim-customers-import', 'indexClaimCustomers')->name('programs.claim.customers');
	});

	//todo: program image (watermarks)
	Route::resource('program-images', ProgramImageController::class)
		->except([
			'edit',
			'update',
		])
		->names([
			'index' => 'program.images.index',
			'create' => 'program.images.create',
			'store' => 'program.images.store',
			'show' => 'program.images.show',
			'destroy' => 'program.images.destroy',
		]);
	Route::controller(ProgramImageController::class)->group(function () {
		Route::post('depthProgram', 'showDepth')->name('programs.depth');
		Route::get('index-exports', 'indexExport')->name('index.exports');
		Route::post('export-images', 'export')->name('programs.export.image');
	});

	//todo: tiers
	Route::get('tiers/create/{program}', [ProgramTierController::class, 'create'])->name('tiers.create');
	Route::resource('tiers', ProgramTierController::class)
		->parameter('tiers', 'programTier')
		->except('create');

	//todo: customers
	//Route::resource('customers', CustomerController::class);
	Route::controller(CustomerController::class)->group(function () {
		// Import Customers TSP
		Route::put('customers-tsp/{program}', 'importCustomersTsp')->name('customers.import.tsp');

		// Import Customers Claim
		Route::post('customers-claim', 'importCustomerClaim')->name('customers.import.claim');
	});

	//todo: generates
	Route::controller(GenerateController::class)->group(function () {
		Route::get('generates', 'index')->name('generates.index');
		Route::post('generates-import', 'import')->name('generates.import');
		Route::post('generates-export', 'export')->name('generates.export');
		Route::post('generates-generate', 'generate')->name('generates.generate');
	});

	//todo: Voucher Publish
	// Route::get('publishes', [VoucherPublishController::class, 'index'])->name('publish.index');
	Route::resource('publishes', VoucherPublishController::class)->parameter('publish', 'voucherPublish');
	Route::post('publish-all', [VoucherPublishController::class], 'publishAll')->name('voucherPublish.all');

	//todo: Voucher Print
	Route::resource('reports', VoucherPrintController::class)->parameter('reports', 'printVoucher');
	Route::post('print-voucher', [VoucherPrintController::class, 'printPdf'])->name('reports.printVoucher');

	//todo: Approve Voucher
	Route::get('approves', [VoucherApproveController::class, 'index'])->name('approves.index');
	Route::post('approves-key-update', [VoucherApproveController::class, 'store'])->name('approves.store');

	//todo ITCSA
	Route::name('itcsa.')->prefix('itcsa')->group(function () {
		// Asset category
		Route::resource('asset-categories', AssetCategoryController::class)
			->except('show')
			->names([
				'index' => 'asset.categories',
				'create' => 'asset.categories.create',
				'store' => 'asset.categories.store',
				'edit' => 'asset.categories.edit',
				'update' => 'asset.categories.update',
				'destroy' => 'asset.categories.destroy',
			]);

		// Asset
		Route::resource('assets', AssetController::class);
		Route::post('assets-barcode', [AssetController::class, 'exportBarcode'])->name('assets.barcode');

		// Asset service
		Route::resource('asset-services', AssetServiceController::class);
	});

	//todo REPORT
	Route::name('report.')->prefix('report')->group(function () {
		// SO Monitoring
		Route::get('so-monitoring', [SoMonitoringController::class, 'index'])->name('report.so-monitoring');
		Route::post('soMonitoring-export', [SoMonitoringController::class, 'export'])->name('salesOrder.export');

		// Daily Sales Report
		Route::get('daily-sales-reports', [DailySalesReportController::class, 'index'])->name('report.dsr');
		Route::get('send-mail', [DailySalesReportController::class, 'mail'])->name('dsr.mail');
		Route::get('send-mail-self', [DailySalesReportController::class, 'mailself'])->name('dsr.mailself');

		// View DSR Mail Index
		Route::get('dsr-mail-index', [DailySalesReportController::class, 'mailIndex'])->name('dsr.mail.index');

		// Tracking Payment
		Route::get('tracking-payment', [TrackingPaymentController::class, 'index'])->name('tracking.payment');
		Route::get('send-trackingpayment', [TrackingPaymentController::class, 'mail'])->name('trackingpayment.mail');
		Route::get('send-trackingpayment-self', [TrackingPaymentController::class, 'mailself'])->name('trackingpayment.mailself');
		Route::get('trackingpayment-mail-index', [TrackingPaymentController::class, 'mailIndex'])->name('trackingpayment.mail.index');

		// ARDays
		Route::get('arday', [ARDayController::class, 'index'])->name('arday');
		Route::get('send-arday', [ARDayController::class, 'mail'])->name('arday.mail');
		Route::get('send-arday-self', [ARDayController::class, 'mailself'])->name('arday.mailself');
		Route::get('arday-mail-index', [ARDayController::class, 'mailIndex'])->name('arday.mail.index');

		// Mailer
		Route::get('report-mailer', [ReportMailerController::class, 'index'])->name('report.mailer');

		//Target
		Route::resource('target-dsrs', TargetDsrController::class)->except('show');
		Route::resource('target-trackingpayments', TargetTrackingPaymentController::class)->except('show');
		Route::resource('target-ardays', TargetArdayController::class)->except('show');
	});

	//todo: Dynamic Select
	Route::controller(DynamicSelectController::class)->group(function () {
		Route::get('testtest', 'index');
		Route::post('customers-program', 'showCustomer')->name('customers.program');
		Route::post('inventory-by-program-id', 'inventoryByProgramId')->name('inventories.program');
	});

	Route::get('index', [TdsController::class, 'index'])->prefix('tds')->name('tds.index');

	Route::controller(IncentiveController::class)->prefix('tds')->group(function () {
		Route::get('index-incentive', 'index')->name('incentives.index');
		Route::post('import-incentive', 'import')->name('incentives.import');
	});

	Route::controller(PromotionPriceController::class)->prefix('tds')->group(function () {
		Route::get('index-promoPrice', 'index')->name('promoPirices.index');
		Route::post('import-promoPrice', 'import')->name('promoPirices.import');
	});

	//todo: Logout
	Route::get('logout', LogoutController::class);
});

//todo: API POST SFA
Route::controller(TdsController::class)->prefix('tds')->group(function () {
	// Route::get('orders/{date}', 'order');
	// Route::get('ordertds', 'ordertds');
	// Route::get('orderscheduler', 'orderScheduler');
	Route::get('hitorder', 'hitorder')->name('tds.hitorder');
	Route::get('csvorder', 'csvorder')->name('tds.csvorder');
	Route::get('csvmanual/{orderno}', 'csvmanual');
	Route::post('csvmanual', 'postcsvmanual')->name('tds.csvmanual');
	Route::get('branches', 'masterBranch');
	Route::get('channels', 'masterChannel');
	Route::get('holidays', 'holiday');
	Route::get('incentives', 'incentive'); // Daily, Buat UI u/ import excel ke db
	Route::get('inventories', 'inventory'); // Daily, Belum ada DB nya
	Route::get('invoices', 'invoice'); // Daily
	Route::get('overdues', 'overdue'); // Daily
	Route::get('pe-surveys', 'peSurvey');
	Route::get('prices', 'masterPrice'); // Daily
	Route::get('product-bundles', 'productBundle');
	Route::get('products', 'masterProduct'); // Daily
	Route::get('product-priorities', 'productPriority');
	Route::get('promotions', 'promotion');
	Route::get('promo-prices', 'promotionPrice');
	Route::get('reasons', 'masterReason');
	Route::get('returns', 'return'); // Daily
	Route::get('route-plan-details', 'routePlanDetail');
	Route::get('sbd-distributions', 'sbdDistribution');
	Route::get('sbd-merchandising', 'sbdMerchendising');
	Route::get('sellers', 'seller'); // Daily
	Route::get('seller-targets', 'sellerTarget');
	Route::get('stores', 'masterStore'); // Daily
	Route::get('store-programs', 'storeProgram');
	Route::get('store-targets', 'storeTarget');
	Route::get('week-mappings', 'weekMapping');
	Route::get('vouchers', 'voucher'); // Daily
	Route::get('sf-osa-master', 'sfOsaMaster');
	// Route::get('sf-sosd-master', 'sfSosdMaster');
	// Route::get('store-target-go-green', 'storeGoGreen');
});

require __DIR__ . '/auth.php';

//BRANCH IMAN
// Route::resource('/admin/user',  UserController::class, [
// 	'names' => [
// 		'index' => 'user',
// 		'create' => 'user.create',
// 		'store' => 'user',
// 		'edit' => 'user.edit',
// 		'destroy' => 'user.delete'
// 	],
// 	'except' => ['show']
// ]);

// Route::resource('/rebate/icg', RebateICGController::class, [
// 	'names' => [
// 		'index' => 'icg',
// 		'create' => 'icg.create',
// 		'store' => 'icg',
// 		'edit' => 'icg.edit',
// 		'destroy' => 'icg.delete'
// 	],
// 	'except' => ['show']
// ]);

// Route::resource('/rebate/manual', RebateController::class, [
// 	'names' => [
// 		'index' => 'rebate',
// 		'create' => 'rebate.create',
// 		'store' => 'rebate',
// 		'edit' => 'rebate.edit',
// 		'destroy' => 'rebate.delete'
// 	],
// 	'except' => ['show']
// ]);

// Route::resource('/rebate/mapping-budget', RebateBudgetController::class, [
// 	'names' => [
// 		'index' => 'mapping-budget',
// 		'create' => 'mapping-budget.create',
// 		'store' => 'mapping-budget',
// 		'edit' => 'mapping-budget.edit',
// 		'destroy' => 'mapping-budget.delete'
// 	],
// 	'except' => ['show']
// ]);

// Route::resource('/claim', RebateController::class);
