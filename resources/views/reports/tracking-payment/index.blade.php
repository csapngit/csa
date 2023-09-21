@extends('layout.default')

@section('title', 'Tracking Payment')

@section('styles')

    <style>
        .tracking {
            width: 130%;
        }
    </style>

@endsection

@section('content')

    <div class="card card-custom d-inline-flex">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3>
                    Tracking Payment
                    <span class="d-block text-muted pt-2 font-size-sm">Sorting & pagination remote datasource</span>
                </h3>
            </div>
        </div>
        <div class="card-body">
            @include('mails.layouts.trackingpayment.header-timegone')
            <br />
            <div>
                @include('reports.tracking-payment.layouts.gt')
                {{-- @include('reports.tracking-payment.layouts.mt')
                    @include('reports.tracking-payment.layouts.total') --}}
            </div>
        </div>
    </div>
@endsection
