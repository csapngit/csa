<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DynamicSelectController extends Controller
{
	public function index()
	{
		// $data = DB::table('program_has_product')
		// ->leftJoin('master_inventories', 'program_has_product.master_inventory_id', 'master_inventories.id')
		// ->where('program_has_product.program_id', 1)
		// ->select(
		// 	'master_inventories.id',
		// 	'master_inventories.InvtID',
		// 	'master_inventories.Descr',
		// )
		// ->get();

		// return response()->json($data);

		return now()->format('d F Y, H:i');
	}

	public function showCustomer(Request $request)
	{
		// $data = Customer::where('program_id', $request->program_id)->get();

		$data = DB::table('customers')
			->join('master_customers', 'customers.customer_id', 'master_customers.CustId')
			->where('customers.program_id', $request->program_id)
			->select(
				'customers.id',
				'customers.customer_id',
				'master_customers.Name',
			)
			->get();

		return response()->json($data);
	}

	public function inventoryByProgramId(Request $request)
	{
		$data = DB::table('program_has_product')
		->leftJoin('master_inventories', 'program_has_product.inventory_id', 'master_inventories.InvtID')
		->where('program_has_product.program_id', $request->program_id)
		->select(
			'master_inventories.id',
			'master_inventories.InvtID',
			'master_inventories.Descr',
		)
		->get();

		return response()->json($data);
	}
}
