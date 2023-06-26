@extends('layout.default')

@section('title', __('app.assets.pages.index'))

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">

<style>
	div.dataTables_wrapper {
		width: 100%;
		margin: 0 auto;
	}

</style>
@endsection

@section('content')
<x-alerts.alert condition="success" />
<x-alerts.alert condition="warning" />

<form action="{{ route('itcsa.assets.barcode') }}" id="exportBarcode" method="post" enctype="multipart/form-data"
	class="d-inline">
	@csrf
	<input type="hidden" name="selectedBarcodes" value="" id="barcode">
	<button type="submit" form="exportBarcode" class="btn btn-success mr-3" formtarget="_blank"
		style="float: right">Export</button>
</form>

<div class="mb-2">
	<x-buttons.add routeName="itcsa.assets" />

	@include('itcsa.assets.modal.service.create')
</div>

<div class="card card-custom mb-2">
	<div class="card-header flex-wrap border-0 pt-6 pb-0">
		<div class="card-title">
			<h3>
				{{ __('app.assets.pages.index') }} {{ __('app.area.jakarta') }}
				<span class="d-block text-muted pt-2 font-size-sm">Sorting & pagination remote datasource</span>
			</h3>
		</div>
	</div>
	<div class="card-body">
		<table class="display nonwrap example" style="width: 100%">
			<thead>
				<tr>
					<th style="width: 5%">
						<input type="checkbox" class="checked_all_csaj">
					</th>
					<th style="width: 10px">{{ __('app.tables.number') }}</th>
					<th style="width: 50px">{{ __('app.assets.branch_id') }}</th>
					<th style="width: 50px">{{ __('app.assets.barcode') }}</th>
					<th style="width: 50px">{{ __('app.assets.category_id') }}</th>
					<th style="width: 500px">{{ __('app.assets.brand') }}</th>
					<th style="width: 200px">{{ __('app.assets.serial_number') }}</th>
					<th style="width: 100px">{{ __('app.assets.name') }}</th>
					<th style="width: 300px">{{ __('app.assets.lend_date') }}</th>
					<th style="width: 200px">{{ __('app.assets.return_date') }}</th>
					<th>{{ __('app.tables.action') }}</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($jakartaAssets as $asset)
				<tr>
					<td>
						<input type="checkbox" name="barcodes" value="{{ $asset->id }}" class="check_customer_id_csaj">
					</td>
					<td>{{ $loop->iteration }}</td>
					<td>{{ $asset->BranchName }}</td>
					<td>{{ $asset->barcode }}</td>
					<td>{{ $asset->category_name }}</td>
					<td>{{ $asset->brand }}</td>
					<td>{{ $asset->serial_number }}</td>
					<td>{{ $asset->asset_name }}</td>
					<td>{{ date('d-m-Y', strtotime($asset->lend_date)) }}</td>
					<td>{{ $asset->return_date ? date('d-m-Y', strtotime($asset->return_date)) : '' }}</td>
					<td>
						<div class="dropdown">
							<button class="btn btn-link" type="button" id="dropdownMenuButton" data-toggle="dropdown"
								aria-haspopup="true" aria-expanded="false">
								<i class="flaticon2-gear text-primary"></i>
							</button>
							<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
								<a class="dropdown-item"
									href="{{ route('itcsa.assets.show', $asset->id) }}">{{ __('app.button.show') }}</a>
								<a class="dropdown-item"
									href="{{ route('itcsa.assets.edit', $asset->id) }}">{{ __('app.button.edit') }}</a>
								<form action="{{ route('itcsa.assets.destroy', $asset->id) }}" id="delete-{{ $asset->id }}"
									method="POST">
									@csrf
									@method('DELETE')
								</form>
								<a class="dropdown-item" href="#"
									onclick="if(confirm('Are you sure ?')) document.getElementById('delete-{{ $asset->id }}').submit()">Delete</a>
							</div>
						</div>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

