<?php namespace Biotrent\Ledger;

use App\Models\Accounting\Jurnal;
use App\Models\Accounting\JurnalDetail;
use App\Models\Accounting\JurnalGroup;
use App\Models\Backoffice\Barang;
use App\Models\Backoffice\Customer;
use App\Models\Backoffice\InvoiceOutDetail;
use App\Models\Backoffice\Marketing;
use App\Models\Backoffice\Project;
use App\Models\Backoffice\PurchaseOrder;
use App\Models\Backoffice\SellingOrder;
use App\Models\SettingAkun;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;

class Ledger
{
    protected $header;
    protected $detail;

    /**
     * Jurnal constructor.
     * @param $header
     * @param $detail
     */
    public function __construct(Jurnal $header, JurnalDetail $detail)
    {
        $this->header = $header;
        $this->detail = $detail;
    }

    private function JurnalHeader($tanggal, $noreff, $group_id)
    {
        $simpan = new $this->header();
        $simpan->nojurnal = $this->getNomerJurnal(Carbon::createFromFormat('d-m-Y', $tanggal));
        $simpan->tanggal = Carbon::createFromFormat('d-m-Y', $tanggal);
        $simpan->noref = $noreff;
        $simpan->group_id = $group_id;
        $simpan->input_by = Auth::user()->id;
        $simpan->save();

        return $simpan->id;
    }

    public function jurnalReceive($nomor, $request)
    {
        $header = $this->JurnalHeader($request['tanggal'], $nomor, 3);
        for($i = 0; $i < count($request['barangid']); $i++)
        {

            if ((!$request['barangid'][$i] == "") && (!$request['qty'][$i] == "")) {
                //DEBIT
                $detail = new $this->detail();
                $detail->header_id = $header;
                $detail->akun_id = $this->getAkun('persediaan-barang');
                $detail->keterangan = 'Penerimaan barang ' . $request['nmbarang'][$i] . ' dengan qty: ' . $request['qty'][$i];
                $detail->debit = $this->getNilai('receive', $request['reff_id'], $request['barangid'][$i], $request['qty'][$i]);
                $detail->kredit = 0;
                $detail->save();

                //KREDIT
                $detail = new $this->detail();
                $detail->header_id = $header;
                $detail->akun_id = $this->getAkun('hutang-penerimaan-barang');
                $detail->keterangan = 'Penerimaan barang ' . $request['nmbarang'][$i] . ' dengan qty: ' . $request['qty'][$i];
                $detail->debit = 0;
                $detail->kredit = $this->getNilai('receive', $request['reff_id'], $request['barangid'][$i], $request['qty'][$i]);
                $detail->save();
            }
        }

        return $header;
    }

    public function JurnalDelivery($nomor, $request)
    {
        $header = $this->JurnalHeader($request['tanggal'], $nomor, 3);

        for($i = 0; $i < count($request['barangid']); $i++)
        {

            if ((!$request['barangid'][$i] == "") && (!$request['qty'][$i] == "")) {
                //DEBIT
                $detail = new JurnalDetail();
                $detail->header_id = $header;
                $detail->akun_id = 52;
                $detail->keterangan = 'Pengiriman barang ' . $request['barang'][$i] . ' dengan qty: ' . $request['qty'][$i];
                $detail->debit = $this->getNilai('delivery', $request['noreff'], $request['barangid'][$i], $request['qty'][$i]);
                $detail->kredit = 0;
                $detail->save();

                //KREDIT
                $detail = new JurnalDetail();
                $detail->header_id = $header;
                $detail->akun_id = 20;
                $detail->keterangan = 'Pengiriman barang ' . $request['barang'][$i] . ' dengan qty: ' . $request['qty'][$i];
                $detail->debit = 0;
                $detail->kredit = $this->getNilai('delivery', $request['noreff'], $request['barangid'][$i], $request['qty'][$i]);
                $detail->save();
            }
        }

        return $header;
    }

