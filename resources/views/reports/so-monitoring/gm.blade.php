@extends('layout.default')

@section('title', 'So Monitoring')

@section('content')

<div class="row">
	<div class="col-xl-4">
		<!--begin::Stats Widget 22-->
		<div class="card card-custom bgi-no-repeat card-stretch gutter-b">
			<!--begin::Body-->
			<div class="card-body my-4">
				<p class="card-title font-weight-bolder text-info font-size-h6 mb-4 text-hover-state-dark d-block">
					All Region
				</p>
				<table class="table">
					<tr>
						<td>{{ __('app.reports.so-monitorings.qty_draft') }}</td>
						<th>{{ $overallDataRegion['qty_draft'] }}</th>
					</tr>
					<tr>
					<tr>
						<td>{{ __('app.reports.so-monitorings.qty_so') }}</td>
						<th>{{ $overallDataRegion['qty_so'] }}</th>
					</tr>
					<tr>
						<td>{{ __('app.reports.so-monitorings.qty_total') }}</td>
						<th>{{ $overallDataRegion['total_qty'] }}</th>
					</tr>
					<tr>
						<td>{{ __('app.reports.so-monitorings.amount_draft') }}</td>
						<th>{{ __('app.operators.rupiah') }}{{ number_format($overallDataRegion['amount_draft']) }}</th>
					</tr>
					<tr>
						<td>{{ __('app.reports.so-monitorings.amount_so') }}</td>
						<th>{{ __('app.operators.rupiah') }}{{ number_format($overallDataRegion['amount_so']) }}</th>
					</tr>
					<tr>
					<tr>
						<td>{{ __('app.reports.so-monitorings.total_so') }}</td>
						<th>{{ __('app.operators.rupiah') }}{{ number_format($overallDataRegion['total_amount']) }}</th>
					</tr>
					<tr>
						<td>{{ __('app.reports.so-monitorings.qty_do') }}</td>
						<th>{{ $qtyShipper }}</th>
					</tr>
					<tr>
						<td>{{ __('app.reports.so-monitorings.totmerch') }}</td>
						<th>{{ __('app.operators.rupiah') }}{{ number_format($totalMerch) }}</th>
					</tr>
				</table>
				<div class="font-weight-bold text-muted font-size-sm">
					<span
						class="text-dark-75 font-weight-bolder font-size-h2 mr-2">{{ round($totalIndex, 1) }}{{ __('app.operators.percentage') }}</span>
					{{ __('app.reports.so-monitorings.average') }}
				</div>
				<div class="progress progress-xs mt-7 bg-info-o-60">
					<div class="progress-bar bg-info" role="progressbar" style="width: {{ $totalIndex }}%;" aria-valuenow="50"
						aria-valuemin="0" aria-valuemax="100"></div>
				</div>
			</div>
			<!--end::Body-->
		</div>
		<!--end::Stats Widget 22-->
	</div>
</div>

