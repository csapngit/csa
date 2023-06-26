<?php

namespace App\Http\Controllers\TDS;

use App\Http\Controllers\Controller;
use App\Imports\TDS\IncentiveImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class IncentiveController extends Controller
{
	public function index()
	{
		return view('tds.imports.incentive');
	}

	public function import(Request $request)
	{
		Excel::import(new IncentiveImport, $request->incentive);

		return back();
	}
}
