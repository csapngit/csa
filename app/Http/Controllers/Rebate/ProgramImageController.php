<?php

namespace App\Http\Controllers\Rebate;

use App\Enums\UserRoleEnum;
use App\Exports\HeaderSheetImageExport;
use App\Exports\ProgramImageExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProgramImageRequest;
use App\Http\Requests\UpdateProgramImageRequest;
use App\Models\MasterStore;
use App\Models\Program;
use App\Models\ProgramDetail;
use App\Models\ProgramImage;
use App\Models\SkuGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use \Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;
use Stevebauman\Location\Facades\Location;

class ProgramImageController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index(Request $request)
	{
		/* @var User $user */
		$user = auth()->user();

		$programImages = DB::table('program_images')
			->join('programs', 'program_images.program_id', 'programs.id')
			->join('program_details', 'program_images.program_id', 'program_details.program_id')
			->join('sku_groups', 'program_details.sku_group_id', 'sku_groups.id')
			->select([
				'program_images.id',
				'programs.name as program_name',
				'sku_groups.name as sku_group_name',
				'program_images.inventory_id',
				'program_images.customer_id',
				'program_images.normal_price',
				'program_images.promo_price',
				'program_images.depth',
				'program_details.depth as master_depth',
				'program_images.created_at',
				'programs.valid_from'
			])
			->latest();

		if ($user->role == UserRoleEnum::RO) {
			$programImages = $programImages->where('user_id', $user->id);
		}

		if ($request->periode) {
			$month_periode = explode('-', $request->periode);

			$month = $month_periode[1];

			$programImages = $programImages->whereMonth('programs.valid_from', $month)->get();
		} else {

			$programImages = $programImages->take(10)->get();
		}

		return view('rebate.post-images.index', compact('programImages'));
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		$user = auth()->user();

		$programs = Program::query()->latest('id')->get();

		$inventories = DB::table('master_inventories')->get();

		return view('rebate.post-images.create', compact('programs', 'inventories'));
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(StoreProgramImageRequest $request)
	{
		$latlong = $request->latlong;

		if ($latlong == null) {
			$latlong = '-6.1527955, 106.7347852';
		}

		$apiKey = 'AIzaSyAhoGwRGb9OrWg9a0yGenHMGDgSw6wW-Aw';

		$url = Http::get("https://maps.google.com/maps/api/geocode/json?latlng=$latlong&key=$apiKey")->json();

		$address = $url['plus_code']['compound_code'];

		$address = substr(strstr($address, " "), 1);

		try {
			DB::beginTransaction();

			$createdImage = ProgramImage::create([
				'user_id' => auth()->user()->id,
				'program_id' => $request->program_id,
				'customer_id' => $request->customer_id,
				'inventory_id' => $request->inventory_id,
				'normal_price' => $request->normal_price,
				'promo_price' => $request->promo_price,
				'depth' => $request->depth,
				'text' => $request->image->store('images', 'public'),
			]);

			$customer = DB::table('master_customers')->where('CustId', $createdImage->customer_id)->first(['CustId', 'Name']);

			// $flagImage = Image::make($request->file('image'))->orientate()->resize(900, 700);
			$flagImage = Image::make($request->file('image'))->orientate()->resize(900, 1000);

			$flagImage->insert(public_path('media/watermarks/footer.png'), 'bottom');

			//Customer ID
			$customerName = trim($customer->Name);
			// $this->textWatermark($flagImage, $customerName, 10, 570);
			$this->textWatermark($flagImage, $customerName, 10, 870);

			// Program Name
			$programName = $createdImage->program->program_detail->sku_group->name;
			// $this->textWatermark($flagImage, $programName, 10, 600);
			$this->textWatermark($flagImage, $programName, 10, 900);

			// Address
			// $this->textWatermark($flagImage, $address, 10, 630);
			$this->textWatermark($flagImage, $address, 10, 930);

			// Latlong
			// $this->textWatermark($flagImage, $latlong, 10, 660);
			$this->textWatermark($flagImage, $latlong, 10, 960);

			$date_time = now();

			$program_valid = $createdImage->program->valid_until;

			if ($date_time->gt($program_valid)) {
				$date_time = $program_valid;
			}

			// Date
			$validFrom = $date_time->format('d F Y');
			// $this->textWatermark($flagImage, $validFrom, 10, 690);
			$this->textWatermark($flagImage, $validFrom, 10, 990);

			// Time
			$timezone = now()->format('H:i');
			// $this->textWatermark($flagImage, $timezone, 190, 690);
			$this->textWatermark($flagImage, $timezone, 190, 990);

			// return $flagImage->response();

			$flagImage->save('storage/' . $createdImage->text);

			DB::commit();
		} catch (\Throwable $th) {
			DB::rollBack();

			return $th->getMessage();
		}

		return back()->with('success', __('message.data_saved'));
	}

	/**
	 * Display the specified resource.
	 */
	public function show(ProgramImage $programImage)
	{
		return view('rebate.post-images.show', compact('programImage'));
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(ProgramImage $programImage)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(UpdateProgramImageRequest $request, ProgramImage $programImage)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(ProgramImage $programImage)
	{
		$programImage->delete();

		return back()->with('success', __('message.data_deleted'));
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

	public function showDepth(Request $request)
	{
		$depth = ProgramDetail::where('program_id', $request->program_id)->first('depth');

		return response()->json($depth);
	}

	public function indexExport()
	{
		$stores = DB::table('master_stores')
			->where('code', '<>', '-')
			->where('code', '<>', 'new store')
			->get();

		return view('rebate.post-images.exports.index', compact('stores'));
	}

	public function export(Request $request)
	{
		$periode = request()->periode;

		$flag = explode('/', $periode);

		$date = $flag[0];

		$year = $flag[1];

		$fileName = MasterStore::where('code', $request->store_id)->first()->name;

		return Excel::download(new ProgramImageExport, $fileName . ' ' . $date . $year . '.xlsx');

		// return Excel::download(new HeaderSheetImageExport, 'test.xlsx');
	}
}