<div class="card card-custom mb-2">
	<div class="card-header flex-wrap border-0 pt-6 pb-0">
		<div class="card-title">
			<h3>
				{{ __('app.assets.pages.index') }} {{ __('app.area.sumatra') }}
				<span class="d-block text-muted pt-2 font-size-sm">Sorting & pagination remote datasource</span>
			</h3>
		</div>
	</div>
	<div class="card-body">
		<table class="display nonwrap example" style="width: 100%">
			<thead>
				<tr>
					<th style="width: 5%">
						<input type="checkbox" class="checked_all_csas">
					</th>
					<th style="width: 10px">{{ __('app.tables.number') }}</th>
					<th style="width: 50px">{{ __('app.assets.branch_id') }}</th>
					<th style="width: 50px">{{ __('app.assets.barcode') }}</th>
					<th style="width: 50px">{{ __('app.assets.category_id') }}</th>
					<th style="width: 500px">{{ __('app.assets.brand') }}</th>
					<th style="width: 200px">{{ __('app.assets.serial_number') }}</th>
					<th style="width: 100px">{{ __('app.assets.name') }}</th>
					<th style="width: 300px">{{ __('app.assets.lend_date') }}</th>
					<th style="width: 200px">{{ __('app.assets.return_date') }}</th>
					<th>{{ __('app.tables.action') }}</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($sumatraAssets as $asset)
				<tr>
					<td>
						<input type="checkbox" name="barcodes" value="{{ $asset->id }}" class="check_customer_id_csas">
					</td>
					<td>{{ $loop->iteration }}</td>
					<td>{{ $asset->BranchName }}</td>
					<td>{{ $asset->barcode }}</td>
					<td>{{ $asset->category_name }}</td>
					<td>{{ $asset->brand }}</td>
					<td>{{ $asset->serial_number }}</td>
					<td>{{ $asset->asset_name }}</td>
					<td>{{ date('d-m-Y', strtotime($asset->lend_date)) }}</td>
					<td>{{ $asset->return_date ? date('d-m-Y', strtotime($asset->return_date)) : '' }}</td>
					<td>
						<div class="dropdown">
							<button class="btn btn-link" type="button" id="dropdownMenuButton" data-toggle="dropdown"
								aria-haspopup="true" aria-expanded="false">
								<i class="flaticon2-gear text-primary"></i>
							</button>
							<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
								<a class="dropdown-item"
									href="{{ route('itcsa.assets.show', $asset->id) }}">{{ __('app.button.show') }}</a>
								<a class="dropdown-item"
									href="{{ route('itcsa.assets.edit', $asset->id) }}">{{ __('app.button.edit') }}</a>
								<form action="{{ route('itcsa.assets.destroy', $asset->id) }}" id="delete-{{ $asset->id }}"
									method="POST">
									@csrf
									@method('DELETE')
								</form>
								<a class="dropdown-item" href="#"
									onclick="if(confirm('Are you sure ?')) document.getElementById('delete-{{ $asset->id }}').submit()">Delete</a>
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
@if($errors->any())
<script>
	$(function () {
		$('#exampleModal').modal('show');
	});

</script>
@endif

<!-- Checked all -->
<script>
	$('.checked_all_csaj').on('change', function (e) {
		e.preventDefault()
		$('.check_customer_id_csaj').prop('checked', this.checked)
	})

	$('.checked_all_csas').on('change', function (e) {
		e.preventDefault()
		$('.check_customer_id_csas').prop('checked', this.checked)
	})

</script>

<!-- Data table -->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script>
	$(document).ready(function () {
		$('.example').DataTable({
			scrollY: '45vh',
			scrollX: true,
			scrollCollapse: true,
			paging: false,
		});
	});

</script>

<!-- Select 2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
	// In your Javascript (external .js resource or <script> tag)
	$(document).ready(function () {
		$('.select2').select2({
			dropdownParent: $('#exampleModal'),
			placeholder: 'Select Asset'
		});
	});

	$(document).ready(function () {
		$('.select2_hide_search').select2({
			minimumResultsForSearch: Infinity
		});
	});

</script>

<script>
	$('#exportBarcode').submit(function (event) {
		let barcodeIds = $('input[type=checkbox][name=barcodes]:checked');
		let value = [];
		for (let i = 0; i < barcodeIds.length; i++) {
			value.push(barcodeIds[i].value);
		}
		console.log(value);
		$('#barcode').val(value);
	});

</script>

@endsection
