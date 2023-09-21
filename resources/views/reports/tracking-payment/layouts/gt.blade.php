<table class="table table-bordered">
    <thead>
        <tr>
            <th rowspan="2" style="width:4%; vertical-align: middle; text-align: center; background-color:aliceblue;">
                Area
            </th>
            <th rowspan="2" style="width:4%; vertical-align: middle; text-align: center; background-color:aliceblue;">
                Cabang</th>
            <th colspan="3" style="width:23%; background-color: #ACACAC; text-align: center;background-color:plum;">
                GT</th>
            <th colspan="3"
                style="width:23%; background-color: #ACACAC; text-align: center; background-color:cornsilk;">
                MT</th>
            <th colspan="3"
                style="width:23%; background-color: #ACACAC; text-align: center; background-color:moccasin;">
                Total</th>
            <th colspan="3"
                style="width:23%; background-color: #ACACAC; text-align: center; background-color:lawngreen;">
                Average
                Payment per Day</th>
        </tr>
        <tr>
            <th style="width:10%; background-color:plum;">Target Payment</th>
            <th style="width:10%; background-color:plum;">Realisasi Payment</th>
            <th style="width:3%; background-color:plum;">Percentage</th>
            <th style="width:10%; background-color:cornsilk;">Target Payment</th>
            <th style="width:10%; background-color:cornsilk;">Realisasi Payment</th>
            <th style="width:3%; background-color:cornsilk;">Percentage</th>
            <th style="width:10%; background-color:moccasin;">Target Payment</th>
            <th style="width:10%; background-color:moccasin;">Realisasi Payment</th>
            <th style="width:3%; background-color:moccasin;">Percentage</th>
            <th style="width:7%; background-color:lawngreen;">GT</th>
            <th style="width:7%; background-color:lawngreen;">MT</th>
            <th style="width:7%; background-color:lawngreen;">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($trackingpayments['data'] as $area => $tracking_payments)
            @if ($area != 'GRANDTOTAL')
                @php
                    $branch_total = count($tracking_payments);
                @endphp

                <tr>
                    <td rowspan="{{ $branch_total + 1 }}" style="text-align: center;  ">
                        {{ $area }}</td>
                </tr>

                @foreach ($tracking_payments as $branch => $tracking_payment)
                    <tr>
                        @if ($branch == 'TOTAL')
                            <td height="40"
                                style="padding-left:5px; font-weight: 600; background-color:lightsteelblue;">
                                {{ $branch }}</td>
                            <td height="40" align="right"
                                style="padding-right:5px; font-weight: 600; background-color: lightsteelblue;">
                                {{ __('app.operators.rupiah') }}
                                {{ number_format($tracking_payment['GT']['target'] ?? 0) }}</td>
                            <td height="40" align="right"
                                style="padding-right:5px; font-weight: 600; background-color: lightsteelblue;">
                                {{ __('app.operators.rupiah') }}
                                {{ number_format($tracking_payment['GT']['realisasi_payment'] ?? 0) }}</td>
                            <td height="40" align="right"
                                style="padding-right:5px; font-weight: 600;background-color: {{ $tracking_payment['GT']['index'] < 50 ? 'red' : ($tracking_payment['GT']['index'] > 90 ? 'limegreen' : 'yellow') }};  ">
                                {{ round($tracking_payment['GT']['index'], 2) }}{{ __('app.operators.percentage') }}
                            </td>
                            <td height="40" align="right"
                                style="padding-right:5px; font-weight: 600; background-color: lightsteelblue;  ">
                                {{ __('app.operators.rupiah') }}
                                {{ number_format($tracking_payment['MT']['target'] ?? 0) }}</td>
                            <td height="40" align="right"
                                style="padding-right:5px; font-weight: 600; background-color: lightsteelblue;  ">
                                {{ __('app.operators.rupiah') }}
                                {{ number_format($tracking_payment['MT']['realisasi_payment'] ?? 0) }}</td>
                            <td height="40" align="right"
                                style="padding-right:5px; font-weight: 600; background-color: {{ $tracking_payment['MT']['index'] < 50 ? 'red' : ($tracking_payment['MT']['index'] > 90 ? 'limegreen' : 'yellow') }};  ">
                                {{ round($tracking_payment['MT']['index'], 2) }}{{ __('app.operators.percentage') }}
                            </td>
                            <td height="40" align="right"
                                style="padding-right:5px; font-weight: 600; background-color: lightsteelblue;  ">
                                {{ __('app.operators.rupiah') }}
                                {{ number_format($tracking_payment['Total']['target'] ?? 0) }}</td>
                            <td height="40" align="right"
                                style="padding-right:5px; font-weight: 600; background-color: lightsteelblue;  ">
                                {{ __('app.operators.rupiah') }}
                                {{ number_format($tracking_payment['Total']['realisasi_payment'] ?? 0) }}</td>
                            <td height="40" align="right"
                                style="padding-right:5px; font-weight: 600; background-color: {{ $tracking_payment['Total']['index'] < 50 ? 'red' : ($tracking_payment['Total']['index'] > 90 ? 'limegreen' : 'yellow') }};  ">
                                {{ round($tracking_payment['Total']['index'], 2) }}{{ __('app.operators.percentage') }}
                            </td>
                            <td height="40" align="right"
                                style="padding-right:5px; font-weight: 600; background-color: lightsteelblue;  ">
                                {{ __('app.operators.rupiah') }}
                                {{ number_format($tracking_payment['Average']['GT'] ?? 0) }}</td>
                            <td height="40" align="right"
                                style="padding-right:5px; font-weight: 600; background-color: lightsteelblue;  ">
                                {{ __('app.operators.rupiah') }}
                                {{ number_format($tracking_payment['Average']['MT'] ?? 0) }}</td>
                            <td height="40" align="right"
                                style="padding-right:5px; font-weight: 600; background-color:lightsteelblue;  ">
                                {{ __('app.operators.rupiah') }}
                                {{ number_format($tracking_payment['Average']['Total'] ?? 0) }}</td>
                        @else
                            <td height="40" style="padding-left:5px;  ">{{ $branch }}
                            </td>
                            <td height="40" align="right" style="padding-right:5px;  ">
                                {{ __('app.operators.rupiah') }}
                                {{ number_format($tracking_payment['GT']['target'] ?? 0) }}</td>
                            <td height="40" align="right" height="40" style="padding-right:5px;  ">
                                {{ __('app.operators.rupiah') }}
                                {{ number_format($tracking_payment['GT']['realisasi_payment'] ?? 0) }}</td>
                            <td height="40" align="right"
                                style="padding-right:5px; background-color: {{ ($tracking_payment['GT']['index'] ?? 0) < 50 ? 'red' : (($tracking_payment['GT']['index'] ?? 0) > 90 ? 'limegreen' : 'yellow') }};  ">
                                {{ round($tracking_payment['GT']['index'] ?? 0, 2) }}{{ __('app.operators.percentage') }}
                            </td>
                            <td height="40" align="right" style="padding-right:5px;  ">
                                {{ __('app.operators.rupiah') }}
                                {{ number_format($tracking_payment['MT']['target'] ?? 0) }}
                            </td>
                            <td height="40" align="right" style="padding-right:5px;  ">
                                {{ __('app.operators.rupiah') }}
                                {{ number_format($tracking_payment['MT']['realisasi_payment'] ?? 0) }}</td>
                            <td height="40" align="right"
                                style="padding-right:5px; background-color: {{ ($tracking_payment['MT']['index'] ?? 0) < 50 ? 'red' : (($tracking_payment['MT']['index'] ?? 0) > 90 ? 'limegreen' : 'yellow') }};  ">
                                {{ round($tracking_payment['MT']['index'] ?? 0, 2) }}{{ __('app.operators.percentage') }}
                            </td>
                            <td height="40" align="right" style="padding-right:5px;  ">
                                {{ __('app.operators.rupiah') }}
                                {{ number_format($tracking_payment['Total']['target'] ?? 0) }}
                            </td>
                            <td height="40" align="right" style="padding-right:5px;  ">
                                {{ __('app.operators.rupiah') }}
                                {{ number_format($tracking_payment['Total']['realisasi_payment'] ?? 0) }}</td>
                            <td height="40" align="right"
                                style="padding-right:5px; background-color: {{ ($tracking_payment['Total']['index'] ?? 0) < 50 ? 'red' : (($tracking_payment['Total']['index'] ?? 0) > 90 ? 'limegreen' : 'yellow') }};  ">
                                {{ round($tracking_payment['Total']['index'] ?? 0, 2) }}{{ __('app.operators.percentage') }}
                            </td>
                            <td height="40" align="right" style="padding-right:5px;  ">
                                {{ __('app.operators.rupiah') }}
                                {{ number_format($tracking_payment['Average']['GT'] ?? 0) }}
                            </td>
                            <td height="40" align="right" style="padding-right:5px;  ">
                                {{ __('app.operators.rupiah') }}
                                {{ number_format($tracking_payment['Average']['MT'] ?? 0) }}</td>
                            <td height="40" align="right" style="padding-right:5px;  ">
                                {{ __('app.operators.rupiah') }}
                                {{ number_format($tracking_payment['Average']['Total'] ?? 0) }}</td>
                        @endif
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="2" height="40"
                        style="text-align: center; background-color:lightpink; font-weight: 600;  ">
                        {{ $area }}</td>
                    <td height="40" align="right"
                        style="padding-right:5px; font-weight: 600; background-color:lightpink;  ">
                        {{ __('app.operators.rupiah') }}
                        {{ number_format($tracking_payments['GT']['target'] ?? 0) }}</td>
                    <td height="40" align="right"
                        style="padding-right:5px; font-weight: 600; background-color: lightpink;  ">
                        {{ __('app.operators.rupiah') }}
                        {{ number_format($tracking_payments['GT']['realisasi_payment'] ?? 0) }}</td>
                    <td height="40" align="right"
                        style="padding-right:5px; font-weight: 600;background-color: {{ $tracking_payments['GT']['index'] < 50 ? 'red' : ($tracking_payments['GT']['index'] > 90 ? 'limegreen' : 'yellow') }};  ">
                        {{ round($tracking_payments['GT']['index'], 2) }}{{ __('app.operators.percentage') }}
                    </td>
                    <td height="40" align="right"
                        style="padding-right:5px; font-weight: 600; background-color: lightpink;  ">
                        {{ __('app.operators.rupiah') }}
                        {{ number_format($tracking_payments['MT']['target'] ?? 0) }}</td>
                    <td height="40" align="right"
                        style="padding-right:5px; font-weight: 600; background-color: lightpink;  ">
                        {{ __('app.operators.rupiah') }}
                        {{ number_format($tracking_payments['MT']['realisasi_payment'] ?? 0) }}</td>
                    <td height="40" align="right"
                        style="padding-right:5px; font-weight: 600; background-color: {{ $tracking_payments['MT']['index'] < 50 ? 'red' : ($tracking_payments['MT']['index'] > 90 ? 'limegreen' : 'yellow') }};  ">
                        {{ round($tracking_payments['MT']['index'], 2) }}{{ __('app.operators.percentage') }}
                    </td>
                    <td height="40" align="right"
                        style="padding-right:5px; font-weight: 600; background-color: lightpink;  ">
                        {{ __('app.operators.rupiah') }}
                        {{ number_format($tracking_payments['Total']['target'] ?? 0) }}</td>
                    <td height="40" align="right"
                        style="padding-right:5px; font-weight: 600; background-color: lightpink;  ">
                        {{ __('app.operators.rupiah') }}
                        {{ number_format($tracking_payments['Total']['realisasi_payment'] ?? 0) }}</td>
                    <td height="40" align="right"
                        style="padding-right:5px; font-weight: 600; background-color: {{ $tracking_payments['Total']['index'] < 50 ? 'red' : ($tracking_payments['Total']['index'] > 90 ? 'limegreen' : 'yellow') }};  ">
                        {{ round($tracking_payments['Total']['index'], 2) }}{{ __('app.operators.percentage') }}
                    </td>
                    <td height="40" align="right"
                        style="padding-right:5px; font-weight: 600; background-color: lightpink;  ">
                        {{ __('app.operators.rupiah') }}
                        {{ number_format($tracking_payments['Average']['GT'] ?? 0) }}</td>
                    <td height="40" align="right"
                        style="padding-right:5px; font-weight: 600; background-color: lightpink;  ">
                        {{ __('app.operators.rupiah') }}
                        {{ number_format($tracking_payments['Average']['MT'] ?? 0) }}</td>
                    <td height="40" align="right"
                        style="padding-right:5px; font-weight: 600; background-color:lightpink;  ">
                        {{ __('app.operators.rupiah') }}
                        {{ number_format($tracking_payments['Average']['Total'] ?? 0) }}</td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>
