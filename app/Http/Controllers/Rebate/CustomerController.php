<?php

namespace App\Http\Controllers\Rebate;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerImportRequest;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Imports\ClaimCustomersImport;
use App\Imports\TspCustomersImport;
use App\Models\Customer;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
	public function importCustomersTsp(CustomerImportRequest $request, Program $program)
	{
		Excel::import(new TspCustomersImport, $request->customerFile);

		return back();
	}

	public function importCustomerClaim(Request $request)
	{
		Excel::import(new ClaimCustomersImport, $request->customerFile);

		return back();
	}
}
