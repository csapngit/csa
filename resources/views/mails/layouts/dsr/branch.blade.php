<table style="width: 100%; border: 1px solid black; border-collapse: collapse" cellpadding="0" cellspacing="0">
	<thead>
		<tr>
			<th height="40" style="border: 1px solid black;">{{ __('app.reports.dsr.branch') }}</th>
			<th height="40" style="border: 1px solid black;">{{ __('app.reports.dsr.channel_bisnis') }}</th>
			<th height="40" style="border: 1px solid black;">{{ __('app.reports.dsr.so_open') }}</th>
			<th height="40" style="border: 1px solid black;">{{ __('app.reports.dsr.delivery_order') }}</th>
			<th height="40" style="border: 1px solid black;">{{ __('app.reports.dsr.ar_invoice') }}</th>
			<th height="40" style="border: 1px solid black;">{{ __('app.reports.dsr.sales_total') }}</th>
			<th height="40" style="border: 1px solid black;">{{ __('app.reports.dsr.monthly_target') }}</th>
			<th height="40" style="border: 1px solid black;">{{ __('app.reports.dsr.index_archive') }}</th>
			<th height="40" style="border: 1px solid black;">{{ __('app.reports.dsr.gap') }}</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($branch_datas as $branch => $branch_data)

		@php
		$dsr_key = count($branch_data);
		@endphp

		<td style="border: 1px solid black; font-weight: 600; vertical-align: top; padding-left: 5px"
			rowspan="{{ $dsr_key + 1 }}">
			{{ $branch }}
		</td>

		@foreach ($branch_data as $mapping => $dsr)
		<tr>
			@if ($mapping == 'TOTAL')
			<td height="40" style="border: 1px solid black; padding-left: 5px" class="total">{{ $mapping }}</td>
			<td height="40" align="right" style="border: 1px solid black; padding-right: 5px" class="total">
				{{ number_format($dsr['so_open']) }}
			</td>
			<td height="40" align="right" style="border: 1px solid black; padding-right: 5px" class="total">
				{{ number_format($dsr['delivery_order']) }}
			</td>
			<td height="40" align="right" style="border: 1px solid black; padding-right: 5px" class="total">
				{{ number_format($dsr['ar_invoice']) }}
			</td>
			<td height="40" align="right" style="border: 1px solid black; padding-right: 5px" class="total">
				{{ number_format($dsr['sales_total']) }}
			</td>
			<td height="40" align="right" style="border: 1px solid black; padding-right: 5px" class="total">
				{{ number_format($dsr['monthly_target']) }}
			</td>
			<td height="40" align="right" style="border: 1px solid black; padding-right: 5px" class="total">
				{{ round($dsr['index_archive'], 2) }}{{ __('app.operators.percentage') }}
			</td>
			<td height="40" align="right" style="border: 1px solid black; padding-right: 5px" class="total">
				{{ number_format($dsr['gap']) }}
			</td>
			@else
			<td style="border: 1px solid black; padding-left: 5px;">{{ $mapping }}</td>
			<td height="40" align="right" style="border: 1px solid black; padding-right: 5px">
				{{ number_format($dsr['so_open']) }}</td>
			<td height="40" align="right" style="border: 1px solid black; padding-right: 5px">
				{{ number_format($dsr['delivery_order']) }}</td>
			<td height="40" align="right" style="border: 1px solid black; padding-right: 5px">
				{{ number_format($dsr['ar_invoice']) }}</td>
			<td height="40" align="right" style="border: 1px solid black; padding-right: 5px">
				{{ number_format($dsr['sales_total']) }}</td>
			<td height="40" align="right" style="border: 1px solid black; padding-right: 5px">
				{{ number_format($dsr['monthly_target']) }}</td>
			<td height="40" align="right"
				style="border: 1px solid black; padding-right: 5px; color: white; background: {{ $dsr['index_archive'] < $dates['timegone_index'] ? 'red' : 'green' }}">
				{{ round($dsr['index_archive'], 2) }}{{ __('app.operators.percentage') }}
			</td>
			<td height="40" align="right" style="border: 1px solid black; padding-right: 5px">
				{{ number_format($dsr['gap']) }}
			</td>
			@endif
		</tr>
		@endforeach
		@endforeach
	</tbody>
</table>
