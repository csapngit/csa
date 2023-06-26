<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppAutorisasi;
use App\Models\AppMenu;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppAutorisasiController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$users = User::all();

		$group_menus = DB::table('app_menus')->whereNotNull('group_code')->get()->groupBy('group_code')->toArray();

		return view('admin.authorizations.index', compact('users', 'group_menus'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\AppAutorisasi  $appAutorisasi
	 * @return \Illuminate\Http\Response
	 */
	public function show(AppAutorisasi $appAutorisasi)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\AppAutorisasi  $appAutorisasi
	 * @return \Illuminate\Http\Response
	 */
	public function edit(AppAutorisasi $appAutorisasi)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\AppAutorisasi  $appAutorisasi
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, AppAutorisasi $appAutorisasi)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\AppAutorisasi  $appAutorisasi
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(AppAutorisasi $appAutorisasi)
	{
		//
	}
}
