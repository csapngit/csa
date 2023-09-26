<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enums\AreaEnum;
use App\Mail\DsrCSAJ;
use App\Mail\DsrCSAS;
use App\Services\DailySalesReportService;
use App\Mail\TrackingPayment;
use App\Services\TrackingPaymentService;
use App\Mail\Arday;
use App\Services\ARDayService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ReportMailerController extends Controller
{
	public function index()
	{
		return view('reports.mailer.index');
	}
}
