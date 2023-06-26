@extends('layout.default')

@section('title', __('app.programs.images.pages.index'))

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.jqueryui.min.css">

<style>

</style>
@endsection

@section('content')

<x-alerts.alert condition="success" />

<div class="form-group">
	<x-buttons.add routeName="program.images" />
</div>

<div class="card card-custom mb-2" style="width: 1200px">
	<div class="card-header flex-wrap border-0 pt-6 pb-0">
		<div class="card-title">
			<h3>
				{{ __('app.programs.images.pages.index') }}
				<span class="d-block text-muted pt-2 font-size-sm">Sorting & pagination remote datasource</span>
			</h3>
		</div>
		@if (auth()->user()->role != App\Enums\UserRoleEnum::RO)
		<div class="card-toolbar">
			<a href="{{ route('index.exports') }}" class="btn btn-success">{{ __('app.button.export') }}</a>
		</div>
		@endif
	</div>
	<div class="card-body">

		<form action="{{ route('program.images.index') }}" method="GET" enctype="multipart/form-data">
			@csrf
			<div class="form-group">
				<label for="">
					Select Periode
				</label>
				<div class="mb-2" style="display: flex">
					<input type="month" name="periode" class="form-control mr-2 ml-2" style="width: 20%" value="{{ request()->periode }}" id="">
					<button type="submit" class="btn btn-primary">Cari</button>
				</div>
			</div>
		</form>

		<hr style="border: 1px solid black">

		<table class="table table-striped" id="example">
			<thead>
				<tr>
					<th>{{ __('app.tables.number') }}</th>
					<th>{{ __('app.programs.name') }}</th>
					<th>{{ __('app.programs.sku_group') }}</th>
					<th>{{ __('app.programs.inventory') }}</th>
					<th>{{ __('app.customers.customer_id') }}</th>
					<th>{{ __('app.programs.normal_price') }}</th>
					<th>{{ __('app.programs.promo_price') }}</th>
					<th>{{ __('app.programs.depth') }}</th>
					<th>{{ __('app.tables.status') }}</th>
					<th>{{ __('app.tables.action') }}</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($programImages as $programImage)
				<tr>
					<td>{{ $loop->iteration }}</td>
					<td>{{ $programImage->program_name }}</td>
					<td>{{ $programImage->sku_group_name }}</td>
					<td>{{ $programImage->inventory_id }}</td>
					<td>{{ $programImage->customer_id }}</td>
					<td>{{ number_format($programImage->normal_price) }}</td>
					<td>{{ number_format($programImage->promo_price) }}</td>
					<td>{{ $programImage->depth }}{{ __('app.operators.percentage') }}</td>
					<td>
						@if ($programImage->master_depth == $programImage->depth)
						<span class="label label-inline label-light-success font-weight-bold">Promo Valid</span>
						@else
						<span class="label label-inline label-light-danger font-weight-bold">Promo Invalid</span>
						@endif
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
									href="{{ route('program.images.show', $programImage->id) }}">{{ __('app.button.show') }}</a>
								<!-- Edit -->
								{{-- <a class="dropdown-item"
									href="{{ route('programs.edit', $programImage->id) }}">{{ __('app.button.edit') }}</a> --}}
								<!-- Delete -->
								<form action="{{ route('program.images.destroy', $programImage->id) }}"
									id="delete-{{ $programImage->id }}" method="POST">
									@csrf
									@method('DELETE')
								</form>
								<a class="dropdown-item" href="#"
									onclick="if(confirm('Are you sure ?')) document.getElementById('delete-{{ $programImage->id }}').submit()">Delete</a>
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
<script>
	$(document).ready(function () {
		$('#example').DataTable();
	});

</script>
@endsection
