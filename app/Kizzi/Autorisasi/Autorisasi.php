<?php

namespace Kizzi\Autorisasi;

use App\Models\AppAutorisasi;
use App\Models\AppMenu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Autorisasi
{

  public function generate($userid, $parent = 0)
  {
    $result = array('items' => $this->getMenu());
    return $result;
  }

  private function getMenu($header = 0)
  {
    $menu = AppMenu::select('app_menus.*', 'i.path')
      ->leftjoin('app_icons as i', 'app_menus.icon', '=', 'i.id')
      ->where('header', $header)
      ->orderby('order')
      ->get();

    $result = array();
    foreach ($menu as $value) {
      if ($value->root) {
        $cek = $this->cekDetail($value->id);
        if ($cek > 0) {
          $result[] = array(
            'title' => $value->title,
            'icon' => $value->path,
            'bullet' => $value->bullet == 1 ? 'dot' : '',
            'submenu' => $this->getMenu($value->id)
          );
        }
      } else {
        $cekautorisasi = $this->cekAutorisasi($value->id);
        if ($cekautorisasi > 0) {
          $result[] = array(
            'title' => $value->title,
            'page' => $value->page
          );
        }
      }
    }
    return $result;
  }

  /**
   * @param int $parent
   * @return \Illuminate\Http\JsonResponse
   */
  public function getUserAutorisasi($userid, $parent = 0)
  {
    $autorisasi = AppAutorisasi::where('parent_id', $parent)->orderby('id', 'asc')->get();

    $arrMenu = array();

    foreach ($autorisasi as $value) {
      if ($value->jenis == 'header') {
        $cek = $this->cekDetail($userid, $value->id);
        if ($cek > 0) {
          $arrMenu[] = array(
            'id' => $value->id, 'text' => $value->nmautorisasi, 'state' => $this->templateOpen(true, false),
            'icon' => $value->ikon, 'children' => $this->getUserAutorisasi($userid, $value->id)
          );
        } else {
          $arrMenu[] = array(
            'id' => $value->id, 'text' => $value->nmautorisasi, 'state' => $this->templateOpen(true, false),
            'icon' => $value->ikon, 'children' => $this->getUserAutorisasi($userid, $value->id)
          );
        }
      } else {
        $cekautorisasi = $this->cekAutorisasi($userid, $value->id);
        if ($cekautorisasi > 0) {
          $arrMenu[] = array('id' => $value->id, 'text' => $value->nmautorisasi, 'icon' => $value->ikon, 'state' => $this->templateOpen(true, true));
        } else {
          $arrMenu[] = array('id' => $value->id, 'text' => $value->nmautorisasi, 'icon' => $value->ikon, 'state' => $this->templateOpen(true, false));
        }
      }
    }
    return $arrMenu;
  }

  public function templateOpen($isOpen = true, $isSelected = false)
  {
    $tmp = array("opened" => $isOpen, 'selected' => $isSelected);
    return $tmp;
  }
  private function cekAktif($halaman, $id)
  {
    $hasil = AppAutorisasi::where('parent_id', $id)->get();
    $cek = 0;

    if (!is_null($hasil)) {
      foreach ($hasil as $key => $value) {
        if ($halaman == $value->aksi) {
          $cek++;
        }

        $cek2 = $this->cekAktif($halaman, $value->id);
        $cek += $cek2;
      }
    }

    return $cek;
  }

  private function cekDetail($parent)
  {
    $hasil = AppMenu::where('header', $parent)->get();
    $cek = 0;

    if (!is_null($hasil)) {
      foreach ($hasil as $key => $value) {
        $cekautorisasi = $this->cekAutorisasi($value->id);
        if ($cekautorisasi > 0) {
          $cek++;
        }

        $cek2 = $this->cekDetail($value->id);
        $cek += $cek2;
      }
    }

    return $cek;
  }

  public function cekAutorisasi($menuid)
  {
    $cek = AppAutorisasi::where('user_id', Auth::user()->id)
      ->where('menu_id', $menuid)
      ->count();

    return $cek;
  }
}
