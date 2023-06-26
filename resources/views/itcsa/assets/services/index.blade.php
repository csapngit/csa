@extends('layout.default')

@section('title', __('app.services.pages.index'))

@section('styles')
<link rel="stylesheet" href="http://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endsection

@section('content')

<x-alerts.alert condition="success" />
<x-alerts.alert condition="warning" />

<div class="card card-custom">
	<div class="card-header flex-wrap border-0 pt-6 pb-0">
		<div class="card-title">
			<h3>
				{{ __('app.services.pages.index') }}
				<span class="d-block text-muted pt-2 font-size-sm">Sorting & pagination remote datasource</span>
			</h3>
		</div>
	</div>
	<div class="card-body">
		<table class="table table-striped" id="example">
			<thead>
				<tr>
					<th>{{ __('app.tables.number') }}</th>
					<th>{{ __('app.services.asset_id') }}</th>
					<th>{{ __('app.services.service_date') }}</th>
					<th>{{ __('app.services.description') }}</th>
					<th>{{ __('app.services.status') }}</th>
					<th>{{ __('app.services.return_date') }}</th>
					<th>{{ __('app.tables.action') }}</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($assetServices as $service)
				<tr>
					<td>{{ $loop->iteration }}</td>
					<td>{{ $service->asset->barcode }} - {{ $service->asset->brand }}</td>
					<td>{{ $service->service_date->format('d-m-Y') }}</td>
					<td>{{ $service->description }}</td>
					<td>
						@if ($service->return_date)
						<span class="label label-inline label-light-success font-weight-bold">Complete</span>
						@else
						<span class="label label-inline label-light-danger font-weight-bold">On service</span>
						@endif
					</td>
					<td>{{ optional($service->return_date)->format('d-m-Y') }}</td>
					<td>
						@include('itcsa.assets.modal.service.edit')

						<x-buttons.delete routeName="itcsa.asset-services" :id="$service->id" />
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection

@section('scripts')
<script src="http://code.jquery.com/jquery-3.5.1.js"></script>
<script src="http://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script>
	$(document).ready(function () {
		$('#example').DataTable({
			scrollY: '50vh',
			scrollCollapse: true,
			paging: false,
		});
	});

</script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
	$(document).ready(function () {
		$('.js-example-basic-single').select2();
	});

</script>

@endsection
