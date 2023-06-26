<div class="slider">
	<div class="slides">
		@foreach ($dataSoHeader as $soHeader)
		<div class="card card-custom bgi-no-repeat card-stretch gutter-b">
			<!--begin::Body-->
			<div class="card-body my-4">
				<p class="card-title font-weight-bolder text-info font-size-h6 mb-4 text-hover-state-dark d-block">
					{{ $soHeader['cabang'] }}
				</p>
				<table class="table">
					<tr>
						<td>{{ __('app.reports.so-monitorings.qty_draft') }}</td>
						<th>{{ $soHeader['qty_draft'] }}</th>
					</tr>
					<tr>
						<td>{{ __('app.reports.so-monitorings.qty_so') }}</td>
						<th>{{ $soHeader['qty_so'] }}</th>
					</tr>
					<tr>
						<td>{{ __('app.reports.so-monitorings.qty_total') }}</td>
						<th>{{ $soHeader['qty_order'] }}</th>
					</tr>
					<tr>
						<td>{{ __('app.reports.so-monitorings.amount_draft') }}</td>
						<th>{{ __('app.operators.rupiah') }}{{ number_format($soHeader['amount_draft']) }}</th>
					</tr>
					<tr>
						<td>{{ __('app.reports.so-monitorings.amount_so') }}</td>
						<th>{{ __('app.operators.rupiah') }}{{ number_format($soHeader['amount_so']) }}</th>
					</tr>
					<tr>
						<td>{{ __('app.reports.so-monitorings.total_so') }}</td>
						<th>{{ __('app.operators.rupiah') }}{{ number_format($soHeader['total_order']) }}</th>
					</tr>
					<tr>
						<td>{{ __('app.reports.so-monitorings.qty_do') }}</td>
						<th>{{ $soHeader['qty_shipper'] }}</th>
					</tr>
					<tr>
						<td>{{ __('app.reports.so-monitorings.totmerch') }}</td>
						<th>{{ __('app.operators.rupiah') }}{{ number_format($soHeader['totmerch']) }}</th>
					</tr>
				</table>
				<div class="font-weight-bold text-muted font-size-sm">
					<span
						class="text-dark-75 font-weight-bolder font-size-h2 mr-2">{{ round($soHeader['index'], 1) }}{{ __('app.operators.percentage') }}</span>
					{{ __('app.reports.so-monitorings.average') }}
				</div>
				<div class="progress progress-xs mt-7 bg-info-o-60">
					<div class="progress-bar bg-info" role="progressbar" style="width: {{ $soHeader['index'] }}%;"
						aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
			</div>
			<!--end::Body-->
		</div>
		@endforeach
	</div>
</div>

{{-- @foreach ($dataSoHeader->chunk(3) as $chunk)
<div class="row">
	@foreach ($chunk as $soHeader)
	<div class="col-xl-4">
		<!--begin::Stats Widget 22-->
		<div class="card card-custom bgi-no-repeat card-stretch gutter-b">
			<!--begin::Body-->
			<div class="card-body my-4">
				<p class="card-title font-weight-bolder text-info font-size-h6 mb-4 text-hover-state-dark d-block">
					{{ $soHeader['cabang'] }}
				</p>
				<table class="table">
					<tr>
						<td>{{ __('app.reports.so-monitorings.qty_draft') }}</td>
						<th>0</th>
					</tr>
					<tr>
						<td>{{ __('app.reports.so-monitorings.qty_so') }}</td>
						<th>{{ $soHeader['qty_order'] }}</th>
					</tr>
					<tr>
						<td>{{ __('app.reports.so-monitorings.qty_total') }}</td>
						<th>0</th>
					</tr>
					<tr>
						<td>{{ __('app.reports.so-monitorings.amount_draft') }}</td>
						<th>0</th>
					</tr>
					<tr>
						<td>{{ __('app.reports.so-monitorings.amount_so') }}</td>
						<th>0</th>
					</tr>
					<tr>
						<td>{{ __('app.reports.so-monitorings.total_so') }}</td>
						<th>{{ __('app.operators.rupiah') }}{{ number_format($soHeader['total_order']) }}</th>
					</tr>
					<tr>
						<td>{{ __('app.reports.so-monitorings.qty_do') }}</td>
						<th>{{ $soHeader['qty_shipper'] }}</th>
					</tr>
					<tr>
						<td>{{ __('app.reports.so-monitorings.totmerch') }}</td>
						<th>{{ __('app.operators.rupiah') }}{{ number_format($soHeader['totmerch']) }}</th>
					</tr>
				</table>
				<div class="font-weight-bold text-muted font-size-sm">
					<span
						class="text-dark-75 font-weight-bolder font-size-h2 mr-2">{{ round($soHeader['index'], 1) }}{{ __('app.operators.percentage') }}</span>
					{{ __('app.reports.so-monitorings.average') }}
				</div>
				<div class="progress progress-xs mt-7 bg-info-o-60">
					<div class="progress-bar bg-info" role="progressbar" style="width: {{ $soHeader['index'] }}%;"
						aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
			</div>
			<!--end::Body-->
		</div>
		<!--end::Stats Widget 22-->
	</div>
	@endforeach
</div>
@endforeach --}}
