<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

trait ApiPostTrait
{
	public function post($collection, string $endpoint, string $module, $isPostApi = [false])
	{
		DB::beginTransaction();
		try {
			$data = $collection;

			if (!is_array($collection)) {
				$data = $collection->toArray();
			}

			$token = env('TOKEN_TDS');

			$response = Http::withToken($token)->post(env('API_TDS') . $endpoint, $data);

			$message = $response->json('message');

			if ($isPostApi[0]) {

				$tableName = $isPostApi[1];

				DB::connection('192.168.11.24')
					->table($tableName)
					->where('isPostApi', null)
					->update(['isPostApi' => true]);
			}

			DB::connection('192.168.11.24')->table('api_logs')->insert([
				'name' => $module,
				'method' => 'POST',
				'message' => json_encode($message),
				'created_at' => now(),
				'updated_at' => now(),
			]);

			DB::commit();

			return response()->json([
				'success' => $response->successful(),
				'message' => $message
			]);
		} catch (\Throwable $th) {
			DB::rollBack();

			return $th->getMessage();
		}
	}
}
