<?php

namespace App\Http\Controllers\Logistic;

use App\Http\Controllers\Controller;
use App\Models\DelmanRouteDetail;
use App\Models\DelmanRoutes;
use App\Models\DelmanVisit;
use App\Models\MasterStatus;
use App\Models\SAPBusinessPartner;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use \Intervention\Image\Facades\Image;
use PhpParser\Node\Stmt\Return_;
use Psy\Readline\Hoa\ConsoleOutput;

class DelmanController extends Controller
{
	protected $delmanRoute;
	protected $delmanRouteDetail;

	function __construct(DelmanRoutes $delmanRoute, DelmanRouteDetail $delmanRouteDetail)
	{
		$this->middleware('auth');
		$this->delmanRoute = $delmanRoute;
		$this->delmanRouteDetail = $delmanRouteDetail;
	}

	function index()
	{
		$delman = Auth::user()->delman;
		$page_title = 'FJP Delman';
		$page_description = '';

		return view('delman.index', compact('page_title', 'page_description'))->with(
			'delman',
			$delman
		);
	}

	function show($route)
	{
		$route = DelmanRoutes::find($route);
		$reason = MasterStatus::where('module', 'delman')->get();

		$tmp = DB::connection('192.168.11.24')->table('tds_orderdata')->where('OrderNo', $route->nomor_so)->first();
		// return $linkFoto;
		$linkFoto = '';
		if ($tmp) {
			$linkFoto = $tmp->LinkFoto2;
		}

		$visit = new DelmanVisit();
		$delman = Auth::user()->delman;
		$tanggal = date('Y-m-d');
		$page_title = 'FJP Delman';
		$page_description = '';

		$cek_visit = DelmanVisit::where(['delman_id' => $delman, 'tanggal' => $tanggal])->get()->first();
		if (is_null($cek_visit)) {
			return view('delman.index', compact('page_title', 'page_description'))->with(
				'delman',
				$delman
			);
		} else {
			return view('delman.visit', compact('route', 'reason'))->with('linkFoto', $linkFoto);
		}
		// return $linkFoto;

	}

	function store(Request $request)
	{
		// return $request->all();
		$route = $this->delmanRoute::find($request->input('route'));
		// return $route;

		$jarak = $this->checkCompliance($request->input('store_latitude'), $request->input('store_longitude'), $request->input('actual_latitude'), $request->input('actual_longitude'));
		$path = 'images/' . $route->delman_id . '/' . Carbon::now()->format('Ymd');


		if ($request->hasFile('storePicture')) {
			$image = $request->file('storePicture');
			$fileNameStore = 'Store-' . Carbon::now()->format('YmdHis') . $route->nomor_do . '.' . $image->getClientOriginalExtension();

			$rasio = 40;
			$height = '';

			$widthOri = Image::make($image->getRealPath())->width();
			$heightOri = Image::make($image->getRealPath())->height();

			$widthNew = $widthOri * $rasio / 100;
			$heightNew = $heightOri * $rasio / 100;

			$storePicture = Image::make($image->getRealPath())->orientate()->resize(900, 1000);
			// $storePicture = Image::make($image->getRealPath())->orientate()->resize($widthNew, $heightNew);


			$storePicture->insert(public_path('images/watermarks/footer.png'), 'bottom');

			$storeName = $route->card_code . ' - ' . $route->card_name;
			$this->textWatermark($storePicture, $storeName, 10, 870);

			$this->textWatermark($storePicture, $route->address, 10, 900);

			$this->textWatermark($storePicture, $route->delman_id, 10, 930);

			$latlong =  $request->input('store_latitude') . ' ' .  $request->input('store_longitude');
			$this->textWatermark($storePicture, $latlong, 10, 960);

			$this->textWatermark($storePicture, Carbon::now(), 10, 990);

			// return $storePicture->response();
			$storePicture->stream(); // <-- Key point

			Storage::disk('local')->put($path . '/' . $fileNameStore, $storePicture, 'public');
			$route->store_picture = $path . '/' . $fileNameStore;
		}

		if ($request->hasFile('invoicePicture')) {
			$image2 = $request->file('invoicePicture');
			$fileNameInvoice = 'Invoice-' . Carbon::now()->format('YmdHis') . $route->nomor_do . '.' . $image2->getClientOriginalExtension();

			$rasio = 40;
			$height = '';

			$widthOri = Image::make($image2->getRealPath())->width();
			$heightOri = Image::make($image2->getRealPath())->height();

			$widthNew = $widthOri * $rasio / 100;
			$heightNew = $heightOri * $rasio / 100;

			$invPicture = Image::make($image2->getRealPath())->orientate()->resize(900, 1000);
			// $storePicture = Image::make($image->getRealPath())->orientate()->resize($widthNew, $heightNew);


			$invPicture->insert(public_path('images/watermarks/footer.png'), 'bottom');

			$storeName = $route->card_code . ' - ' . $route->card_name;
			$this->textWatermark($invPicture, $storeName, 10, 870);

			$this->textWatermark($invPicture, $route->address, 10, 900);

			$this->textWatermark($invPicture, $route->delman_id, 10, 930);

			$latlong =  $request->input('store_latitude') . ' ' .  $request->input('store_longitude');
			$this->textWatermark($invPicture, $latlong, 10, 960);

			$this->textWatermark($invPicture, Carbon::now(), 10, 990);

			// return $storePicture->response();
			$invPicture->stream(); // <-- Key point

			Storage::disk('local')->put($path . '/' . $fileNameInvoice, $invPicture, 'public');
			$route->invoice_picture = $path . '/' . $fileNameInvoice;
		}


		$route->status_delivery = $request->input('reason');
		$route->actual_latitude = $request->input('actual_latitude');
		$route->actual_longitude = $request->input('actual_longitude');
		$route->note = $request->input('note');
		$route->distance = $jarak;
		$route->save();
		if ($route) {
			return redirect()->route('delman-routes')->with('Sukses', 'Delivery save successfully.');
		} else {
			return redirect()->route('delman-routes')->with('Error', 'Delivery save Failed.');
		}
	}

	function checkCompliance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
	{
		// convert from degrees to radians
		$latFrom = deg2rad($latitudeFrom);
		$lonFrom = deg2rad($longitudeFrom);
		$latTo = deg2rad($latitudeTo);
		$lonTo = deg2rad($longitudeTo);

		$latDelta = $latTo - $latFrom;
		$lonDelta = $lonTo - $lonFrom;

		$angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
			cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
		return $angle * $earthRadius;
	}

	public function textWatermark($image, string $text, int $x, int $y)
	{
		$flagImage = $image->text($text, $x, $y, function ($font) {
			$font->file(public_path('font/times.ttf'));
			$font->size(23);
			$font->color('#f1faee');
			$font->angle(0);
		});

		return $flagImage;
	}
}
