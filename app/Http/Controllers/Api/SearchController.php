<?php

namespace App\Http\Controllers\Api;

use App\Classes\Theme\Menu;
use App\Models\MasterCustomer;
use App\Models\MasterInventory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kizzi\Autorisasi\Autorisasi;
use Kizzi\Fungsi\Fungsi;

class SearchController extends Controller
{
    public function getCustomer($custid)
    {
      $result = MasterCustomer::where('CustId', $custid)->first();
      return $result;
    }

    public function getListCustomer(Request $request)
    {
      $temp = MasterCustomer::select('CustId', 'Name')
                ->where('CustId', 'like', '%'.$request->q.'%')
                  ->orwhere('Name', 'like', '%'.$request->q.'%')->get();
      $result = array();
      foreach($temp as $value)
      {
          $result[] = array(
                      'custid'    => ltrim(rtrim($value->CustId)),
                      'name'     => ltrim(rtrim($value->CustId)) . ' - ' . ltrim(rtrim($value->Name)),
                      'tokens'    => explode(' ', ltrim(rtrim($value->Name)))
          );
      }
      return response()->json($result);
    }

    public function getListInventory(Request $request)
    {
      $temp = MasterInventory::select('InvtId', 'Descr')
              ->where('Area', 'CSAJ')
              ->where('InvtId', 'like', '%'.$request->q.'%')
              ->orwhere('Descr', 'like', '%'.$request->q.'%')->get();
      $result = array();
      foreach($temp as $value)
      {
          $result[] = array(
                      'invtid'    => ltrim(rtrim($value->InvtId)),
                      'descr'     => ltrim(rtrim($value->InvtId)) . ' - ' . ltrim(rtrim($value->Descr)),
                      'tokens'    => explode(' ', ltrim(rtrim($value->Descr)))
          );
      }
      return response()->json($result);
    }

}
