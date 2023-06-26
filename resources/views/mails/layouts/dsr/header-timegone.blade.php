<table width="100%" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td class="main_container">
			<table widht="300" align="left" class="left_column" style="font-weight: 600">
				<tbody>
					<tr height="25" style="border: none">
						<td style="width: 200px; border: none">{{ __('app.reports.dsr.date') }}</td>
						<td style="border: none">: {{ $dates['date'] }}</td>
					</tr>
					<tr height="25" style="border: none">
						<td style="width: 200px; border: none">{{ __('app.reports.dsr.timegone_index') }}</td>
						<td style="border: none">: {{ round($dates['timegone_index'], 2) }}{{ __('app.operators.percentage') }}
						</td>
					</tr>
					<tr height="25" style="border: none">
						<td style="width: 200px; border: none">{{ __('app.reports.dsr.working_days') }}</td>
						<td style="border: none">: {{ $dates['workday'] }}</td>
					</tr>
					<tr height="25" style="border: none">
						<td style="width: 200px; border: none">{{ __('app.reports.dsr.timegone') }}</td>
						<td style="border: none">: {{ $dates['timegone'] }}</td>
					</tr>
					<tr height="25" style="border: none">
						<td style="width: 200px; border: none">{{ __('app.reports.dsr.the_rest_of_working_days') }}</td>
						<td style="border: none">: {{ $dates['rest_of_workdays'] }}</td>
					</tr>
				</tbody>
			</table>
			<table width="600" align="right" class="right_column" style="font-weight: 600">
				<tbody>
					<tr height="30" style="border: none">
						<td style="width: 200px; border: none">{{ __('app.reports.dsr.target') }}</td>
						<td style="border: none">:
							{{ __('app.operators.rupiah') }}{{ number_format($channel_DSRs['TOTAL']['monthly_target']) }}</td>
					</tr>
					<tr height="30" style="border: none">
						<td style="width: 200px; border: none">{{ __('app.reports.dsr.so_open') }}</td>
						<td style="border: none">:
							{{ __('app.operators.rupiah') }}{{ number_format($channel_DSRs['TOTAL']['so_open']) }}</td>
					</tr>
					<tr height="30" style="border: none">
						<td style="width: 200px; border: none">{{ __('app.reports.dsr.delivery_order') }}</td>
						<td style="border: none">:
							{{ __('app.operators.rupiah') }}{{ number_format($channel_DSRs['TOTAL']['delivery_order']) }}</td>
					</tr>
					<tr height="30" style="border: none">
						<td style="width: 200px; border: none">{{ __('app.reports.dsr.ar_invoice') }}</td>
						<td style="border: none">:
							{{ __('app.operators.rupiah') }}{{ number_format($channel_DSRs['TOTAL']['ar_invoice']) }}</td>
					</tr>
					<tr height="30" style="border: none">
						<td style="width: 200px; border: none">{{ __('app.reports.dsr.best_estimate') }}</td>
						<td style="border: none">:
							{{ __('app.operators.rupiah') }}{{ number_format($channel_DSRs['TOTAL']['best_estimate']) }}</td>
					</tr>
					<tr height="30" style="border: none">
						<td style="width: 200px; border: none">{{ __('app.reports.dsr.acvh_vs_target') }}</td>
						<td style="border: none">:
							{{ round($channel_DSRs['TOTAL']['achv_vs_target'], 2) }}{{ __('app.operators.percentage') }}</td>
					</tr>
					<tr height="30" style="border: none">
						<td style="width: 200px; border: none">{{ __('app.reports.dsr.acvh_vs_timegone') }}</td>
						<td style="border: none">:
							{{ round($channel_DSRs['TOTAL']['achv_vs_timegone'], 2) }}{{ __('app.operators.percentage') }}</td>
					</tr>
				</tbody>
			</table>
		</td>
	</tr>
</table>
