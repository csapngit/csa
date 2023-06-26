<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Area;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
	protected $user;

	/**
	 * UserController constructor.
	 * @param $user
	 */
	public function __construct(User $user)
	{
		$this->middleware('auth');
		$this->user = $user;
	}

	public function index()
	{
		$page_title = 'DDS - Customer';
		$page_description = 'Some description for the page';
		return view('admin.user.list', compact('page_title', 'page_description'))->with('sukses', 'Menu create successfull.');
	}

	public function create()
	{
		$page_title = 'Add New User';
		$page_description = 'Some description for the page';
		// $area = Area::get();
		// $role = UserRole::get();
		return view('admin.user.entry', compact('page_title', 'page_description'));
	}

	public function store(Request $request)
	{
		// return $request->all();
		$password = Hash::make($request->input('password'));
		$avatar = 'default.jpg';
		if ($request->hasFile('profile_avatar')) {
			if ($request->file('profile_avatar')->isValid()) {
				$validated = $request->validate([
					'profile_avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
				]);

				$path =  '/public/users/';
				$extension = $request->profile_avatar->extension();
				$imageName = 'user_' . $request->id . '_' . Carbon::now()->format('Ymdhms') . '.' . $extension;
				$upload =  $request->profile_avatar->storeAs($path, $imageName);
				if ($upload) {
					$avatar = $imageName;
				}
			}
		}
		if ($request->input('method') == 'save') {
			$simpan = new $this->user();
			$simpan->username = $request->input('username');
			$simpan->password = $password;
			$simpan->email = $request->input('email');
		} else {
			$simpan = $this->user->find($request->input('id'));
		}
		$simpan->name = $request->input('name');
		$simpan->avatar = $avatar;
		$simpan->area = $request->input('area');
		$simpan->branch = $request->input('branch');
		$simpan->role = $request->input('userrole');
		$simpan->status = $request->input('status');
		$simpan->inputby = Auth::user()->id;
		$simpan->save();
		if ($simpan) {
			//            if ($request->input('method') == 'save') {
			////                Fungsi::simpanLog(Auth::user()->id, '/approval-barang/store', 'save',$simpan->id, 'Simpan data approval barang');
			//            }else{
			////                Fungsi::simpanLog(Auth::user()->id, '/approval-barang/store', 'edit', $request->input('id'), 'Simpan edit data approval barang');
			//            }
			return redirect()->route('user')->with('status', 'success')->with('pesan', 'Data user berhasil disimpan.');
		} else {
			return redirect()->route('user')->with('status', 'faield')->with('pesan', 'Data gagal disimpan');
		}
	}

	public function edit($id)
	{
		$edit = $this->user->find($id);
		$page_title = 'Edit USer';
		$page_description = 'Edit Data User';
		return view('admin.user.entry', compact('edit', 'page_title', 'page_description'));
	}
}
