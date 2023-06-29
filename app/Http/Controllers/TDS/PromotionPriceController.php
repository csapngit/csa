<?php

namespace App\Http\Controllers\TDS;

use App\Http\Controllers\Controller;
use App\Imports\TDS\PromoPriceImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PromotionPriceController extends Controller
{
	public function index()
	{
		return view('tds.imports.promoPrice');
	}

	public function import(Request $request)
	{
		Excel::import(new PromoPriceImport, $request->promoPrice);

		return back();
	}
}
