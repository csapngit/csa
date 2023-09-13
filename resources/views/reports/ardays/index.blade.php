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
                <div style="display: flex">
                    <table class="table table-bordered">
                        <thead style="text-align: center;">
                            <tr>
                                <th rowspan="2" style="vertical-align: middle;">Area</th>
                                <th rowspan="2" style="vertical-align: middle;">Cabang</th>
                                <th colspan="3">GT</th>
                                <th colspan="3">MT</th>
                                <th colspan="3">Total</th>
                            </tr>
                            <tr>
                                <th>Target</th>
                                <th>ARDay</th>
                                <th>Percentage</th>
                                <th>Target</th>
                                <th>ARDay</th>
                                <th>Percentage</th>
                                <th>Target</th>
                                <th>ARDay</th>
                                <th>Percentage</th>
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
                                        style="text-align: center; vertical-align: middle;">
                                        {{ $area }}</td>
                                </tr>

                                @foreach ($arday as $branch => $ardayData)
                                    <tr>
                                        <td>{{ $branch }}</td>
                                        <td style="text-align: right">{{ $ardayData['GT']['target'] ?? '' }}</td>
                                        <td style="text-align: right">
                                            {{ isset($ardayData['GT']['ardays']) ? round($ardayData['GT']['ardays'], 2) : '' }}
                                        </td>
                                        <td style="text-align: right">
                                            {{ isset($ardayData['GT']['percentage']) ? round($ardayData['GT']['percentage'], 2) . '%' : '' }}
                                        </td>
                                        <td style="text-align: right">{{ $ardayData['MT']['target'] ?? '' }}</td>
                                        <td style="text-align: right">
                                            {{ isset($ardayData['MT']['ardays']) ? round($ardayData['MT']['ardays'], 2) : '' }}
                                        </td>
                                        <td style="text-align: right">
                                            {{ isset($ardayData['MT']['percentage']) ? round($ardayData['MT']['percentage'], 2) . '%' : '' }}
                                        </td>
                                        <td style="text-align: right">{{ round($ardayData['total']['target'], 2) }}</td>
                                        <td style="text-align: right">{{ round($ardayData['total']['ardays'], 2) }}</td>
                                        <td style="text-align: right">
                                            {{ round($ardayData['total']['percentage'], 2) . '%' }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
