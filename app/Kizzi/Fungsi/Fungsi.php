<?php

namespace Kizzi\Fungsi;

use App\Models\MasterArea;
use App\Models\RebateHeader;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Fungsi
{

  public static function generateNomor($jenis, $area)
  {
    switch ($jenis) {
      case 'rebate':
        //VCM/CSA/0001/VII/2022
        $strjenis = "VCM";
        $myTable = RebateHeader::select(DB::raw('SUBSTRING(nomor, 10, 5) as nomor'))->orderby(DB::raw('SUBSTRING(nomor, 10, 5)'), 'desc');
        break;
      default:
        $strjenis = '';
        break;
    }

    $result = $myTable->where(DB::raw('Year(created_at)'), '=', date("Y"))->first();
    $no = 1;
    if ($result === null) {
    } else {
      $no += intval($result->nomor);
    }

    $nomorgabung =   $strjenis . "/" . Fungsi::idToArea($area) . "/" . Fungsi::makeNomorToString($no) . "/" . Fungsi::intToMonth(date('m')) . "/" . date('Y');
    return $nomorgabung;
  }

  public static function intToMonth($bulan)
  {
    switch ($bulan) {
      case 1:
        $hasil = "I";
        break;
      case 2:
        $hasil = "II";
        break;
      case 3:
        $hasil = "III";
        break;
      case 4:
        $hasil = "IV";
        break;
      case 5:
        $hasil = "V";
        break;
      case 6:
        $hasil = "VI";
        break;
      case 7:
        $hasil = "VII";
        break;
      case 8:
        $hasil = "VIII";
        break;
      case 9:
        $hasil = "IX";
        break;
      case 10:
        $hasil = "X";
        break;
      case 11:
        $hasil = "XI";
        break;
      case 12:
        $hasil = "XII";
        break;
      default:
        $hasil = "";
        break;
    }
    return $hasil;
  }

  public function getMonthName($value)
  {
    $month = [];
    $month[0] = "Januari";
    $month[1] = "Februari";
    $month[2] = "Maret";
    $month[3] = "April";
    $month[4] = "Mei";
    $month[5] = "Juni";
    $month[6] = "Juli";
    $month[7] = "Agustus";
    $month[8] = "September";
    $month[9] = "Oktober";
    $month[10] = "Nopember";
    $month[11] = "Desember";
    return $month[$value];
  }

  public function terbilang($angka)
  {
    $abil = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
    if ($angka < 12) {
      return " " . $abil[$angka];
    } elseif ($angka < 20) {
      return $this->terbilang($angka - 10) . " Belas";
    } elseif ($angka < 100) {
      return $this->terbilang($angka / 10) . " Puluh" . $this->terbilang($angka % 10);
    } elseif ($angka < 200) {
      return " Seratus" . $this->terbilang($angka - 100);
    } elseif ($angka < 1000) {
      return $this->terbilang($angka / 100) . " Ratus" . $this->terbilang($angka % 100);
    } elseif ($angka < 2000) {
      return " Seribu" . $this->terbilang($angka - 1000);
    } elseif ($angka < 1000000) {
      return $this->terbilang($angka / 1000) . " Ribu" . $this->terbilang($angka % 1000);
    } elseif ($angka < 1000000000) {
      return $this->terbilang($angka / 1000000) . " Juta" . $this->terbilang($angka % 1000000);
    } elseif ($angka < 1000000000000) {
      return $this->terbilang($angka / 1000000000) . " Milyar" . $this->terbilang($angka % 1000000000);
    }
  }

  public static function makeNomorToString($nomor)
  {
    switch (strlen($nomor)) {
      case 1:
        $result = "0000" . $nomor;
        break;
      case 2:
        $result = "000" . $nomor;
        break;
      case 3:
        $result = "00" . $nomor;
        break;
      case 4;
        $result = "0" . $nomor;
        break;
      default:
        $result = $nomor;
        break;
    }

    return $result;
  }

  public static function idToArea($id)
  {
    $result = MasterArea::find($id);
    return $result->inisial;
  }

  public static function getCustomerArea($id)
  {
    $result = User::find($id);
    return $result->area;
  }

  public function getNewMessage()
  {
    $userid = Auth::user()->id;
    $data = Message::where('status', 'new')->where('to', $userid)->count();
    return $data;
  }

  public function getAllMessage()
  {
    $userid = Auth::user()->id;
    $data = Message::where('to', $userid)->count();
    return $data;
  }

  public function getNilai($akun_id, $tanggal, $jenis, $header)
  {
    if ($header == true)
      $rumus = $this->getRumus($akun_id);
    else {
      $rumus = $this->getRumus($this->getGroupID($akun_id));
    }
    if ($rumus == 'debit') {
      $rumus = 'SUM(jurnal_details.debit - jurnal_details.kredit) as nilai';
    } elseif ($rumus = 'kredit') {
      $rumus = 'SUM(jurnal_details.kredit - jurnal_details.debit) as nilai';
    }

    $data = Akun::company()
      ->select(DB::raw($rumus))
      ->leftjoin('jurnal_details', 'akuns.id', '=', 'jurnal_details.akun_id')
      ->leftjoin('jurnals', 'jurnal_details.header_id', '=', 'jurnals.id')
      ->where(function ($query) use ($jenis, $tanggal) {
        if ($jenis == 0) { //AMBIL SALDO BULAN INI
          $periode = date('Y-m-d', strtotime($tanggal));
          $query->where(DB::raw('DATE(jurnals.tanggal)'), '<=', $periode);
        } elseif ($jenis == 1) { //LABA TAHUN BERJALAN (SALDO SAMPAI DENGAN BULAN INI DI TAHUN INI)
          $periode = date('Y-m-d', strtotime($tanggal->lastOfMonth()));
          $query->where(DB::raw('YEAR(jurnals.tanggal)'), $tanggal->year)
            ->where(DB::raw('DATE(jurnals.tanggal)'), '<=', $periode);
        } elseif ($jenis == 2) { //LABA DITAHAN (SALDO SEBELUM TAHUN INI)
          $periode = $tanggal->year . '-01-01';
          $query->where(DB::raw('DATE(jurnals.tanggal)'), '<',  $periode);
        } elseif ($jenis == 3) { // NILAI DI BULAN INI
          $query->where(DB::raw('MONTH(jurnals.tanggal)'), $tanggal->month)
            ->where(DB::raw('YEAR(jurnals.tanggal)'), $tanggal->year);
        }
      })
      ->where(function ($query) use ($akun_id, $header) {
        if ($header == true) { //AMBIL SALDO BULAN INI
          $query->where('akuns.group_id', $akun_id);
        } else {
          $query->where('akuns.id', $akun_id);
        }
      })
      ->first();

    return intval($data->nilai);
  }
  private function getRumus($group_id)
  {
    $data = AkunGroup::find($group_id);
    return $data->rumus;
  }

  private function getGroupID($header_id)
  {
    $data = Akun::find($header_id);
    return $data->group_id;
  }

  public function dFormat($tanggal)
  {
    return date('d-m-Y', strtotime($tanggal));
  }

  public static function simpanLog($user_id, $halaman, $aksi, $reff = 0, $desc = '')
  {
    $simpan = new AdminLog();
    $simpan->user_id = $user_id;
    $simpan->halaman = $halaman;
    $simpan->aksi = $aksi;
    $simpan->reff_id = $reff;
    $simpan->keterangan = $desc;
    $simpan->save();
  }

  public static function simpanNotif($reff, $from, $to, $title, $content, $icon, $status)
  {
    $simpan = new AdminNotification();
    $simpan->reff = $reff;
    $simpan->from = $from;
    $simpan->to = $to;
    $simpan->title = $title;
    $simpan->content = $content;
    $simpan->icon = $icon;
    $simpan->status = $status;
    $simpan->input_by = 1;
    $simpan->save();
  }

  public  static  function number_unformat($number, $force_number = true, $dec_point = '.', $thousands_sep = ',')
  {
    if ($force_number) {
      $number = preg_replace('/^[^\d]+/', '', $number);
    } else if (preg_match('/^[^\d]+/', $number)) {
      return false;
    }
    $type = (strpos($number, $dec_point) === false) ? 'int' : 'float';
    $number = str_replace(array($dec_point, $thousands_sep), array('.', ''), $number);
    settype($number, $type);
    return $number;
  }

  public static function cekEmpty($val)
  {
    if ($val == '') {
      $val = 0;
    } else {
      $val = str_replace(',', '', $val);
    }
    return $val;
  }

  public static function getMarketingID($userID)
  {
    $result = 0;
    $tmp = Marketing::where('id_user', $userID)->first();

    if ($tmp) {
      $result = $tmp->id;
    }
    return  $result;
  }
}
