<?php

namespace App\Http\Controllers\Rebate;

use App\Http\Controllers\Controller;
use App\Models\MasterCustomer;
use Illuminate\Http\Request;
use App\Models\RebateDocumentType;
use App\Models\RebateHeader;
use App\Models\RebateDetail;
use App\Models\MasterInventory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Kizzi\Fungsi\Fungsi;

class RebateController extends Controller
{
  protected $header;
  protected $detail;

  /**
   * JurnalController constructor.
   * @param $header
   * @param $detail
   */
  public function __construct(RebateHeader $header, RebateDetail $detail)
  {
    $this->middleware('auth');
    $this->header = $header;
    $this->detail = $detail;
  }

  public function index()
  {
    // return $this->getCustomer('0000003', 'S4Future11');
    $page_title = 'Potongan Manual';
    $page_description = 'Some description for the page';
    return view('rebate.manual.list', compact('page_title', 'page_description'));
  }

  public function create()
  {
    $page_title = 'Entry Potongan Manual';
    $page_description = 'Form input potongan manual dari toko';
    $documentType = RebateDocumentType::all();
    return view('rebate.manual.entry', compact('page_title', 'page_description', 'documentType'));
  }

  public function store(Request $request)
  {
    // return $request->all();
    $nomor = Fungsi::generateNomor('rebate', Auth::user()->area);
    $editmode = 0;
    if ($request->input('method') == 'save') {
      $simpan = new $this->header();
      $simpan->nomor = $nomor;
      $simpan->userid = Auth::user()->id;
      $simpan->status = 1;
    } else {
      $simpan = $this->header->find($request->input('id'));
      $editmode = 1;
    }
    $simpan->nomorkwitansi = $request->input('nokwitansi');
    $simpan->custid = $request->input('custid');
    $simpan->name = $this->getCustomer($request->input('custid'));
    $simpan->pkp = $this->getCustomer($request->input('custid'), 'S4Future11');
    $simpan->jenispotongan = $request->input('jenispotongan');
    $simpan->total = $request->input('total');
    $simpan->catatan = $request->input('catatan');
    $simpan->save();

    $this->detail->where('header', $simpan->id)->delete();
    if ($request->input('jenispotongan') == 'TPR') {
      $arrSKU = $request->input('arrSKU');
      $arrAmount = $request->input('arrAmount');
      for ($i = 0; $i < count($arrSKU); $i++) {
        if (($arrSKU[$i] != "") && (Fungsi::cekEmpty($arrAmount[$i]) != 0)) {
          $simpandetail = new $this->detail();
          $simpandetail->header = $simpan->id;
          $simpandetail->invtid = $arrSKU[$i];
          $simpandetail->descr = $this->getSkuDescr($arrSKU[$i]);
          $simpandetail->amount = Fungsi::cekEmpty($arrAmount[$i]);
          $simpandetail->save();
        }
      }
    }

    if ($simpan) {
      //            if ($request->input('method') == 'save') {
      ////                Fungsi::simpanLog(Auth::user()->id, '/approval-barang/store', 'save',$simpan->id, 'Simpan data approval barang');
      //            }else{
      ////                Fungsi::simpanLog(Auth::user()->id, '/approval-barang/store', 'edit', $request->input('id'), 'Simpan edit data approval barang');
      //            }
      if ($editmode == 1) {
        $pesan = 'Data berhasil diupdate';
      } else {
        $pesan = 'Data berhasil disimpan dengan nomor : ' . $nomor;
      }

      return redirect()->route('rebate')->with('status', 'success')->with('pesan', $pesan);
    } else {
      return redirect()->route('rebate')->with('Error', 'Failed.')->with('pesan', 'Data gagal disimpan');;
    }
  }

  public function edit($id)
  {
    $page_title = 'Entry Potongan Manual';
    $page_description = 'Form input potongan manual dari toko';
    $documentType = RebateDocumentType::all();
    $edit = $this->header->find($id);
    $detail = $this->detail->where('header', $id)->get();
    return view('rebate.manual.entry', compact('page_title', 'page_description', 'documentType', 'edit', 'detail'));
  }

  public function getSkuDescr($invtid)
  {
    $inventory = MasterInventory::where('InvtId', $invtid)->first();
    if ($inventory !== null) {
      $result = ltrim(rtrim($inventory->Descr));
    } else {
      $result = '';
    }
    return $result;
  }

  public function getCustomer($custid, $field = 'Name')
  {
    $customer = MasterCustomer::where('CustId', $custid)->first();
    if ($customer !== null) {
      $result = ltrim(rtrim($customer->$field));
    } else {
      $result = '';
    }
    return $result;
  }
}
