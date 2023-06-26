<?php namespace Biotrent\Nomer;

use App\Models\DeliveryOrder;
use App\Models\Payment;
use App\Models\SellingOrder;
use DB;
use Fungsi;
use Illuminate\Support\Facades\Auth;

class Nomer {

    public function getNomer($jenis, $tanggal, $tax = 0)
    {
        $strTax = '';

        switch ($jenis){
            case 'selling':
                $strjenis = "INV/BIOLET";
                if($tax > 0){
                    $myTable = SellingOrder::select(DB::raw('SUBSTRING(nomor, 16, 3) as nomor'))->where('tax', '>', 0)->orderby(DB::raw('SUBSTRING(nomor, 16, 3)'), 'desc');
                }else{
                    $myTable = SellingOrder::select(DB::raw('SUBSTRING(nomor, 19, 3) as nomor'))->where('tax', '<=', $tax)->orderby(DB::raw('SUBSTRING(nomor, 19, 3)'), 'desc');
                    $strTax = "/NP";
                }
                break;
            case 'delivery':
                $strjenis = "SJ/BIOLET";
                $myTable = DeliveryOrder::select(DB::raw('SUBSTRING(nomor, 15, 3) as nomor'))->orderby(DB::raw('SUBSTRING(nomor, 15, 3)'), 'desc');
                break;
            case 'payment':
                $strjenis = "PAY/BIOLET";
                $myTable = Payment::select(DB::raw('SUBSTRING(nomor, 16, 3) as nomor'))->orderby(DB::raw('SUBSTRING(nomor, 16, 3)'), 'desc');
                break;
            default:
                $strjenis = '';
                break;
        }

        $result = $myTable->where(DB::raw('Year(tanggal)'), '=', $tanggal->year)->first();
//        dd($result);
        $no = 1;
        if (count($result) > 0){
            $no += intval($result->nomor);
        }

        $nomorgabung =   $strjenis . "/" . $this->getInisialCompany() . $strTax . "/" . Fungsi::makeNomorToString($no) . "/" . Fungsi::intToMonth($tanggal->month) . "/" . $tanggal->year;
        return $nomorgabung;
    }

    private function getInisialCompany()
    {
        $data = "BMJ";


        return $data;
    }

	public function getNomerJurnal($tanggal)
	{							
		
		$result = Jurnal::select(DB::raw('RIGHT(nojurnal, 4) as nomor'))
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

	
}