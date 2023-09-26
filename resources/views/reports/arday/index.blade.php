@extends('layout.default')

@section('title', 'AR Days')

@section('styles')

    <style>
        /* .ardays {
                                                                                                                                                                                                                                                                                            width: 100%;
                                                                                                                                                                                                                                                                                        } */
    </style>

@endsection

@section('content')

    <div style="width: 100%">
        <div class="card card-custom">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3>
                        AR Days
                        <span class="d-block text-muted pt-2 font-size-sm">Sorting & pagination remote datasource</span>
                    </h3>
                </div>
            </div>
            <div class="card-body">
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
                <div style="display: flex">
                    <table class="table table-bordered">
                        <thead style="text-align: center;">
                            <tr>
                                <th rowspan="2" style="vertical-align: middle; background-color:aliceblue;">Area</th>
                                <th rowspan="2" style="vertical-align: middle; background-color:aliceblue;">Cabang</th>
                                <th colspan="3" style="background-color:plum;">GT</th>
                                <th colspan="3" style="background-color:cornsilk;">MT</th>
                                <th colspan="3" style="background-color:moccasin;">Total</th>
                            </tr>
                            <tr>
                                <th style="background-color:plum;">Target</th>
                                <th style="background-color:plum;">AR Day</th>
                                <th style="background-color:plum;">Percentage</th>
                                <th style="background-color:cornsilk;">Target</th>
                                <th style="background-color:cornsilk;">AR Day</th>
                                <th style="background-color:cornsilk;">Percentage</th>
                                <th style="background-color:moccasin;">Target</th>
                                <th style="background-color:moccasin;">AR Day</th>
                                <th style="background-color:moccasin;">Percentage</th>
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
                                            style="text-align: center; vertical-align: middle;">
                                            {{ $area }}</td>
                                    </tr>

                                    @foreach ($arday as $branch => $ardayData)
                                        @if ($branch != 'AVERAGE')
                                            <tr>
                                                <td>{{ $branch }}</td>
                                                <td style="text-align: right">{{ $ardayData['GT']['target'] ?? '' }}</td>
                                                <td style="text-align: right">
                                                    {{ isset($ardayData['GT']['ardays']) ? round($ardayData['GT']['ardays'], 2) : '' }}
                                                </td>
                                                <td
                                                    style="text-align: right; background-color: {{ isset($ardayData['GT']['percentage']) ? (round($ardayData['GT']['percentage']) < 50 ? 'red' : ($ardayData['GT']['percentage'] > 90 ? 'limegreen' : 'yellow')) : '' }}">
                                                    {{ isset($ardayData['GT']['percentage']) ? round($ardayData['GT']['percentage'], 2) . '%' : '' }}
                                                </td>
                                                <td style="text-align: right">{{ $ardayData['MT']['target'] ?? '' }}</td>
                                                <td style="text-align: right">
                                                    {{ isset($ardayData['MT']['ardays']) ? round($ardayData['MT']['ardays'], 2) : '' }}
                                                </td>
                                                <td
                                                    style="text-align: right; background-color: {{ isset($ardayData['MT']['percentage']) ? (round($ardayData['MT']['percentage']) < 50 ? 'red' : ($ardayData['MT']['percentage'] > 90 ? 'limegreen' : 'yellow')) : '' }}">
                                                    {{ isset($ardayData['MT']['percentage']) ? round($ardayData['MT']['percentage'], 2) . '%' : '' }}
                                                </td>
                                                <td style="text-align: right">{{ round($ardayData['total']['target'], 2) }}
                                                </td>
                                                <td style="text-align: right">{{ round($ardayData['total']['ardays'], 2) }}
                                                </td>
                                                <td
                                                    style="text-align: right; background-color: {{ isset($ardayData['total']['percentage']) ? (round($ardayData['total']['percentage']) < 50 ? 'red' : ($ardayData['total']['percentage'] > 90 ? 'limegreen' : 'yellow')) : '' }}">
                                                    {{ round($ardayData['total']['percentage'], 2) . '%' }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    <tr>
                                        <td style="background-color:lightsteelblue; font-weight: 600;">AVERAGE</td>
                                        <td style="text-align: right; background-color:lightsteelblue; font-weight: 600;">
                                            {{ round($arday['AVERAGE']['GT']['target'], 2) }}
                                        </td>
                                        <td style="text-align: right; background-color:lightsteelblue; font-weight: 600;">
                                            {{ round($arday['AVERAGE']['GT']['ardays'], 2) }}
                                        </td>
                                        <td
                                            style="text-align: right; font-weight: 600;  background-color: {{ isset($arday['AVERAGE']['GT']['percentage']) ? (round($arday['AVERAGE']['GT']['percentage']) < 50 ? 'red' : ($arday['AVERAGE']['GT']['percentage'] > 90 ? 'limegreen' : 'yellow')) : '' }}">
                                            {{ round($arday['AVERAGE']['GT']['percentage'], 2) . '%' }}
                                        </td>
                                        <td style="text-align: right; background-color:lightsteelblue; font-weight: 600;">
                                            {{ round($arday['AVERAGE']['MT']['target'], 2) }}
                                        </td>
                                        <td style="text-align: right; background-color:lightsteelblue; font-weight: 600;">
                                            {{ round($arday['AVERAGE']['MT']['ardays'], 2) }}
                                        </td>
                                        <td
                                            style="text-align: right; font-weight: 600;  background-color: {{ isset($arday['AVERAGE']['MT']['percentage']) ? (round($arday['AVERAGE']['MT']['percentage']) < 50 ? 'red' : ($arday['AVERAGE']['MT']['percentage'] > 90 ? 'limegreen' : 'yellow')) : '' }}">
                                            {{ round($arday['AVERAGE']['MT']['percentage'], 2) . '%' }}
                                        </td>
                                        <td style="text-align: right; background-color:lightsteelblue; font-weight: 600;">
                                            {{ round($arday['AVERAGE']['total']['target'], 2) }}
                                        </td>
                                        <td style="text-align: right; background-color:lightsteelblue; font-weight: 600;">
                                            {{ round($arday['AVERAGE']['total']['ardays'], 2) }}
                                        </td>
                                        <td
                                            style="text-align: right; font-weight: 600;  background-color: {{ isset($ardayData['total']['percentage']) ? (round($ardayData['total']['percentage']) < 50 ? 'red' : ($ardayData['total']['percentage'] > 90 ? 'limegreen' : 'yellow')) : '' }}">
                                            {{ round($arday['AVERAGE']['total']['percentage'], 2) . '%' }}</td>
                                    </tr>
                                @endif
                            @endforeach
                            <tr>
                                <td colspan="2"
                                    style="text-align: center; background-color:lightpink; font-weight: 600;">AVERAGE TOTAL
                                </td>
                                <td style="text-align: right; background-color:lightpink; font-weight: 600;">
                                    {{ round($ardays['AVERAGE TOTAL']['GT']['target'], 2) }}
                                </td>
                                <td style="text-align: right; background-color:lightpink; font-weight: 600;">
                                    {{ round($ardays['AVERAGE TOTAL']['GT']['ardays'], 2) }}
                                </td>
                                <td
                                    style="text-align: right; font-weight: 600; background-color: {{ isset($ardays['AVERAGE TOTAL']['GT']['percentage']) ? (round($ardays['AVERAGE TOTAL']['GT']['percentage']) < 50 ? 'red' : ($ardays['AVERAGE TOTAL']['GT']['percentage'] > 90 ? 'limegreen' : 'yellow')) : '' }}">
                                    {{ round($ardays['AVERAGE TOTAL']['GT']['percentage'], 2) . '%' }}
                                </td>
                                <td style="text-align: right; background-color:lightpink; font-weight: 600;">
                                    {{ round($ardays['AVERAGE TOTAL']['MT']['target'], 2) }}
                                </td>
                                <td style="text-align: right; background-color:lightpink; font-weight: 600;">
                                    {{ round($ardays['AVERAGE TOTAL']['MT']['ardays'], 2) }}
                                </td>
                                <td
                                    style="text-align: right; font-weight: 600;  background-color: {{ isset($ardays['AVERAGE TOTAL']['MT']['percentage']) ? (round($ardays['AVERAGE TOTAL']['MT']['percentage']) < 50 ? 'red' : ($ardays['AVERAGE TOTAL']['MT']['percentage'] > 90 ? 'limegreen' : 'yellow')) : '' }}">
                                    {{ round($ardays['AVERAGE TOTAL']['MT']['percentage'], 2) . '%' }}
                                </td>
                                <td style="text-align: right; background-color:lightpink; font-weight: 600;">
                                    {{ round($ardays['AVERAGE TOTAL']['total']['target'], 2) }}
                                </td>
                                <td style="text-align: right; background-color:lightpink; font-weight: 600;">
                                    {{ round($ardays['AVERAGE TOTAL']['total']['ardays'], 2) }}
                                </td>
                                <td
                                    style="text-align: right; font-weight: 600;  background-color: {{ isset($ardays['AVERAGE TOTAL']['total']['percentage']) ? (round($ardays['AVERAGE TOTAL']['total']['percentage']) < 50 ? 'red' : ($ardays['AVERAGE TOTAL']['total']['percentage'] > 90 ? 'limegreen' : 'yellow')) : '' }}">
                                    {{ round($ardays['AVERAGE TOTAL']['total']['percentage'], 2) . '%' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
