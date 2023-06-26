@extends('layout.default')

@section('title', 'So Monitoring')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<style>
	tr.group,
	tr.group:hover {
		background-color: #ddd !important;
		text-align: center;
	}

</style>

<style>
	.slider {
		width: 100%;
		overflow: hidden;
	}

	.slides {
		display: flex;
		overflow-x: auto;
		scroll-snap-type: x mandatory;
		scroll-behavior: smooth;
		-webkit-overflow-scrolling: touch;
	}

	.slides::-webkit-scrollbar {
		width: 3px;
		height: 10px;
	}

	.slides::-webkit-scrollbar-thumb {
		background: rgb(171, 171, 171);
		border-radius: 5px;
	}

	.slides::-webkit-scrollbar-track {
		background: transparent;
	}

	.slides>div {
		scroll-snap-align: start;
		flex-shrink: 0;
		width: auto;
		height: 100px;
		margin: 0 10px 0 10px;
		border-radius: 7px;
		background: #fff;
		transform-origin: center center;
		transform: scale(1);
		transition: transform 0.5s;
		position: relative;
		border: 1px solid #555;
		display: flex;
		justify-content: center;
		align-items: center;
		overflow: hidden;
		font-size: 100%;
		margin-bottom: 10px;
	}

	@media only screen and (max-width: 768px) {
  .slider {
		width: 200%;
		overflow: hidden;
	}

	.card {
    /* flex-direction: row; */
    width: 200%;
  }
/*
  .card img {
    width: 50%;
    height: 100%;
    object-fit: cover;
  }

  .card-content {
    width: 50%;
    padding: 40px;
    text-align: left;
  } */
}

</style>
@endsection

@section('content')

@if (auth()->user()->role == App\Enums\UserRoleEnum::GM)
@include('reports.so-monitoring.gm')
@endif

@if (auth()->user()->role != App\Enums\UserRoleEnum::SR)
<!-- So Header -->
@include('reports.so-monitoring.layouts.header')

<!-- So Header Total -->
@include('reports.so-monitoring.layouts.total')
@endif
<div class="card card-custom mb-2">
	<div class="card-header flex-wrap border-0 pt-6 pb-0">
		<div class="card-title">
			<h3>
				{{ __('app.reports.so-monitorings.detail') }}
				<span class="d-block text-muted pt-2 font-size-sm">{{ __('app.reports.so-monitorings.last_sync') }} :
					{{ $syncReportSo }}</span>
			</h3>
		</div>
		<div class="card-toolbar">
			<form action="{{ route('report.salesOrder.export') }}" method="POST" class="d-inline">
				@csrf
				<button type="submit" class="btn btn-primary">{{ __('app.button.export') }}</button>
			</form>
		</div>
	</div>
	<div class="card-body">
		<table class="table table-striped" id="example">
			<thead>
				<tr>
					<th>{{ __('app.reports.so-monitorings.customer_id') }}</th>
					<th>{{ __('app.reports.so-monitorings.cabang') }}</th>
					<th>{{ __('app.reports.so-monitorings.billname') }}</th>
					<th>{{ __('app.reports.so-monitorings.order_number') }}</th>
					<th>{{ __('app.reports.so-monitorings.qty_so') }}</th>
					<th>{{ __('app.reports.so-monitorings.total_so') }}</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($dataSoDetail as $soDetail)
				<tr>
					<td>
						<a href="#" data-toggle="modal" data-target="#modal{{ $soDetail['id'] }}">
							{{ $soDetail['customer_id'] }}
						</a>
					</td>
					<td>{{ $soDetail['cabang'] }}</td>
					<td>{{ $soDetail['name'] }}</td>
					<td>{{ $soDetail['order_number'] }}</td>
					<td>{{ $soDetail['qty_order'] }}</td>
					<td>{{ __('app.operators.rupiah') }}{{ number_format($soDetail['total_order']) }}</td>
				</tr>

				<!-- Modal-->
				@include('reports.so-monitoring.modals.show')
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<th>{{ __('app.reports.so-monitorings.customer_id') }}</th>
					<th>{{ __('app.reports.so-monitorings.cabang') }}</th>
					<th>{{ __('app.reports.so-monitorings.billname') }}</th>
					<th>{{ __('app.reports.so-monitorings.order_number') }}</th>
					<th>{{ __('app.reports.so-monitorings.qty_so') }}</th>
					<th>{{ __('app.reports.so-monitorings.total_so') }}</th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
@endsection

@section('scripts')
{{-- <script src="https://code.jquery.com/jquery-3.6.0.js"></script> --}}
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
	$(document).ready(function () {
		var groupColumn = 1;
		var table = $('#example').DataTable({
			columnDefs: [{
				visible: false,
				targets: groupColumn
			}],
			order: [
				[groupColumn, 'asc']
			],
			displayLength: 15,
			drawCallback: function (settings) {
				var api = this.api();
				var rows = api.rows({
					page: 'current'
				}).nodes();
				var last = null;

				api
					.column(groupColumn, {
						page: 'current'
					})
					.data()
					.each(function (group, i) {
						if (last !== group) {
							$(rows)
								.eq(i)
								.before('<tr class="group"><td colspan="6">' + group +
									'</td></tr>');

							last = group;
						}
					});
			},
		});

		// Order by the grouping
		$('#example tbody').on('click', 'tr.group', function () {
			var currentOrder = table.order()[0];
			if (currentOrder[0] === groupColumn && currentOrder[1] === 'asc') {
				table.order([groupColumn, 'desc']).draw();
			} else {
				table.order([groupColumn, 'asc']).draw();
			}
		});
	});

</script>

<script>
	$(function () {
		$(document).tooltip();
	});

</script>

<script src="{{ asset('js/pages/widgets.js') }}"></script>
@endsection
