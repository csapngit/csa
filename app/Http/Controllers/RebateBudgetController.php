<?php

namespace App\Http\Controllers;

use App\Models\RebateIcg;
use Illuminate\Http\Request;

class RebateBudgetController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index()
  {
    $page_title = 'Potongan Manual';
    $page_description = 'Some description for the page';
    return view('rebate.manual.list', compact('page_title', 'page_description'));
  }

  public function create()
  {
    $page_title = 'Entry Mapping Budget';
    $page_description = 'Form mapping potongan manual dengan budget';
    $icg = RebateIcg::get();
    return view('rebate.budget.entry', compact('page_title', 'page_description', 'icg'));
  }

  public function store(Request $request)
  {
    return $request->all();
  }
}
