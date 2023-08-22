<table width="100%" cellpadding="0" cellspacing="0" align="center">
    <tr>
        <td class="main_container">
            <table width="50%" align="left" style="font-weight: 600">
                <tbody>
                    <tr height="25" style="border: none">
                        <td style="width: 200px; border: none">{{ __('app.reports.trackingpayment.date') }}</td>
                        <td style="border: none">: {{ $dates['date'] }}</td>
                    </tr>
                    <tr height="25" style="border: none">
                        <td style="width: 200px; border: none">{{ __('app.reports.trackingpayment.timegone_index') }}
                        </td>
                        <td style="border: none">:
                            {{ round($dates['timegone_index'], 2) }}{{ __('app.operators.percentage') }}
                        </td>
                    </tr>
                    <tr height="25" style="border: none">
                        <td style="width: 200px; border: none">{{ __('app.reports.trackingpayment.working_days') }}</td>
                        <td style="border: none">: {{ $dates['workday'] }}</td>
                    </tr>
                    <tr height="25" style="border: none">
                        <td style="width: 200px; border: none">{{ __('app.reports.trackingpayment.timegone') }}</td>
                        <td style="border: none">: {{ $dates['timegone'] }}</td>
                    </tr>
                    <tr height="25" style="border: none">
                        <td style="width: 200px; border: none">
                            {{ __('app.reports.trackingpayment.the_rest_of_working_days') }}</td>
                        <td style="border: none">: {{ $dates['rest_of_workdays'] }}</td>
                    </tr>
                </tbody>
            </table>
            <table width="50%" align="right" style="font-weight: 600">
                <tbody>
                    <tr height="25" style="border: none">
                        <td style="width: 200px; border: none">{{ __('app.reports.trackingpayment.target') }}</td>
                        <td style="border: none">:
                            {{ __('app.operators.rupiah') }}{{ number_format($trackingpayments['total']['totaltarget']) }}
                        </td>
                    </tr>
                    <tr height="25" style="border: none">
                        <td style="width: 200px; border: none">{{ __('app.reports.trackingpayment.achievement') }}
                        </td>
                        <td style="border: none">:
                            {{ __('app.operators.rupiah') }}{{ number_format($trackingpayments['total']['achievement']) }}
                        </td>
                    </tr>
                    <tr height="25" style="border: none">
                        <td style="width: 200px; border: none">{{ __('app.reports.trackingpayment.acvh_vs_target') }}
                        </td>
                        <td
                            style="border: none; backround: {{ $trackingpayments['total']['achievetarget'] < 50 ? 'red' : ($trackingpayments['total']['achievetarget'] > 90 ? 'green' : 'yellow') }}">
                            :
                            {{ round($trackingpayments['total']['achievetarget'], 2) }}{{ __('app.operators.percentage') }}
                        </td>
                    </tr>
                    <tr height="25" style="border: none">
                        <td style="width: 200px; border: none">{{ __('app.reports.trackingpayment.acvh_vs_timegone') }}
                        </td>
                        <td style="border: none">:
                            {{ round($trackingpayments['total']['achievetimegone'], 2) }}{{ __('app.operators.percentage') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
</table>
