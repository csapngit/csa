@extends('layout.default')

@section('title', __('app.programs.pages.index'))

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.jqueryui.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endsection

{{-- Content --}}
@section('content')
<x-alerts.alert condition="success" />
<x-alerts.alert condition="warning" />

<div class="card card-custom">
	<div class="card-header flex-wrap border-0 pt-6 pb-0">
		<div class="card-title">
			<h3>
				{{ __('app.programs.pages.index') }}
				<span class="d-block text-muted pt-2 font-size-sm">Sorting & pagination remote datasource</span>
			</h3>
		</div>
	</div>
	<div class="card-body">
		<!-- Add Button -->
		<div class="form-group">
			<x-buttons.add routeName="programs" />
		</div>

		<table class="display" id="example">
			<thead>
				<tr>
					<th>{{ __('app.tables.number') }}</th>
					<th>{{ __('app.programs.area') }}</th>
					<th>{{ __('app.programs.name') }}</th>
					<th>{{ __('app.programs.sku_group') }}</th>
					<th>{{ __('app.programs.valid_from') }}</th>
					<th>{{ __('app.programs.valid_until') }}</th>
					<th>{{ __('app.programs.customer_list') }}</th>
					<th>{{ __('app.tables.action') }}</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($programs as $program)
				<tr>
					<td>{{ $loop->iteration }}</td>
					<td>{{ $program->area }}</td>
					<td>{{ $program->name }}</td>
					<td>{{ $program->program_detail->sku_group->name ?? '-' }}</td>
					<td>{{ $program->valid_from->format('d-m-Y') }}</td>
					<td>{{ $program->valid_until->format('d-m-Y') }}</td>
					<td>
						<a href="{{ route('programs.customers', $program->id) }}" title="List Customers" style="margin-left: 20px">
							<span class="svg-icon svg-icon-success svg-icon-md">
								<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
									height="24px" viewBox="0 0 24 24" version="1.1">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<rect x="0" y="0" width="24" height="24" />
										<path
											d="M12,3 C16.418278,3 20,6.581722 20,11 L20,21 C20,21.5522847 19.5522847,22 19,22 L5,22 C4.44771525,22 4,21.5522847 4,21 L4,11 C4,6.581722 7.581722,3 12,3 Z M9,10 C7.34314575,10 6,11.3431458 6,13 C6,14.6568542 7.34314575,16 9,16 L15,16 C16.6568542,16 18,14.6568542 18,13 C18,11.3431458 16.6568542,10 15,10 L9,10 Z"
											fill="#000000" />
										<path
											d="M15,14 C14.4477153,14 14,13.5522847 14,13 C14,12.4477153 14.4477153,12 15,12 C15.5522847,12 16,12.4477153 16,13 C16,13.5522847 15.5522847,14 15,14 Z M9,14 C8.44771525,14 8,13.5522847 8,13 C8,12.4477153 8.44771525,12 9,12 C9.55228475,12 10,12.4477153 10,13 C10,13.5522847 9.55228475,14 9,14 Z"
											fill="#000000" opacity="0.3" />
									</g>
								</svg>
							</span></a>
					</td>
					<td>
						<div class="dropdown">
							<button class="btn btn-link" type="button" id="dropdownMenuButton" data-toggle="dropdown"
								aria-haspopup="true" aria-expanded="false">
								<i class="flaticon2-gear text-primary"></i>
							</button>
							<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
								<!-- Show -->
								<a class="dropdown-item"
									href="{{ route('programs.show', $program->id) }}">{{ __('app.button.show') }}</a>
								<!-- Edit -->
								<a class="dropdown-item"
									href="{{ route('programs.edit', $program->id) }}">{{ __('app.button.edit') }}</a>
								<!-- Delete -->
								<form action="{{ route('programs.destroy', $program->id) }}" id="delete-{{ $program->id }}"
									method="POST">
									@csrf
									@method('DELETE')
								</form>
								<a class="dropdown-item" href="#"
									onclick="if(confirm('All data will be Lost ? Are you Sure ?')) document.getElementById('delete-{{ $program->id }}').submit()">Delete</a>
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
{{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
	$(document).ready(function () {
		$('#example').DataTable();
	});

</script>

<script>
	$(function () {
		$(document).tooltip();
	});

</script>
@endsection
