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
                <th rowspan="2" style="width:4%; height:40px; vertical-align: middle; border: 1px solid black;">Area
                </th>
                <th rowspan="2" style="width:15% height:40px; vertical-align: middle; border: 1px solid black;">
                    Cabang
                </th>
                <th colspan="3" style="width:27%; height:40px; border: 1px solid black;">GT</th>
                <th colspan="3" style="width:27%; height:40px; border: 1px solid black;">MT</th>
                <th colspan="3" style="width:27%; height:40px; border: 1px solid black;">Total</th>
            </tr>
            <tr>
                <th style="width:9%; height:40px; border: 1px solid black;">Target</th>
                <th style="width:9%; height:40px; border: 1px solid black;">AR Day</th>
                <th style="width:9%; height:40px; border: 1px solid black;">Percentage</th>
                <th style="width:9%; height:40px; border: 1px solid black;">Target</th>
                <th style="width:9%; height:40px; border: 1px solid black;">AR Day</th>
                <th style="width:9%; height:40px; border: 1px solid black;">Percentage</th>
                <th style="width:9%; height:40px; border: 1px solid black;">Target</th>
                <th style="width:9%; height:40px; border: 1px solid black;">AR Day</th>
                <th style="width:9%; height:40px; border: 1px solid black;">Percentage</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ardays as $area => $arday)
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
                    <tr>
                        <td style="padding-left:5px; height:30px; border: 1px solid black;">{{ $branch }}</td>
                        <td style="padding-right:5px; height:30px; text-align: right; border: 1px solid black;">
                            {{ $ardayData['GT']['target'] ?? '' }}
                        </td>
                        <td style="padding-right:5px; height:30px; text-align: right; border: 1px solid black;">
                            {{ isset($ardayData['GT']['ardays']) ? round($ardayData['GT']['ardays'], 2) : '' }}
                        </td>
                        <td style="padding-right:5px; height:30px; text-align: right; border: 1px solid black;">
                            {{ isset($ardayData['GT']['percentage']) ? round($ardayData['GT']['percentage'], 2) . '%' : '' }}
                        </td>
                        <td style="padding-right:5px; height:30px; text-align: right; border: 1px solid black;">
                            {{ $ardayData['MT']['target'] ?? '' }}
                        </td>
                        <td style="padding-right:5px; height:30px; text-align: right; border: 1px solid black;">
                            {{ isset($ardayData['MT']['ardays']) ? round($ardayData['MT']['ardays'], 2) : '' }}
                        </td>
                        <td style="padding-right:5px; height:30px; text-align: right; border: 1px solid black;">
                            {{ isset($ardayData['MT']['percentage']) ? round($ardayData['MT']['percentage'], 2) . '%' : '' }}
                        </td>
                        <td style="padding-right:5px; height:30px; text-align: right; border: 1px solid black;">
                            {{ round($ardayData['total']['target'], 2) }}</td>
                        <td style="padding-right:5px;height:30px; text-align: right; border: 1px solid black;">
                            {{ round($ardayData['total']['ardays'], 2) }}
                        </td>
                        <td style="padding-right:5px; height:30px; text-align: right; border: 1px solid black;">
                            {{ round($ardayData['total']['percentage'], 2) . '%' }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>

</html>