    public function JurnalInvoice($nomer, $request)
    {
        $header = $this->JurnalHeader($request['tanggal'], $nomer, 7);


        for($i = 0; $i < count($request['inv']); $i++)
        {
            if($request['jenis'][$i] == 'DELIVERY'){
                $noreff = $this->getSellingDetail($request['inv'][$i], 'nomor');
            }else{
                $noreff = $this->getProjectDetail($request['inv'][$i], 'nomor');
            }

            //DEBIT
            $detail = new JurnalDetail();
            $detail->header_id = $header;
            $detail->akun_id = $this->getAkunInvoice($request['jenis'][$i], 'piutang', $request['inv'][$i]);
            $detail->keterangan = 'Invoice of ' . $noreff;
            $detail->kredit = 0;
            if(str_replace(',','',$request['disc'][$i]) > 0)
            {
                $detail->debit = str_replace(',','',$request['subtotal'][$i]);
                $detail->save();
                $detail = new JurnalDetail();
                $detail->header_id = $header;
                $detail->akun_id = $this->getAkunInvoice($request['jenis'][$i], 'disc', $request['inv'][$i]);
                $detail->keterangan = 'Disc of ' . $noreff;
                $detail->debit = str_replace(',','',$request['disc'][$i]);
                $detail->kredit = 0;
                $detail->save();
            }else{
                $detail->debit = str_replace(',','',$request['total'][$i]);
                $detail->save();
            }

            //KREDIT
            $detail = new JurnalDetail();
            $detail->header_id = $header;
            $detail->akun_id = $this->getAkunInvoice($request['jenis'][$i], 'pendapatan', $request['inv'][$i]);
            $detail->keterangan = 'Invoice of ' . $noreff;
            $detail->debit = 0;
            if(str_replace(',','',$request['tax'][$i]) > 0)
            {
                $detail->kredit = str_replace(',','',$request['subtotal'][$i]);
                $detail->save();
                $detail = new JurnalDetail();
                $detail->header_id = $header;
                $detail->akun_id = $this->getAkunInvoice($request['jenis'][$i], 'tax', $request['inv'][$i]);
                $detail->keterangan = 'Invoice of ' . $noreff;
                $detail->debit = 0;
                $detail->kredit =str_replace(',','',$request['tax'][$i]);
                $detail->save();
            }else{
                $detail->kredit = str_replace(',','',$request['total'][$i]);
                $detail->save();
            }
        }

        return $header;
    }

    public function JurnalExpense($request)
    {
        $header = $this->JurnalHeader($request['tanggal'], $this->getNomorPO($request['nopo']), 6);
        for($i = 0; $i < count($request['akun']); $i++)
        {
            //DEBIT
            $detail = new JurnalDetail();
            $detail->header_id = $header;
            $detail->akun_id = 53;
            $detail->keterangan = $request['keterangan'][$i];
            $detail->debit = $request['nilai'][$i];
            $detail->kredit = 0;
            $detail->save();

            //KREDIT
            $detail = new JurnalDetail();
            $detail->header_id = $header;
            $detail->akun_id = $request['akun'][$i];
            $detail->keterangan = $request['keterangan'][$i];
            $detail->debit = 0;
            $detail->kredit = $request['nilai'][$i];
            $detail->save();
        }

        return $header;
    }

    public function JurnalPayment($nomor, $request)
    {
        $header = $this->JurnalHeader($request['tanggal'], $nomor, 8);

        //DEBIT
        $detail = new JurnalDetail();
        $detail->header_id = $header;
        $detail->akun_id = $request['debit'];
        $detail->keterangan = "Pembayaran invoice: $nomor";
        $detail->debit = $request['nilai'];
        $detail->kredit = 0;
        $detail->save();

        //KREDIT
        $inv = InvoiceOutDetail::where('header_id', $request['reff'])->get();
        foreach($inv as $value)
        {
            $detail = new JurnalDetail();
            $detail->header_id = $header;
            $detail->akun_id = $this->getAkunInvoice($value->jenis, 'piutang', $value->reff_id);
            $detail->keterangan = "Pembayaran invoice: $nomor";
            $detail->debit = 0;
            $detail->kredit = $value->total;
            $detail->save();
        }

        return $header;
    }

    public function JurnalCommision($nomor, $request)
    {
        $header = $this->JurnalHeader($request['tanggal'], $nomor, 9);

        $total = 0;
        for($i = 0; $i < count($request['reff']); $i++)
        {
            //DEBIT
            $detail = new JurnalDetail();
            $detail->header_id = $header;
            $detail->akun_id = 56;
            $detail->keterangan = 'Bayar Komisi ' . $this->getMarketing($request['marketing']) . ' nomor: ' . $request['nomorso'][$i];
            $detail->debit = $request['income'][$i];
            $detail->kredit = 0;
            $detail->save();
            $total += $request['income'][$i];
        }

        //KREDIT
        $detail = new JurnalDetail();
        $detail->header_id = $header;
        $detail->akun_id = $request['kredit'];
        $detail->keterangan = 'Bayar Komisi Marketing ' . $this->getMarketing($request['marketing']);
        $detail->debit = 0;
        $detail->kredit = $total;
        $detail->save();

        return $header;
    }


