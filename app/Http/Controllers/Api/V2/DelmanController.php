<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DelmanController extends Controller
{
    function fjp($delman)
    {
        $result = DB::table('VW_DELMAN_ROUTES')->where('delman_id', $delman)->get();;
        return $result;
    }
}
