@extends('layout.default')

@section('title', __('app.users.pages.create'))

@section('styles')
<link rel="stylesheet" href="{{ asset('css/slider-user.css') }}">
@endsection

@section('content')
<div class="card card-custom">
	<div class="card-header flex-wrap border-0 pt-6 pb-0">
		<div class="card-title">
			<h3>
				{{ __('app.users.pages.create') }}
				<span class="d-block text-muted pt-2 font-size-sm">Sorting & pagination remote datasource</span>
			</h3>
		</div>
	</div>
	<div class="card-body">
		<x-forms.form :action="route('users.update', $user->id)" back-route-name="users.index">

			<!-- Full Name -->
			<div class="form-group row">
				<label class="col-2 col-form-label">
					{{ __('app.users.name') }}
					<span class="text-danger"> * </span>
				</label>
				<div class="col-10">
					<input class="form-control @error('name') is-invalid @enderror" name="name" type="text"
						value="{{ $user->name }}" />
					@error('name')
					<div class="invalid-feedback">
						{{ $message }}
					</div>
					@enderror
				</div>
			</div>

			<!-- Username -->
			<div class="form-group row">
				<label class="col-2 col-form-label">
					{{ __('app.users.username') }}
					<span class="text-danger"> * </span>
				</label>
				<div class="col-10">
					<input class="form-control @error('username') is-invalid @enderror" name="username" type="text"
						value="{{ $user->username }}" />
					@error('username')
					<div class="invalid-feedback">
						{{ $message }}
					</div>
					@enderror
				</div>
			</div>

			<!-- Email -->
			<div class="form-group row">
				<label class="col-2 col-form-label">
					{{ __('app.users.email') }}
					<span class="text-danger"> * </span>
				</label>
				<div class="col-10">
					<input class="form-control @error('email') is-invalid @enderror" name="email" type="email"
						value="{{ $user->email }}" />
					@error('email')
					<div class="invalid-feedback">
						{{ $message }}
					</div>
					@enderror
				</div>
			</div>

			<!-- Password -->
			<div class="form-group row">
				<label class="col-2 col-form-label">
					{{ __('app.users.password') }}
					<span class="text-danger"> * </span>
				</label>
				<div class="col-10">
					<div class="input-group">
						<input class="form-control @error('password') is-invalid @enderror" name="password" type="password"
							value="{{ $user->password }}" id="password" />
						<div class="input-group-append">
							<button class="btn btn-info" type="button" onmousedown="mDown()" onmouseup="mUp()">Show</button>
						</div>
						@error('password')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
						@enderror
					</div>
				</div>
			</div>

			<!-- Area -->
			<div class="form-group row">
				<label class="col-2 col-form-label">
					{{ __('app.users.area') }}
					<span class="text-danger"> * </span>
				</label>
				<div class="col-10">
					<select name="area" class="form-control dynamic select2_hide_search @error('area') is-invalid @enderror">
						<option selected disabled value="">Choose Area</option>
						@foreach ($areas as $area)
						<option value="{{ $area->id }}" {{ $user->area == $area->id ? ' selected' : '' }}>{{ $area->area_name }}
						</option>
						@endforeach
					</select>
					@error('area')
					<div class="invalid-feedback">
						{{ $message }}
					</div>
					@enderror
				</div>
			</div>

			<!-- Branch -->
			<div class="form-group row">
				<label class="col-2 col-form-label">
					{{ __('app.users.branch') }}
					<span class="text-danger"> * </span>
				</label>
				<div class="col-10">
					<select name="branch" class="form-control dynamic select2 @error('branch') is-invalid @enderror">
						<option selected disabled value="">Choose Branch</option>
						@foreach ($branches as $branch)
						<option value="{{ $branch->id }}" {{ $user->branch == $branch->id ? ' selected' : '' }}>
							{{ $branch->Branch }} - {{ $branch->BranchName }}
						</option>
						@endforeach
					</select>
					@error('branch')
					<div class="invalid-feedback">
						{{ $message }}
					</div>
					@enderror
				</div>
			</div>

			<!-- User Role -->
			<div class="form-group row">
				<label class="col-2 col-form-label">
					{{ __('app.users.role') }}
					<span class="text-danger"> * </span>
				</label>
				<div class="col-10">
					<select name="role" class="form-control dynamic select2 @error('role') is-invalid @enderror">
						<option selected disabled value="">Choose role</option>
						@foreach ($roles as $role)
						<option value="{{ $role->id }}" {{ $user->role == $role->id ? ' selected' : '' }}>
							{{ $role->role_name }}
						</option>
						@endforeach
					</select>
					@error('role')
					<div class="invalid-feedback">
						{{ $message }}
					</div>
					@enderror
				</div>
			</div>

			<!-- Status Active -->
			<input type="hidden" name="status" value="1">

			<!-- Input By -->
			<input type="hidden" name="inputby" value="1">

			<hr>

			<!-- Permissions -->
			<div class="form-group row">
				<label class="col-2 col-form-label">
					{{ __('app.users.permissions') }}
				</label>
				<div class="col-10">
					<div class="slider">
						<div class="slides">
							@foreach ($group_menus as $key => $menus)
							<div>
								<table class="table">
									<thead class="text-center">
										<tr>
											<th>{{ $key }}</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($menus as $menu)
										<tr>
											<td>
												<label class="checkbox">
													<input type="checkbox" name="menu_ids[]" value="{{ $menu->id }}"
														{{ in_array($menu->id, $user_has_autorisasis) ? ' checked' : '' }} />
													<span class="mr-3"></span>
													{{ $menu->title }}
												</label>
											</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
							@endforeach
						</div>
					</div>
				</div>
			</div>
		</x-forms.form>
	</div>
</div>
@endsection

@section('scripts')
<script>
	const password = document.getElementById('password');

	function mDown() {
		password.setAttribute('type', 'text');
	}

	function mUp() {
		password.setAttribute('type', 'password');
	}

</script>
@endsection
