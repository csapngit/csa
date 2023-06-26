<?php

namespace App\Http\Controllers\Rebate;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVoucherApproveRequest;
use App\Models\Approve;
use App\Models\Key;
use Illuminate\Support\Facades\DB;

class VoucherApproveController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    // $keys = Key::all();

    // $keys = DB::table('keys')
    // ->where('status_um', '<>', true)
    // ->orWhere('status_rm', '<>', true)
    // ->get();

    // dd($keys);

    return view('rebate.approves.index');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StoreVoucherApproveRequest $request)
  {
    $keyId = $request->key_id;

    $update =  DB::table('keys')
      ->where('id', $keyId);

    switch ($request->action) {
      case 'approve_um':
        try {
          DB::beginTransaction();
          $update->update([
            'status_um' => true,
          ]);

          Approve::updateOrCreate(
            ['key_id' => $keyId],
            ['attachment_um' => $request->imageFile,]
          );

          DB::commit();

          return back()->with('success', __('message.data_saved'));
        } catch (\Throwable $th) {
          DB::rollBack();

          return back()->with('warning', __('message.data_warning'));
        }
        break;

      case 'approve_rm':
        try {
          DB::beginTransaction();
          $update->update([
            'status_rm' => true,
          ]);

          Approve::updateOrCreate(
            ['key_id' => $keyId],
            ['attachment_rm' => $request->imageFile,]
          );

          DB::commit();

          return back()->with('success', __('message.data_saved'));
        } catch (\Throwable $th) {
          DB::rollBack();

          return back()->with('warning', __('message.data_warning'));
        }
        break;
    }
  }
}
