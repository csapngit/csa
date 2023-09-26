<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style type="text/css">
    </style>
</head>

<body>
    <h3 style="text-align: center;">AR DAYS REPORT</h3>
    <br />
    <table style="width=100%; font-weight: 600">
        <tbody>
            <tr>
                <td style="width:5%;"></td>
                <td style="width: 10%;">Date</td>
                <td style="width: 18%;">{{ $date }}</td>
                <td style="width: 34%;"></td>
                <td style="width: 10%;"></td>
                <td style="width: 18%;"></td>
                <td style="width: 5%;"></td>
            </tr>
            <tr>
                <td style="width:5%;"></td>
                <td style="width: 10%;">Daypassed</td>
                <td style="width: 15%;">{{ $daypassed }}</td>
                <td style="width: 40%;"></td>
                <td style="width: 10%;"></td>
                <td style="width: 15%;"></td>
                <td style="width: 5%;"></td>
            </tr>
        </tbody>
    </table>
    <br />
    <table style="width:100%; border: 1px solid black; border-collapse: collapse;">
        <thead style="text-align: center;">
            <tr>
                <th rowspan="2"
                    style="width:4%; height:40px; vertical-align: middle; border: 1px solid black; background-color:aliceblue;">
                    Area
                </th>
                <th rowspan="2"
                    style="width:15% height:40px; vertical-align: middle; border: 1px solid black; background-color:aliceblue;">
                    Cabang
                </th>
                <th colspan="3" style="width:27%; height:40px; border: 1px solid black; background-color:plum;">GT
                </th>
                <th colspan="3" style="width:27%; height:40px; border: 1px solid black; background-color:cornsilk;">
                    MT</th>
                <th colspan="3" style="width:27%; height:40px; border: 1px solid black; background-color:moccasin;">
                    Total</th>
            </tr>
            <tr>
                <th style="width:9%; height:40px; border: 1px solid black; background-color:plum;">Target</th>
                <th style="width:9%; height:40px; border: 1px solid black; background-color:plum;">AR Day</th>
                <th style="width:9%; height:40px; border: 1px solid black; background-color:plum;">Percentage</th>
                <th style="width:9%; height:40px; border: 1px solid black; background-color:cornsilk;">Target</th>
                <th style="width:9%; height:40px; border: 1px solid black; background-color:cornsilk;">AR Day</th>
                <th style="width:9%; height:40px; border: 1px solid black; background-color:cornsilk;">Percentage</th>
                <th style="width:9%; height:40px; border: 1px solid black; background-color:moccasin;">Target</th>
                <th style="width:9%; height:40px; border: 1px solid black; background-color:moccasin;">AR Day</th>
                <th style="width:9%; height:40px; border: 1px solid black; background-color:moccasin;">Percentage</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ardays as $area => $arday)
                @if ($area != 'AVERAGE TOTAL')
                    @php
                        $branch_total = count($arday);
                        // dd($area);
                    @endphp

                    <tr>
                        <td rowspan="{{ $branch_total + 1 }}"
                            style="text-align: center; vertical-align: middle; border: 1px solid black;">
                            {{ $area }}</td>
                    </tr>

                    @foreach ($arday as $branch => $ardayData)
                        @if ($branch != 'AVERAGE')
                            <tr>
                                <td style="padding-left:5px; height:30px; border: 1px solid black;">{{ $branch }}
                                </td>
                                <td style="padding-right:5px; height:30px; text-align: right; border: 1px solid black;">
                                    {{ $ardayData['GT']['target'] ?? '' }}
                                </td>
                                <td style="padding-right:5px; height:30px; text-align: right; border: 1px solid black;">
                                    {{ isset($ardayData['GT']['ardays']) ? round($ardayData['GT']['ardays'], 2) : '' }}
                                </td>
                                <td
                                    style="padding-right:5px; height:30px; text-align: right; border: 1px solid black; background-color: {{ isset($ardayData['GT']['percentage']) ? (round($ardayData['GT']['percentage']) < 50 ? 'red' : ($ardayData['GT']['percentage'] > 90 ? 'limegreen' : 'yellow')) : '' }}">
                                    {{ isset($ardayData['GT']['percentage']) ? round($ardayData['GT']['percentage'], 2) . '%' : '' }}
                                </td>
                                <td style="padding-right:5px; height:30px; text-align: right; border: 1px solid black;">
                                    {{ $ardayData['MT']['target'] ?? '' }}
                                </td>
                                <td style="padding-right:5px; height:30px; text-align: right; border: 1px solid black;">
                                    {{ isset($ardayData['MT']['ardays']) ? round($ardayData['MT']['ardays'], 2) : '' }}
                                </td>
                                <td
                                    style="padding-right:5px; height:30px; text-align: right; border: 1px solid black; background-color: {{ isset($ardayData['MT']['percentage']) ? (round($ardayData['MT']['percentage']) < 50 ? 'red' : ($ardayData['MT']['percentage'] > 90 ? 'limegreen' : 'yellow')) : '' }}">
                                    {{ isset($ardayData['MT']['percentage']) ? round($ardayData['MT']['percentage'], 2) . '%' : '' }}
                                </td>
                                <td style="padding-right:5px; height:30px; text-align: right; border: 1px solid black;">
                                    {{ round($ardayData['total']['target'], 2) }}</td>
                                <td style="padding-right:5px;height:30px; text-align: right; border: 1px solid black;">
                                    {{ round($ardayData['total']['ardays'], 2) }}
                                </td>
                                <td
                                    style="padding-right:5px; height:30px; text-align: right; border: 1px solid black; background-color: {{ isset($ardayData['total']['percentage']) ? (round($ardayData['total']['percentage']) < 50 ? 'red' : ($ardayData['total']['percentage'] > 90 ? 'limegreen' : 'yellow')) : '' }}">
                                    {{ round($ardayData['total']['percentage'], 2) . '%' }}</td>
                            </tr>
                        @endif
                    @endforeach
                    <tr>
                        <td
                            style="padding-left:5px; height:30px; border: 1px solid black; background-color:lightsteelblue; font-weight: 600;">
                            AVERAGE</td>
                        <td
                            style="padding-right:5px; height:30px; border: 1px solid black; text-align: right; background-color:lightsteelblue; font-weight: 600;">
                            {{ round($arday['AVERAGE']['GT']['target'], 2) }}
                        </td>
                        <td
                            style="padding-right:5px; height:30px; border: 1px solid black; text-align: right; background-color:lightsteelblue; font-weight: 600;">
                            {{ round($arday['AVERAGE']['GT']['ardays'], 2) }}
                        </td>
                        <td
                            style="padding-right:5px; height:30px; border: 1px solid black; text-align: right; font-weight: 600; background-color: {{ isset($arday['AVERAGE']['GT']['percentage']) ? (round($arday['AVERAGE']['GT']['percentage']) < 50 ? 'red' : ($arday['AVERAGE']['GT']['percentage'] > 90 ? 'limegreen' : 'yellow')) : '' }}">
                            {{ round($arday['AVERAGE']['GT']['percentage'], 2) . '%' }}
                        </td>
                        <td
                            style="padding-right:5px; height:30px; border: 1px solid black; text-align: right; background-color:lightsteelblue; font-weight: 600;">
                            {{ round($arday['AVERAGE']['MT']['target'], 2) }}
                        </td>
                        <td
                            style="padding-right:5px; height:30px; border: 1px solid black; text-align: right; background-color:lightsteelblue; font-weight: 600;">
                            {{ round($arday['AVERAGE']['MT']['ardays'], 2) }}
                        </td>
                        <td
                            style="padding-right:5px; height:30px; border: 1px solid black; text-align: right; font-weight: 600; background-color: {{ isset($arday['AVERAGE']['MT']['percentage']) ? (round($arday['AVERAGE']['MT']['percentage']) < 50 ? 'red' : ($arday['AVERAGE']['MT']['percentage'] > 90 ? 'limegreen' : 'yellow')) : '' }}">
                            {{ round($arday['AVERAGE']['MT']['percentage'], 2) . '%' }}
                        </td>
                        <td
                            style="padding-right:5px; height:30px; border: 1px solid black; text-align: right; background-color:lightsteelblue; font-weight: 600;">
                            {{ round($arday['AVERAGE']['total']['target'], 2) }}
                        </td>
                        <td
                            style="padding-right:5px; height:30px; border: 1px solid black; border: 1px solid black; text-align: right; background-color:lightsteelblue; font-weight: 600;">
                            {{ round($arday['AVERAGE']['total']['ardays'], 2) }}
                        </td>
                        <td
                            style="padding-right:5px; height:30px; border: 1px solid black; text-align: right; font-weight: 600; background-color: {{ isset($ardayData['total']['percentage']) ? (round($ardayData['total']['percentage']) < 50 ? 'red' : ($ardayData['total']['percentage'] > 90 ? 'limegreen' : 'yellow')) : '' }}">
                            {{ round($arday['AVERAGE']['total']['percentage'], 2) . '%' }}</td>
                    </tr>
                @endif
            @endforeach
            <tr>
                <td colspan="2"
                    style="height:40px; border: 1px solid black; text-align: center; background-color:lightpink; font-weight: 600;">
                    AVERAGE TOTAL
                </td>
                <td
                    style="height:40px; border: 1px solid black; text-align: right; background-color:lightpink; font-weight: 600;">
                    {{ round($ardays['AVERAGE TOTAL']['GT']['target'], 2) }}
                </td>
                <td
                    style="height:40px; border: 1px solid black; text-align: right; background-color:lightpink; font-weight: 600;">
                    {{ round($ardays['AVERAGE TOTAL']['GT']['ardays'], 2) }}
                </td>
                <td
                    style="height:40px; border: 1px solid black; text-align: right; font-weight: 600; background-color: {{ isset($ardays['AVERAGE TOTAL']['GT']['percentage']) ? (round($ardays['AVERAGE TOTAL']['GT']['percentage']) < 50 ? 'red' : ($ardays['AVERAGE TOTAL']['GT']['percentage'] > 90 ? 'limegreen' : 'yellow')) : '' }}">
                    {{ round($ardays['AVERAGE TOTAL']['GT']['percentage'], 2) . '%' }}
                </td>
                <td
                    style="height:40px; border: 1px solid black; text-align: right; background-color:lightpink; font-weight: 600;">
                    {{ round($ardays['AVERAGE TOTAL']['MT']['target'], 2) }}
                </td>
                <td
                    style="height:40px; border: 1px solid black; text-align: right; background-color:lightpink; font-weight: 600;">
                    {{ round($ardays['AVERAGE TOTAL']['MT']['ardays'], 2) }}
                </td>
                <td
                    style="height:40px; border: 1px solid black; text-align: right; font-weight: 600; background-color: {{ isset($ardays['AVERAGE TOTAL']['MT']['percentage']) ? (round($ardays['AVERAGE TOTAL']['MT']['percentage']) < 50 ? 'red' : ($ardays['AVERAGE TOTAL']['MT']['percentage'] > 90 ? 'limegreen' : 'yellow')) : '' }}">
                    {{ round($ardays['AVERAGE TOTAL']['MT']['percentage'], 2) . '%' }}
                </td>
                <td
                    style="height:40px; border: 1px solid black; text-align: right; background-color:lightpink; font-weight: 600;">
                    {{ round($ardays['AVERAGE TOTAL']['total']['target'], 2) }}
                </td>
                <td
                    style="height:40px; border: 1px solid black; text-align: right; background-color:lightpink; font-weight: 600;">
                    {{ round($ardays['AVERAGE TOTAL']['total']['ardays'], 2) }}
                </td>
                <td
                    style="height:40px; border: 1px solid black; text-align: right; font-weight: 600; background-color: {{ isset($ardays['AVERAGE TOTAL']['total']['percentage']) ? (round($ardays['AVERAGE TOTAL']['total']['percentage']) < 50 ? 'red' : ($ardays['AVERAGE TOTAL']['total']['percentage'] > 90 ? 'limegreen' : 'yellow')) : '' }}">
                    {{ round($ardays['AVERAGE TOTAL']['total']['percentage'], 2) . '%' }}</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
