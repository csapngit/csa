<table width="100%" cellpadding="0" cellspacing="0" align="center">
    <tr>
        <td class="main_container">
            <table width="100%" style="font-weight: 600">
                <tbody>
                    <tr height="25" style="border: none">
                        <td style="width: 5%; border: none"></td>
                        <td style="width: 10%; border: none">{{ __('app.reports.trackingpayment.date') }}</td>
                        <td align="right" style="width: 15%; border: none"> {{ $dates['date'] }}</td>
                        <td style="width: 40%; border: none"></td>
                        <td style="width: 10%; border: none">{{ __('app.reports.trackingpayment.target') }}</td>
                        <td align="right" style="width: 15%; border: none">
                            {{ __('app.operators.rupiah') }}{{ number_format($trackingpayments['total']['totaltarget']) }}
                        </td>
                        <td style="width: 5%; border: none"></td>
                    </tr>
                    <tr height="25" style="border: none">
                        <td style="width: 5%; border: none"></td>
                        <td style="width: 10%; border: none">{{ __('app.reports.trackingpayment.timegone_index') }}
                        </td>
                        <td align="right" style="width: 15%; border: none">
                            {{ round($dates['timegone_index'], 2) }}{{ __('app.operators.percentage') }}
                        </td>
                        <td style="width: 40%; border: none"></td>
                        <td style="width: 10%; border: none">{{ __('app.reports.trackingpayment.achievement') }}
                        </td>
                        <td align="right" style="width: 15%; border: none">
                            {{ __('app.operators.rupiah') }}{{ number_format($trackingpayments['total']['achievement']) }}
                        </td>
                        <td style="width: 5%; border: none"></td>
                    </tr>
                    <tr height="25" style="border: none">
                        <td style="width: 5%; border: none"></td>
                        <td style="width: 10%; border: none">{{ __('app.reports.trackingpayment.working_days') }}
                        </td>
                        <td align="right" style="width: 15%; border: none">{{ $dates['workday'] }}</td>
                        <td style="width: 40%; border: none"></td>
                        <td style="width: 10%; border: none">{{ __('app.reports.trackingpayment.acvh_vs_target') }}
                        </td>
                        <td align="right"
                            style="width: 15%; border: none; background-color: {{ $trackingpayments['total']['achievetarget'] < 50 ? 'red' : ($trackingpayments['total']['achievetarget'] > 90 ? 'green' : 'yellow') }}">
                            {{ round($trackingpayments['total']['achievetarget'], 2) }}{{ __('app.operators.percentage') }}
                        </td>
                        <td style="width: 5%; border: none"></td>
                    </tr>
                    <tr height="25" style="border: none">
                        <td style="width: 3%; border: none"></td>
                        <td style="width: 10%; border: none">{{ __('app.reports.trackingpayment.timegone') }}</td>
                        <td align="right" style="width: 15%; border: none">{{ $dates['timegone'] }}</td>
                        <td style="width: 40%; border: none"></td>
                        <td style="width: 10% border: none">{{ __('app.reports.trackingpayment.acvh_vs_timegone') }}
                        </td>
                        <td align="right"
                            style="width: 15%; border: none; background-color: {{ $trackingpayments['total']['achievetimegone'] < 50 ? 'red' : ($trackingpayments['total']['achievetarget'] > 90 ? 'green' : 'yellow') }}">
                            {{ round($trackingpayments['total']['achievetimegone'], 2) }}{{ __('app.operators.percentage') }}
                        </td>
                        <td style="width: 5%; border: none"></td>
                    </tr>
                    <tr height="25" style="border: none">
                        <td style="width: 5%; border: none"></td>
                        <td style="width: 10%; border: none">
                            {{ __('app.reports.trackingpayment.the_rest_of_working_days') }}</td>
                        <td align="right" style="width: 15%; border: none"> {{ $dates['rest_of_workdays'] }}</td>
                        <td style="width: 40%; border: none"></td>
                        <td style="width: 10%; border: none"></td>
                        <td style="width: 15%; border: none"></td>
                        <td style="width: 5%; border: none"></td>
                    </tr>
                </tbody>
            </table>
