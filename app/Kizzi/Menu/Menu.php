<?php namespace Biotrent\Menu;
use App\Models\UserAutorisasi;
use App\Models\UserAutorisasiList;
use Auth;
use Route;

class Menu {

	public function generate($userid, $parent = 0)
	{
		$halaman = "/" . Route::getCurrentRoute()->getPath();

		$autorisasi = UserAutorisasiList::where('parent_id', $parent)->orderby('id', 'asc')->get();
		$strHTML = "";

		foreach ($autorisasi as $key => $value) {

			if ($value->jenis == "header") {
				$cek = $this->cekDetail($userid, $value->id);

				if ($cek > 0)
				{
                    $aktif = $this->cekAktif($halaman, $value->id);
                    if($value->parent_id == 0)
                    {
                        if ($aktif > 0){
                            $strHTML .= "<li class='menu-dropdown classic-menu-dropdown active'>";
                        }else{
                            $strHTML .= "<li class='menu-dropdown classic-menu-dropdown '>";
                        }

                        $strHTML .=  "<a href='javascript:;'>";
                        $strHTML .=  "<i class='$value->ikon'></i> $value->nmautorisasi";
                        $strHTML .=	"<span class=\"arrow\"></span></a>";
                    }else{
                        if ($aktif > 0){
                            $strHTML .= "<li class='dropdown-submenu active'>";
                            $strHTML .=  "<a href='javascript:;' class='nav-link nav-toggle active'>";
                        }else{
                            $strHTML .= "<li class='dropdown-submenu'>";
                            $strHTML .=  "<a href='javascript:;' class='nav-link nav-toggle'>";
                        }
                        $strHTML .=  "<i class='$value->ikon'></i> $value->nmautorisasi";
                        $strHTML .=	"<span class=\"arrow\"></span></a>";
                    }

                    $strHTML .= "<ul class='dropdown-menu pull-left'>";
					$strHTML .= $this->generate($userid, $value->id);
					$strHTML .= "</ul>";
					$strHTML .=	"</li>";
				}
			}else{
				$cekautorisasi = $this->cekAutorisasi($userid, $value->id);
				if ($cekautorisasi > 0)
				{
					if ($halaman == $value->aksi) {
						$strHTML .= "<li class='active'>";
                        $strHTML .=	"<a href='$value->aksi' class='nav-link active'>";
                        $strHTML .=	"<i class='$value->ikon'></i> $value->nmautorisasi";
                    }else{
                        $strHTML .= "<li>";
                        $strHTML .=	"<a href='$value->aksi' class='nav-link'>";
                        $strHTML .=	"<i class='$value->ikon'></i> $value->nmautorisasi";
                    }
					$strHTML .=	"</a></li>";
				}
			}
		}									

		return $strHTML;
	}

    /**
     * @param int $parent
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserAutorisasi($userid, $parent = 0)
	{
		$autorisasi = UserAutorisasiList::where('parent_id', $parent)->orderby('id', 'asc')->get();

		$arrMenu = array();

		foreach ($autorisasi as $value) {
            if ($value->jenis == 'header')
            {
                $cek = $this->cekDetail($userid, $value->id);
                if ($cek > 0) {
                    $arrMenu[] = array('id' => $value->id, 'text' => $value->nmautorisasi, 'state' => $this->templateOpen(true,false),
                        'icon' => $value->ikon, 'children' => $this->getUserAutorisasi($userid, $value->id));
                }else{
                    $arrMenu[] = array('id' => $value->id, 'text' => $value->nmautorisasi, 'state' => $this->templateOpen(true, false),
                        'icon' => $value->ikon, 'children' => $this->getUserAutorisasi($userid, $value->id));
                }
            }else{
                $cekautorisasi = $this->cekAutorisasi($userid, $value->id);
                if ($cekautorisasi > 0) {
                    $arrMenu[] = array('id' => $value->id, 'text' => $value->nmautorisasi, 'icon' => $value->ikon, 'state' => $this->templateOpen(true, true));
                }else{
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
		$hasil = UserAutorisasiList::where('parent_id', $id)->get();
		$cek = 0;

		if (!is_null($hasil))
		{
			foreach ($hasil as $key => $value) {				
				if ($halaman == $value->aksi)
				{
					$cek++;
				}

				$cek2 = $this->cekAktif($halaman, $value->id);
				$cek += $cek2;
			}
		}
		
		return $cek;
	}

	private function cekDetail($userid, $parent)
	{
		$hasil = UserAutorisasiList::where('parent_id', $parent)->get();
		$cek = 0;

		if (!is_null($hasil))
		{
			foreach ($hasil as $key => $value) {
				$cekautorisasi = $this->cekAutorisasi($userid, $value->id);
				if ($cekautorisasi > 0)
				{
					$cek++;
				}

				$cek2 = $this->cekDetail($userid, $value->id);
				$cek += $cek2;
			}
		}
		
		return $cek;									
	}

	public function cekAutorisasi($userid, $id)
	{
		$cek = UserAutorisasi::where('user_id', $userid)
							->where('autorisasi_id', $id)
							->count();

		return $cek;							
	}
}