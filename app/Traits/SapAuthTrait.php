<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait SapAuthTrait
{
	private $ipApi = 'https://192.168.12.130:50000';

	public function login($companyDb = 'CSATRAINING', $username = 'RDITS01', $password = '12345')
	{
		$url = $this->ipApi . '/b1s/v1/Login';

		$sessionId = Http::withoutVerifying()->post($url, [
			'CompanyDB' => $companyDb,
			'UserName' => $username,
			'Password' => $password,
		])->json('SessionId');

		return $sessionId;
	}

	public function logout()
	{
		$url = $this->ipApi . '/b1s/v1/Logout';

		return Http::withoutVerifying()->post($url);
	}
}
