<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ReasonController extends Controller
{
	public function __invoke(Request $request)
	{
		try {
			$reasons = DB::connection('192.168.11.24')->table('tds_reason')->get();

			return response()->json([
				'success' => true,
				'status' => Response::HTTP_OK,
				'message' => __('message.data_success'),
				'data' => $reasons
			]);
		} catch (\Throwable $th) {

			return response()->json([
				'success' => false,
				'status' => $th->getCode(),
				'message' => $th->getMessage()
			]);
		}
	}
}
