@extends('layout.default')

@section('title', __('app.categories.pages.index'))

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
@endsection

@section('content')

<x-alerts.alert condition="success" />
<x-alerts.alert condition="warning" />

<div class="card card-custom">
	<div class="card-header flex-wrap border-0 pt-6 pb-0">
		<div class="card-title">
			<h3>
				{{ __('app.categories.pages.index') }}
				<span class="d-block text-muted pt-2 font-size-sm">Sorting & pagination remote datasource</span>
			</h3>
		</div>
	</div>
	<div class="card-body">
		<div class="mb-2">
			<!-- Add Button -->
			<x-buttons.add routeName="itcsa.asset.categories" />
		</div>

		<table class="table table-striped" id="example">
			<thead>
				<tr>
					<th style="width: 5%">{{ __('app.tables.number') }}</th>
					<th>{{ __('app.categories.name') }}</th>
					<th>{{ __('app.tables.action') }}</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($categories as $category)
				<tr>
					<td>{{ $loop->iteration }}</td>
					<td>{{ $category->name }}</td>
					<td>
						<x-buttons.edit routeName="itcsa.asset.categories" :id="$category->id" />

						<x-buttons.delete routeName="itcsa.asset.categories" :id="$category->id" />
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
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script>
	$(document).ready(function () {
    $('#example').DataTable();
	});

</script>

@endsection