@foreach ($dataByRegions as $area => $generalManagers)
{{-- @dd($dataByRegions) --}}
@php
$headerTotal = array_pop($generalManagers);
// @dd($headerTotal)
@endphp
<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-md">
				<div class="d-flex align-items-center mr-2">
					<!--begin::Symbol-->
					<div class="symbol symbol-45 symbol-light-info mr-4 flex-shrink-0">
						<div class="symbol-label">
							<span class="svg-icon svg-icon-lg svg-icon-info">
								<!--begin::Svg Icon | path:assets/media/svg/icons/Shopping/Cart3.svg-->
								<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
									height="24px" viewBox="0 0 24 24" version="1.1">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<rect x="0" y="0" width="24" height="24" />
										<path
											d="M12,4.56204994 L7.76822128,9.6401844 C7.4146572,10.0644613 6.7840925,10.1217854 6.3598156,9.76822128 C5.9355387,9.4146572 5.87821464,8.7840925 6.23177872,8.3598156 L11.2317787,2.3598156 C11.6315738,1.88006147 12.3684262,1.88006147 12.7682213,2.3598156 L17.7682213,8.3598156 C18.1217854,8.7840925 18.0644613,9.4146572 17.6401844,9.76822128 C17.2159075,10.1217854 16.5853428,10.0644613 16.2317787,9.6401844 L12,4.56204994 Z"
											fill="#000000" fill-rule="nonzero" opacity="0.3" />
										<path
											d="M3.5,9 L20.5,9 C21.0522847,9 21.5,9.44771525 21.5,10 C21.5,10.132026 21.4738562,10.2627452 21.4230769,10.3846154 L17.7692308,19.1538462 C17.3034221,20.271787 16.2111026,21 15,21 L9,21 C7.78889745,21 6.6965779,20.271787 6.23076923,19.1538462 L2.57692308,10.3846154 C2.36450587,9.87481408 2.60558331,9.28934029 3.11538462,9.07692308 C3.23725479,9.02614384 3.36797398,9 3.5,9 Z M12,17 C13.1045695,17 14,16.1045695 14,15 C14,13.8954305 13.1045695,13 12,13 C10.8954305,13 10,13.8954305 10,15 C10,16.1045695 10.8954305,17 12,17 Z"
											fill="#000000" />
									</g>
								</svg>
								<!--end::Svg Icon-->
							</span>
						</div>
					</div>
					<!--end::Symbol-->
					<!--begin::Title-->
					<div>
						<div class="font-size-h4 text-dark-75 font-weight-bolder">
							{{ number_format($headerTotal['total_order']) }}</div>
						<div class="font-size-sm text-muted font-weight-bold mt-1">Total Order</div>
					</div>
					<!--end::Title-->
				</div>
			</div>
			<div class="col-md">
				<div class="d-flex align-items-center mr-2">
					<!--begin::Symbol-->
					<div class="symbol symbol-45 symbol-light-info mr-4 flex-shrink-0">
						<div class="symbol-label">
							<span class="svg-icon svg-icon-lg svg-icon-info">
								<!--begin::Svg Icon | path:assets/media/svg/icons/Shopping/Cart3.svg-->
								<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
									height="24px" viewBox="0 0 24 24" version="1.1">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<rect x="0" y="0" width="24" height="24" />
										<path
											d="M12,4.56204994 L7.76822128,9.6401844 C7.4146572,10.0644613 6.7840925,10.1217854 6.3598156,9.76822128 C5.9355387,9.4146572 5.87821464,8.7840925 6.23177872,8.3598156 L11.2317787,2.3598156 C11.6315738,1.88006147 12.3684262,1.88006147 12.7682213,2.3598156 L17.7682213,8.3598156 C18.1217854,8.7840925 18.0644613,9.4146572 17.6401844,9.76822128 C17.2159075,10.1217854 16.5853428,10.0644613 16.2317787,9.6401844 L12,4.56204994 Z"
											fill="#000000" fill-rule="nonzero" opacity="0.3" />
										<path
											d="M3.5,9 L20.5,9 C21.0522847,9 21.5,9.44771525 21.5,10 C21.5,10.132026 21.4738562,10.2627452 21.4230769,10.3846154 L17.7692308,19.1538462 C17.3034221,20.271787 16.2111026,21 15,21 L9,21 C7.78889745,21 6.6965779,20.271787 6.23076923,19.1538462 L2.57692308,10.3846154 C2.36450587,9.87481408 2.60558331,9.28934029 3.11538462,9.07692308 C3.23725479,9.02614384 3.36797398,9 3.5,9 Z M12,17 C13.1045695,17 14,16.1045695 14,15 C14,13.8954305 13.1045695,13 12,13 C10.8954305,13 10,13.8954305 10,15 C10,16.1045695 10.8954305,17 12,17 Z"
											fill="#000000" />
									</g>
								</svg>
								<!--end::Svg Icon-->
							</span>
						</div>
					</div>
					<!--end::Symbol-->
					<!--begin::Title-->
					<div>
						<div class="font-size-h4 text-dark-75 font-weight-bolder">
							{{ number_format($headerTotal['totmerch']) }}</div>
						<div class="font-size-sm text-muted font-weight-bold mt-1">Total Merch</div>
					</div>
					<!--end::Title-->
				</div>
			</div>
			<div class="col-md">
				<div class="d-flex align-items-center mr-2">
					<!--begin::Symbol-->
					<div class="symbol symbol-45 symbol-light-info mr-4 flex-shrink-0">
						<div class="symbol-label">
							<span class="svg-icon svg-icon-lg svg-icon-info">
								<!--begin::Svg Icon | path:assets/media/svg/icons/Shopping/Cart3.svg-->
								<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
									height="24px" viewBox="0 0 24 24" version="1.1">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<rect x="0" y="0" width="24" height="24" />
										<path
											d="M12,4.56204994 L7.76822128,9.6401844 C7.4146572,10.0644613 6.7840925,10.1217854 6.3598156,9.76822128 C5.9355387,9.4146572 5.87821464,8.7840925 6.23177872,8.3598156 L11.2317787,2.3598156 C11.6315738,1.88006147 12.3684262,1.88006147 12.7682213,2.3598156 L17.7682213,8.3598156 C18.1217854,8.7840925 18.0644613,9.4146572 17.6401844,9.76822128 C17.2159075,10.1217854 16.5853428,10.0644613 16.2317787,9.6401844 L12,4.56204994 Z"
											fill="#000000" fill-rule="nonzero" opacity="0.3" />
										<path
											d="M3.5,9 L20.5,9 C21.0522847,9 21.5,9.44771525 21.5,10 C21.5,10.132026 21.4738562,10.2627452 21.4230769,10.3846154 L17.7692308,19.1538462 C17.3034221,20.271787 16.2111026,21 15,21 L9,21 C7.78889745,21 6.6965779,20.271787 6.23076923,19.1538462 L2.57692308,10.3846154 C2.36450587,9.87481408 2.60558331,9.28934029 3.11538462,9.07692308 C3.23725479,9.02614384 3.36797398,9 3.5,9 Z M12,17 C13.1045695,17 14,16.1045695 14,15 C14,13.8954305 13.1045695,13 12,13 C10.8954305,13 10,13.8954305 10,15 C10,16.1045695 10.8954305,17 12,17 Z"
											fill="#000000" />
									</g>
								</svg>
								<!--end::Svg Icon-->
							</span>
						</div>
					</div>
					<!--end::Symbol-->
					<!--begin::Title-->
					<div>
						<div class="font-size-h4 text-dark-75 font-weight-bolder">
							{{ round($headerTotal['total_index'], 1) }}{{ __('app.operators.percentage') }}</div>
						<div class="font-size-sm text-muted font-weight-bold mt-1">Total Index</div>
					</div>
					<!--end::Title-->
				</div>
			</div>
		</div>
	</div>
