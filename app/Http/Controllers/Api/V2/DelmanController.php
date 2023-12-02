<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Models\DelmanVisit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DelmanController extends Controller
{
	function fjp($delman)
	{
		$result = DB::table('VW_DELMAN_ROUTES')->where('delman_id', $delman)->get();;
		return $result;
	}

	// function checkIn($delman)
	// {
	// 	$simpan = new DelmanVisit();
	// 	$simpan->delman_id = $delman;
	// 	$simpan->tanggal = Carbon::now()->format('Y-m-d');
	// 	$simpan->time_in = Carbon::now()->format('H:i:s');
	// 	// $simpan->time_out = Carbon::now()->format('H:i:s');
	// 	$simpan->save();
	// 	return $simpan;
	// }

	function checkIn($delman)
	{
		$simpan = new DelmanVisit();
		$tanggal = date('Y-m-d');
		$simpan->delman_id = $delman;
		// $timeout = Carbon::now()->format('Y-m-d H:i:s');
		$cek_double = $simpan->where(['tanggal' => $tanggal, 'delman_id' => $delman])->count();
		if ($cek_double > 0) {
			return 'error';
		} else {
			$simpan->tanggal = Carbon::now()->format('Y-m-d');
			$simpan->time_in = Carbon::now()->format('H:i:s');
			// $simpan->time_out = Carbon::now()->format('H:i:s');
			$simpan->save();
			return 'sukses';
		}
	}


	function checkOut($delman, Request $request)
	{
		$update = new DelmanVisit();
		$tanggal = date('Y-m-d');
		$time_out = date('H:i:s');
		$update->delman_id = $delman;
		$update->time_out = $time_out;
		// $cek_timeout= $update->where(['time_out'=>$time_out,'tanggal'=>'tanggal'])->get()->first();
		$cek_double = $update->where(['tanggal' => $tanggal, 'delman_id' => $delman])->count();
		if ($cek_double > 0) {
			$update->where(['tanggal' => $tanggal, 'delman_id' => $delman])
				->update([
					'time_out' => Carbon::now($request->time_out)->format('H:i:s')
				]);
			return 'sukses';
			// } else if ($time_out != Null) {
			// 	return 'warning';
		} else {
			return 'error';
		}
	}
}
