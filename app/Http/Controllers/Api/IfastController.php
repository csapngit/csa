<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class IfastController extends Controller
{
	public function __invoke(Request $request)
	{
		try {
			$Ifast = DB::connection('192.168.11.24')->table('tds_ifast')->get();

			return response()->json([
				'success' => true,
				'status' => Response::HTTP_OK,
				'message' => __('message.data_success'),
				'data' => $Ifast
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
