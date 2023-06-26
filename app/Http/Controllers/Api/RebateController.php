<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RebateDetail;
use App\Models\RebateHeader;
use App\Models\RebateIcg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RebateController extends Controller
{
  public function getListRebate($userid)
  {
    $result = DB::table('rebate_headers as r')
      ->select('r.*', 's.status as statusdesc', 's.style')
      ->leftjoin('rebate_status_types as s', 'r.status', '=', 's.id')
      ->where('r.userid', $userid)
      ->get();

    return $result;
  }

  public function getListRebateManual(Request $request)
  {
    $result = RebateHeader::where('nomor', 'like', '%' . $request->q . '%')->get();
    return $result;
  }

  public function getListICG()
  {
    $result = RebateIcg::get();
    return $result;
  }
  public function getICGDetail($id)
  {
    $result = RebateIcg::find($id);
    return $result;
  }

  public function getDetail($id)
  {
    $result = RebateDetail::where('header', $id)->get();
    return $result;
  }

  public function getHeader($id)
  {
    $result = RebateHeader::find($id);

    return $result;
  }

  public function getPotonganManualDetail($id)
  {
    $result = RebateDetail::where('header', $id)->get();
    return $result;
  }
}
