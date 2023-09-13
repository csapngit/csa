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
                    <table>
                        <thead>
                            <tr>
                                <th rowspan="2">Area</th>
                                <th rowspan="2">Cabang</th>
                                <th colspan="3">GT</th>
                                <th colspan="3">MT</th>
                            </tr>
                            <tr>
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
                                    <td rowspan="{{ $branch_total + 1 }}">
                                        {{ $area }}</td>
                                </tr>

                                @foreach ($arday as $branch => $ardayData)
                                    <tr>
                                        <td>{{ $branch }}</td>
                                        <td>{{ $ardayData['GT']['target'] ?? '' }}</td>
                                        <td>{{ $ardayData['GT']['ardays'] ?? '' }}</td>
                                        <td>{{ $ardayData['GT']['percentage'] ?? '' }}</td>
                                        <td>{{ $ardayData['MT']['target'] ?? '' }}</td>
                                        <td>{{ $ardayData['MT']['ardays'] ?? '' }}</td>
                                        <td>{{ $ardayData['MT']['percentage'] ?? '' }}</td>
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