    private function getMarketing($id)
    {
        $result = Marketing::find($id);
        return $result->nmmarketing;
    }

    private function getNomorPO($poID)
    {
        $data = Project::find($poID);
        return $data->nopo;
    }

    private function getAkunInvoice($jenisInvoice, $jenisakun, $noreff)
    {
        $akun = 0;

        switch($jenisakun)
        {
            case 'piutang':
                if ($jenisInvoice == 'DELIVERY') {
                    if($this->getSellingDetail($noreff, 'customer') == 1) {
                        $akun = 14;
                    }else{
                        $akun = 16;
                    }
                }else{
                    if($this->getProjectDetail($noreff, 'jenis') == 'reguler') {
                        $akun = 12;
                    }else{
                        $akun = 13;
                    }
                }
                break;
            case 'disc':
                $akun = 50;
                break;
            case 'pendapatan':
                if ($jenisInvoice == 'DELIVERY') {
                    if($this->getSellingDetail($noreff, 'customer') == 1) {
                        $akun = 47;
                    }else{
                        $akun = 49;
                    }
                }else{
                    if($this->getProjectDetail($noreff, 'jenis') == 'reguler') {
                        $akun = 45;
                    }else{
                        $akun = 46;
                    }
                }
                break;
            case 'tax':
                $akun = 35;
                break;
        }

        return $akun;
    }

    private function getSellingDetail($noreff, $jenis)
    {
        $result = SellingOrder::select('selling_orders.nomor', 'customers.group_id')
                        ->leftjoin('customers', 'selling_orders.customer_id', '=', 'customers.id')
                        ->where('selling_orders.id', $noreff)
                        ->first();

        if($jenis == 'customer'){
            return $result->group_id;
        }else{
            return $result->nomor;
        }
    }

    private function getProjectDetail($projID, $jenis)
    {
        $result = Project::find($projID);
        if($jenis == 'jenis'){
            return $result->jenis;
        }else{
            return $result->nopo;
        }
    }
    private function getNilai($jenis, $reff_id, $barang_id, $qty)
    {
        $result = 0;
        switch ($jenis)
        {
            case 'delivery':
                $data = Barang::find($barang_id);
                $result = $data->hargabeli * $qty;
                break;
            case 'receive':
                $data = PurchaseOrder::company()
                    ->select('purchase_orders.disc', 'purchase_orders.tax', 'purchase_order_details.harga')
                    ->leftjoin('purchase_order_details', 'purchase_orders.id', '=', 'purchase_order_details.header_id')
                    ->where('purchase_orders.id', $reff_id)
                    ->where('purchase_order_details.barang_id', $barang_id)
                    ->first();

                $disc = intval($data->harga) * intval($data->disc) / 100;
                $subtotal = intval($data->harga) - $disc;
                $tax = $subtotal * intval($data->tax) / 100;
                $total = $subtotal + $tax;
                $result = $total * $qty;
                break;
        }

        return $result;
    }

    public function getNomerJurnal($tanggal)
    {

        $result = $this->header->select(DB::raw('RIGHT(nojurnal, 4) as nomor'))
            ->where(DB::raw('Year(tanggal)'), '=', $tanggal->year)
            ->where(DB::raw('Month(tanggal)'), '=', $tanggal->month)
            ->orderby(DB::raw('RIGHT(nojurnal, 4)'), 'DESC')
            ->first();


        $no = 1;
        if (count($result) > 0){
            $no += intval($result->nomor);
        }

        switch (strlen($no)) {
            case 1:
                $no = "000" . $no;
                break;
            case 2;
                $no = "00" . $no;
                break;
            case 3;
                $no = "0" . $no;
                break;
        }

        $nomorgabung = $tanggal->year . $tanggal->month . $no;
        return $nomorgabung;
    }

    private function getAkun($jenis)
    {
        $result = SettingAkun::where('jenis', $jenis)->pluck('akun_id');
        return $result;
    }
}