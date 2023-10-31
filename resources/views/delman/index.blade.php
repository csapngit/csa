{{-- Extends layout --}}
@extends('layout.default')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
{{-- Content --}}
@section('content')
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">
                    FJP Delman
                    {{-- <span class="d-block   text-muted pt-2 font-size-sm">Last Sync on 03-09-2021 14:30:00</span> --}}
                </h3>
            </div>
        </div>
        <div class="card-body">
            <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable"></div>
        </div>
    </div>
    {!! Form::hidden('delman', $delman, ['id' => 'delman']) !!}
@endsection

@section('scripts')
    <script src="{{ asset('plugins/custom/numeral/numeral.min.js') }}"></script>
    <script src="{{ asset('js/delman/fjp.js') }}"></script>
@endsection