</div>

<div class="card card-custom mb-2">
	<div class="card-header flex-wrap border-0 pt-6 pb-0">
		<div class="card-title">
			<h3>
				{{ $area }}
				<span class="d-block text-muted pt-2 font-size-sm">Sorting & pagination remote datasource</span>
			</h3>
		</div>
	</div>
	<div class="card-body">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>{{ __('app.tables.number') }}</th>
					<th style="width: 300px">{{ __('Cabang') }}</th>
					<th>{{ __('Total SO') }}</th>
					<th>{{ __('Qty SO') }}</th>
					<th>{{ __('Total DO') }}</th>
					<th>{{ __('Qty DO') }}</th>
					<th>{{ __('Total Invoice') }}</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($generalManagers as $generalManager)
				<tr>
					<td>{{ $loop->iteration }}</td>
					<td>{{ $generalManager['cabang'] }}</td>
					<td>{{ __('app.operators.rupiah') }}{{ number_format($generalManager['total_order']) }}</td>
					<td>{{ $generalManager['qty_order'] }}</td>
					<td>{{ __('app.operators.rupiah') }}{{ number_format($generalManager['totmerch']) }}</td>
					<td>{{ $generalManager['qty_shipper'] }}</td>
					<td>{{ __('app.operators.rupiah') }}0</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endforeach
@endsection
