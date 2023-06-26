<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

trait ApiPostTrait
{
	public function post($collection, string $endpoint, string $module)
	{
		$data = $collection;

		if (!is_array($collection)) {
			$data = $collection->toArray();
		}

		// dd($data);

		$token = env('TOKEN_TDS');

		$response = Http::withToken($token)->post(env('API_TDS') . $endpoint, $data);

		$message = $response->json('message');

		// dd($message);

		DB::connection('192.168.11.24')->table('api_logs')->insert([
			'name' => $module,
			'method' => 'POST',
			'message' => json_encode($message),
			'created_at' => now(),
			'updated_at' => now(),
		]);

		return response()->json([
			'success' => $response->successful(),
			'message' => $message
		]);
	}
}
