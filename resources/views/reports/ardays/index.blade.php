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
                    {{-- @include('reports.tracking-payment.layouts.gt')
                    @include('reports.tracking-payment.layouts.mt')
                    @include('reports.tracking-payment.layouts.total') --}}
                </div>
            </div>
        </div>
    </div>
@endsection
