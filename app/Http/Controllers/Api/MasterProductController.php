<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class MasterProductController extends Controller
{
	public function __invoke()
	{
		try {
			$products = DB::connection('192.168.11.24')->table('tds_prodmaster')->get();

			return response()->json([
				'success' => true,
				'status' => Response::HTTP_OK,
				'message' => __('message.data_success'),
				'data' => $products
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
