<table class="table table-bordered">
    <thead>
        <tr>
            <th>{{ __('app.reports.dsr.branch') }}</th>
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
        @foreach ($branch_datas as $branch => $branch_data)
            @php
                $dsr_key = count($branch_data);
            @endphp

            <td rowspan="{{ $dsr_key + 1 }}" style="font-weight: 600">{{ $branch }}</td>

            @foreach ($branch_data as $mapping => $dsr)
                <tr>
                    @if ($mapping == 'TOTAL')
                        <td class="total">{{ $mapping }}</td>
                        <td class="total value">{{ number_format($dsr['so_open']) }}</td>
                        <td class="total value">{{ number_format($dsr['delivery_order']) }}</td>
                        <td class="total value">{{ number_format($dsr['ar_invoice']) }}</td>
                        <td class="total value">{{ number_format($dsr['sales_total']) }}</td>
                        <td class="total value">{{ number_format($dsr['monthly_target']) }}</td>
                        <td class="total value">
                            {{ round($dsr['index_archive'], 2) }}{{ __('app.operators.percentage') }}</td>
                        <td class="total value">{{ number_format($dsr['gap']) }}</td>
                    @else
                        <td>{{ $mapping }}</td>
                        <td class="value">{{ number_format($dsr['so_open']) }}</td>
                        <td class="value">{{ number_format($dsr['delivery_order']) }}</td>
                        <td class="value">{{ number_format($dsr['ar_invoice']) }}</td>
                        <td class="value">{{ number_format($dsr['sales_total']) }}</td>
                        <td class="value">{{ number_format($dsr['monthly_target']) }}</td>
                        <td class="value"
                            style="color: white; background: {{ $dsr['index_archive'] < $dates['timegone_index'] - 10 ? 'red' : ($dsr['index_archive'] >= $dates['timegone_index'] - 5 ? 'green' : 'orange') }}">
                            {{ round($dsr['index_archive'], 2) }}{{ __('app.operators.percentage') }}</td>
                        <td class="value">{{ number_format($dsr['gap']) }}</td>
                    @endif
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
