<table style="width: 100%; border: 1px solid black; border-collapse: collapse">
    <thead>
        <tr>
            <th height="40" style="border: 1px solid black; width: 30%">{{ __('app.reports.dsr.channel_bisnis') }}</th>
            <th height="40" style="border: 1px solid black; width: 10%">{{ __('app.reports.dsr.so_open') }}</th>
            <th height="40" style="border: 1px solid black; width: 10%">{{ __('app.reports.dsr.delivery_order') }}</th>
            <th height="40" style="border: 1px solid black; width: 10%">{{ __('app.reports.dsr.ar_invoice') }}</th>
            <th height="40" style="border: 1px solid black; width: 10%">{{ __('app.reports.dsr.sales_total') }}</th>
            <th height="40" style="border: 1px solid black; width: 10%">{{ __('app.reports.dsr.monthly_target') }}
            </th>
            <th height="40" style="border: 1px solid black; width: 8%">{{ __('app.reports.dsr.index_archive') }}</th>
            <th height="40" style="border: 1px solid black; width: 10%">{{ __('app.reports.dsr.gap') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($channel_DSRs as $channels => $channel)
            <tr>
                @if ($channels == 'TOTAL')
                    <td height="40" style="border: 1px solid black; padding-left: 5px" class="total">
                        {{ $channels }}</td>
                    <td height="40" align="right" style="border: 1px solid black; padding-right: 5px"
                        class="total">
                        {{ number_format($channel['so_open']) }}
                    </td>
                    <td height="40" align="right" style="border: 1px solid black; padding-right: 5px"
                        class="total">
                        {{ number_format($channel['delivery_order']) }}
                    </td>
                    <td height="40" align="right" style="border: 1px solid black; padding-right: 5px"
                        class="total">
                        {{ number_format($channel['ar_invoice']) }}
                    </td>
                    <td height="40" align="right" style="border: 1px solid black; padding-right: 5px"
                        class="total">
                        {{ number_format($channel['sales_total']) }}
                    </td>
                    <td height="40" align="right" style="border: 1px solid black; padding-right: 5px"
                        class="total">
                        {{ number_format($channel['monthly_target']) }}
                    </td>
                    <td height="40" align="right" style="border: 1px solid black; padding-right: 5px"
                        class="total">
                        {{ round($channel['index_archive'], 2) }}{{ __('app.operators.percentage') }}
                    </td>
                    <td height="40" align="right" style="border: 1px solid black; padding-right: 5px"
                        class="total">
                        {{ number_format($channel['gap']) }}
                    </td>
                @else
                    <td height="40" style="border: 1px solid black; padding-left: 5px">{{ $channels }}</td>
                    <td height="40" align="right" style="border: 1px solid black; padding-right: 5px">
                        {{ number_format($channel['so_open']) }}</td>
                    <td height="40" align="right" style="border: 1px solid black; padding-right: 5px">
                        {{ number_format($channel['delivery_order']) }}
                    </td>
                    <td height="40" align="right" style="border: 1px solid black; padding-right: 5px">
                        {{ number_format($channel['ar_invoice']) }}</td>
                    <td height="40" align="right" style="border: 1px solid black; padding-right: 5px">
                        {{ number_format($channel['sales_total']) }}</td>
                    <td height="40" align="right" style="border: 1px solid black; padding-right: 5px">
                        {{ number_format($channel['monthly_target']) }}
                    </td>
                    <td class="value"
                        style="color: white; background: {{ $channel['index_archive'] < $dates['timegone_index'] - 10 ? 'red' : ($channel['index_archive'] >= $dates['timegone_index'] - 5 ? 'green' : 'orange') }}">
                        {{ round($channel['index_archive'], 2) }}{{ __('app.operators.percentage') }}</td>
                    <td height="40" align="right" style="border: 1px solid black; padding-right: 5px">
                        {{ number_format($channel['gap']) }}</td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>
