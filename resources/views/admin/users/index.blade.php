@extends('layout.default')

@section('title', __('app.users.pages.index'))

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.jqueryui.min.css">
@endsection

@section('content')
<x-alerts.alert condition="success" />
<x-alerts.alert condition="warning" />

<div class="card card-custom">
	<div class="card-header flex-wrap border-0 pt-6 pb-0">
		<div class="card-title">
			<h3>
				{{ __('app.users.pages.index') }}
				<span class="d-block text-muted pt-2 font-size-sm">Sorting & pagination remote datasource</span>
			</h3>
		</div>
	</div>
	<div class="card-body">
		<!-- Add Button -->
		<div class="form-group">
			<x-buttons.add routeName="users" />
		</div>

		<table class="display" id="example">
			<thead>
				<tr>
					<th>{{ __('app.tables.number') }}</th>
					<th>{{ __('app.users.name') }}</th>
					<th>{{ __('app.users.username') }}</th>
					<th>{{ __('app.users.email') }}</th>
					<th>{{ __('app.users.area') }}</th>
					<th>{{ __('app.users.status') }}</th>
					<th>{{ __('app.tables.action') }}</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($users as $user)
				<tr>
					<td>{{ $loop->iteration }}</td>
					<td class="py-6 pl-0">
						<a href="#" class="text-dark font-weight-bolder text-hover-primary mb-1 font-size-lg">{{ $user->name }}</a>
						<span class="text-muted font-weight-bold d-block">{{ $user->inisial }}</span>
					</td>
					<td>{{ $user->username }}</td>
					<td>{{ $user->email }}</td>
					<td>{{ $user->area_name }}</td>
					<td>
						@if ($user->status)
						<span class="label label-inline label-light-success font-weight-bold">Active</span>
						@else
						<span class="label label-inline label-light-danger font-weight-bold">Inactive</span>
						@endif
					</td>
					<td>
						<div class="dropdown">
							<button class="btn btn-link" type="button" id="dropdownMenuButton" data-toggle="dropdown"
								aria-haspopup="true" aria-expanded="false">
								<i class="flaticon2-gear text-primary"></i>
							</button>
							<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
								<a class="dropdown-item" href="#">{{ __('app.button.show') }}</a>
								<a class="dropdown-item" href="{{ route('users.edit', $user->id) }}">{{ __('app.button.edit') }}</a>
								<form action="{{ route('users.destroy', $user->id) }}" id="delete-{{ $user->id }}" method="POST">
									@csrf
									@method('DELETE')
								</form>
								<a class="dropdown-item" href="#"
									onclick="if(confirm('Are you sure ?')) document.getElementById('delete-{{ $user->id }}').submit()">Delete</a>
							</div>
						</div>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script>
	$(document).ready(function () {
		$('#example').DataTable();
	});

</script>
@endsection
