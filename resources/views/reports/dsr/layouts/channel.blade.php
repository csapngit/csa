<table class="table table-bordered">
	<thead>
		<tr>
			<th>{{ __('app.reports.dsr.channel_bisnis') }}</th>
			<th>{{ __('app.reports.dsr.so_open') }}</th>
			<th>{{ __('app.reports.dsr.delivery_order') }}</th>
			<th>{{ __('app.reports.dsr.ar_invoice') }}</th>
			<th>{{ __('app.reports.dsr.sales_total') }}</th>
			<th>{{ __('app.reports.dsr.monthly_target') }}</th>
			<th>{{ __('app.reports.dsr.index_archive') }}</th>
			<th>{{ __('app.reports.dsr.gap') }}</th>
		</tr>
	</thead>
	<tbody>
		{{-- @dd($channel_DSRs); --}}
		@foreach ($channel_DSRs as $channels => $channel)
		<tr>
			@if ($channels == 'TOTAL')
			<td class="total">{{ $channels }}</td>
			<td class="total value">{{ number_format($channel['so_open']) }}</td>
			<td class="total value">{{ number_format($channel['delivery_order']) }}</td>
			<td class="total value">{{ number_format($channel['ar_invoice']) }}</td>
			<td class="total value">{{ number_format($channel['sales_total']) }}</td>
			<td class="total value">{{ number_format($channel['monthly_target']) }}</td>
			<td class="total value">{{ round($channel['index_archive'], 2) }}{{ __('app.operators.percentage') }}</td>
			<td class="total value">{{ number_format($channel['gap']) }}</td>
			@else
			<td>{{ $channels }}</td>
			<td class="value">{{ number_format($channel['so_open']) }}</td>
			<td class="value">{{ number_format($channel['delivery_order']) }}</td>
			<td class="value">{{ number_format($channel['ar_invoice']) }}</td>
			<td class="value">{{ number_format($channel['sales_total']) }}</td>
			<td class="value">{{ number_format($channel['monthly_target']) }}</td>
			<td class="value" style="color: white; background: {{ $channel['index_archive'] < $dates['timegone_index'] ? 'red' : 'green' }}">
				{{ round($channel['index_archive'], 2) }}{{ __('app.operators.percentage') }}</td>
			<td class="value">{{ number_format($channel['gap']) }}</td>
			@endif
		</tr>
		@endforeach
	</tbody>
</table>
