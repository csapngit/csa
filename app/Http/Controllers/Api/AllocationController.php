<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AllocationController extends Controller
{
	public function __invoke(Request $request)
	{
		try {
			$allocations = DB::connection('192.168.11.24')->table('tds_allocation')->get();

			return response()->json([
				'status' => 200,
				'success' => true,
				'message' => __('message.data_success'),
				'data' => $allocations
			]);
		} catch (\Throwable $th) {

			return response()->json([
				'status' => 500,
				'success' => false,
				'error_code' => $th->getCode(),
				'message' => $th->getMessage()
			]);
		}
	}
}
