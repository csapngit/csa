<table class="table table-bordered" style="width: 500px">
	<thead>
		<tr>
			{{-- <th rowspan="2" class="text-center" style="vertical-align: middle">Area</th>
			<th rowspan="2" class="text-center" style="vertical-align: middle">Cabang</th> --}}
			<th colspan="3" class="text-center" style="background-color: #ACACAC">Total</th>
		</tr>
		<tr>
			<th>Target Payment</th>
			<th>Realisasi Payment</th>
			<th>Percentage</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($total_payment_datas as $area => $total_payments)

		{{-- @php
			$branch_total = count($total_payments)
		@endphp

		<tr>
			<td rowspan="{{ $branch_total + 1 }}">{{ $area }}</td>
		</tr> --}}

		@foreach ($total_payments as $branch => $total_payment)
		<tr>
			@if ($branch == 'TOTAL')
			{{-- <td style="font-weight: 600; background-color: yellow">{{ $branch }}</td> --}}
			<td style="font-weight: 600; background-color: yellow">{{ __('app.operators.rupiah') }} {{ number_format($total_payment['target'] ?? 0) }}</td>
			<td style="font-weight: 600; background-color: yellow">{{ __('app.operators.rupiah') }} {{ number_format($total_payment['realisasi_payment'] ?? 0) }}</td>
			<td style="font-weight: 600; background-color: yellow">{{ round($total_payment['index'], 2) }}{{ __('app.operators.percentage') }}</td>
			@else
			{{-- <td>{{ $branch }}</td> --}}
			<td>{{ __('app.operators.rupiah') }} {{ number_format($total_payment['target'] ?? 0) }}</td>
			<td>{{ __('app.operators.rupiah') }} {{ number_format($total_payment['realisasi_payment'] ?? 0) }}</td>
			<td>{{ round($total_payment['index'] ?? 0, 2) }}{{ __('app.operators.percentage') }}</td>
			@endif
		</tr>
		@endforeach
		@endforeach
	</tbody>
</table>
