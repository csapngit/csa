<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AppIcon;
use App\Models\MasterArea;
use App\Models\MasterBranch;
use App\Models\MasterCustomer;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
  public function icons(Request $keyword)
  {
    $result = AppIcon::select('id', 'name as text')->where('name', 'like', '%' . $keyword->input('search') . '%')->get();
    return json_encode($result);
  }

  public function areas(Request $keyword)
  {
    $result = MasterArea::select('id', 'area_name as text')->where('area_name', 'like', '%' . $keyword->input('search') . '%')->get();
    return json_encode($result);
  }

  public function getListUserRole(Request $keyword)
  {
    $result = UserRole::select('id', 'role_name as text')->where('role_name', 'like', '%' . $keyword->input('search') . '%')->get();
    return json_encode($result);
  }

  public function getListBranch(Request $keyword)
  {
    $result = MasterBranch::select('id', DB::raw("CONCAT(Branch, ' - ', BranchName) as text"))->where('BranchName', 'like', '%' . $keyword->input('search') . '%')->get();
    return json_encode($result);
  }

  public function getListUser(Request $keyword)
  {
    $result = User::select('users.*', 'a.area_name', 'user_roles.role_name')
      ->leftjoin('master_areas as a', 'users.area', '=', 'a.id')
      ->leftjoin('user_roles', 'users.role', '=', 'user_roles.id')
      ->get();
    return json_encode($result);
  }

  public function searchCustomer($custid)
  {
    $result = MasterCustomer::where('CustId', $custid)->first();
    return $result;
  }
}
