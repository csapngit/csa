<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterStatusSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{

		DB::table('master_status')->insert([
			['module' => 'ar-confirmation',     'created_at' => \Carbon\Carbon::now(), 'status' => 'Telepon tidak diangkat'],
			['module' => 'ar-confirmation',     'created_at' => \Carbon\Carbon::now(), 'status' => 'Nomor Tidak dapat dihubungi'],
			['module' => 'ar-confirmation',     'created_at' => \Carbon\Carbon::now(), 'status' => 'Layanan kotak suara'],
			['module' => 'ar-confirmation',     'created_at' => \Carbon\Carbon::now(), 'status' => 'Salah sambung'],
			['module' => 'ar-confirmation',     'created_at' => \Carbon\Carbon::now(), 'status' => 'Sales kungjungan ke toko dan tidak ada pembayaran'],
			['module' => 'routing',             'created_at' => \Carbon\Carbon::now(), 'status' => 'Unassigned'],
			['module' => 'routing',             'created_at' => \Carbon\Carbon::now(), 'status' => 'Assigned'],
			['module' => 'delman',              'created_at' => \Carbon\Carbon::now(), 'status' => 'Received'],
			['module' => 'delman',              'created_at' => \Carbon\Carbon::now(), 'status' => 'Partial Received'],
			['module' => 'delman',              'created_at' => \Carbon\Carbon::now(), 'status' => 'Rejected'],
		]);
	}
}
