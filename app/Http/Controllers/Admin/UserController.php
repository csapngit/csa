<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\MasterArea;
use App\Models\MasterBranch;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
	public function index()
	{
		$users = DB::table('users')
			->join('master_areas', 'users.area', 'master_areas.id')
			->join('user_roles', 'users.role', 'user_roles.id')
			->select(
				'users.id',
				'users.name',
				'users.username',
				'users.email',
				'users.password',
				'users.status',
				'master_areas.area_name',
				'user_roles.inisial',
				'user_roles.role_name',
				'user_roles.level',
			)
			->orderByDesc('users.id')
			->get();

		return view('admin.users.index', compact('users'));
	}

	public function create()
	{
		$areas = MasterArea::all();

		$branches = MasterBranch::all();

		$roles = UserRole::all();

		$group_menus = DB::table('app_menus')->whereNotNull('group_code')->get()->groupBy('group_code')->toArray();

		return view('admin.users.create', compact('areas', 'branches', 'roles', 'group_menus'));
	}

	public function store(StoreUserRequest $request)
	{
		// dd($request->all());

		$user = User::create([
			'name' => $request->name,
			'username' => $request->username,
			'email' => $request->email,
			'password' => bcrypt($request->password),
			'area' => $request->area,
			'branch' => $request->branch,
			'role' => $request->role,
			'status' => $request->status,
			'inputby' => $request->inputby,
		]);

		$user->app_menus()->attach($request->menu_ids);

		return redirect()->route('users.index')->with('success', __('message.data_saved'));
	}

	public function edit(User $user)
	{
		$areas = MasterArea::all();

		$branches = MasterBranch::all();

		$roles = UserRole::all();

		$group_menus = DB::table('app_menus')->whereNotNull('group_code')->get()->groupBy('group_code')->toArray();

		$user_has_autorisasis = $user->app_menus->pluck('id')->toArray();

		// dd($user_has_autorisasis);

		return view('admin.users.edit', compact(
			'user',
			'areas',
			'branches',
			'roles',
			'group_menus',
			'user_has_autorisasis',
		));
	}

	public function update(UpdateUserRequest $request, User $user)
	{
		$user->update([
			'name' => $request->name,
			'username' => $request->username,
			'email' => $request->email,
			// 'password' => bcrypt($request->password),
			'area' => $request->area,
			'branch' => $request->branch,
			'role' => $request->role,
			'status' => $request->status,
			'inputby' => $request->inputby,
		]);

		$user->app_menus()->sync($request->menu_ids);

		return redirect()->route('users.index')->with('success', __('message.data_updated'));
	}

	public function destroy(User $user)
	{
		$user->app_menus()->detach();

		$user->delete();

		return back()->with('success', __('message.data_deleted'));
	}
}
