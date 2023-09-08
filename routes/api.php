<?php

use App\Http\Controllers\Api\AllocationController;
use App\Http\Controllers\Api\AssetCategoryControllerApi;
use App\Http\Controllers\Api\AssetControllerApi;
use App\Http\Controllers\Api\IfastController;
use App\Http\Controllers\Api\IncentiveController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\MasterBranchController;
use App\Http\Controllers\Api\MasterChannelController;
use App\Http\Controllers\Api\MasterPriceController;
use App\Http\Controllers\Api\MasterProductController;
use App\Http\Controllers\Api\MasterSellerController;
use App\Http\Controllers\Api\MasterStoreController;
use App\Http\Controllers\Api\MasterStoreTargetController;
use App\Http\Controllers\Api\OrderDetailController;
use App\Http\Controllers\Api\OverdueController;
use App\Http\Controllers\Api\PeSurveyController;
use App\Http\Controllers\Api\PreOrderController;
use App\Http\Controllers\Api\ProductBundleController;
use App\Http\Controllers\Api\ReasonController;
use App\Http\Controllers\Rebate\ProgramController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\RebateController;
use App\Http\Controllers\Api\ReturnController;
use App\Http\Controllers\Api\SbdController;
use App\Http\Controllers\Api\SbdMercController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WeekMappingController;
use App\Http\Controllers\Rebate\VoucherPublishController;
use App\Http\Controllers\TDS\TdsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
	return $request->user();
});

Route::get('/get/programs', [ProgramController::class, 'getPrograms']);

Route::get('/get/listVoucher/{area}', [VoucherPublishController::class, 'getListVouchers']);

Route::prefix('itcsa')
	->name('itcsa.')
	->group(function () {
		// Category Asset
		Route::apiResource('asset-categories', AssetCategoryControllerApi::class)->parameter('asset-categories', 'category');

		// Assets
		Route::apiResource('assets', AssetControllerApi::class, ['as' => 'api']);
		Route::get('assets-barcode', [AssetControllerApi::class, 'exportBarcode']);
	});

Route::prefix('csapng')
	->group(function () {
		// Route::get('branches', MasterBranchController::class);

		Route::get('branches', function () {
			return 'ok';
		});

		Route::apiResource('/preorder', PreOrderController::class, [
			'only' => ['store', 'show']
		]);

		// Route::get('/preorder/{ordernumber}', [PreOrderController::class, 'show']);
		// Route::post('/preorder', [PreOrderController::class, 'store']);

		Route::get('channels', MasterChannelController::class);

		Route::get('products', MasterProductController::class);

		Route::get('stores', MasterStoreController::class);

		Route::get('store-targets', MasterStoreTargetController::class);

		Route::get('sellers', MasterSellerController::class);

		Route::get('invoices', InvoiceController::class);

		Route::get('returns', ReturnController::class);

		Route::get('allocations', AllocationController::class);

		Route::get('prices', MasterPriceController::class);

		Route::get('overdues', OverdueController::class);

		Route::get('ifast', IfastController::class);

		Route::get('incentives', IncentiveController::class);

		Route::get('order-details', OrderDetailController::class);

		Route::get('pe-surveys', PeSurveyController::class);

		Route::get('product-bundles', ProductBundleController::class);

		Route::get('reasons', ReasonController::class);

		Route::get('sbd', SbdController::class);

		Route::get('sbd-merc', SbdMercController::class);

		Route::get('week-mappings', WeekMappingController::class);
	});

//IMAN
Route::get('/search/customer/{custid}',                       [SearchController::class, 'getCustomer']);
Route::get('/get/list/customer',                              [SearchController::class, 'getListCustomer']);
Route::get('/get/list/inventory',                             [SearchController::class, 'getListInventory']);
Route::get('/admin/get/list/user',                            [UserController::class, 'getListUser']);
Route::get('/admin/get/list/user-role',                       [UserController::class, 'getListUserRole']);
Route::get('/admin/get/list/branch',                          [UserController::class, 'getListBranch']);
Route::get('/rebate/get/list/manual/{userid}',                [RebateController::class, 'getListRebate']);
Route::get('/rebate/get/list-manual/',                        [RebateController::class, 'getListRebateManual']);
Route::get('/rebate/get/header/{id}',                         [RebateController::class, 'getHeader']);
Route::get('/rebate/get/detail/{id}',                         [RebateController::class, 'getDetail']);
Route::post('/rebate/get/list/icg',                           [RebateController::class, 'getListICG']);
Route::get('/rebate/get/icg-detail/{id}',                     [RebateController::class, 'getICGDetail']);
Route::get('/rebate/get/potongan-manual/detail/{id}',         [RebateController::class, 'getPotonganManualDetail']);
