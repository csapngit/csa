@extends('layout.default')

@section('title', 'Report Mailer')

@section('content')
    <div class="row justify-content-around mt-6">
        <div class="col-5 card mt-5">
            <div class="card-header border-0 pb-0">
                <div class="card-title">
                    <h3>Send Mail DSR</h3>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="border-bottom mb-4">
                    <a href="{{ route('report.dsr.mail') }}" class="btn btn-primary mb-1" target="_blank">Send DSR All</a>
                    <span class="d-block text-muted pt-2 mb-1">Kirim DSR CSAJ dan CSAS ke semua user dengan module dsr pada
                        table
                        emails di 17.</span>
                </div>
                <div>
                    <a href="{{ route('report.dsr.mailself') }}" class="btn btn-warning mb-1" target="_blank">Send DSR
                        Self</a>
                    <span class="d-block text-muted pt-2 mb-1">Kirim DSR CSAJ dan CSAS ke email yang telah
                        di-hardcode. Gunakan ini untuk testing.</span>
                </div>
            </div>
        </div>
        <div class="col-5 card mt-5">
            <div class="card-header border-0 pb-0">
                <div class="card-title">
                    <h3>Send Mail Report Tracking Payment</h3>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="border-bottom mb-4">
                    <a href="{{ route('report.trackingpayment.mail') }}" class="btn btn-primary mb-1" target="_blank">Send
                        Tracking
                        Payment All</a>
                    <span class="d-block text-muted pt-2 mb-1">Kirim Report Tracking Payment ke semua user dengan module
                        trackingpayment pada
                        table
                        emails di 17.</span>
                </div>
                <div>
                    <a href="{{ route('report.trackingpayment.mailself') }}" class="btn btn-warning mb-1"
                        target="_blank">Send
                        Tracking Payment Self</a>
                    <span class="d-block text-muted pt-2 mb-1">Kirim Report Tracking Payment ke email yang telah
                        di-hardcode. Gunakan ini untuk testing.</span>
                </div>
            </div>
        </div>

        <div class="col-5 card mt-5">
            <div class="card-header border-0 pb-0">
                <div class="card-title">
                    <h3>Send Mail Report AR Days</h3>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="border-bottom mb-4">
                    <a href="{{ route('report.arday.mail') }}" class="btn btn-primary mb-1" target="_blank">Send Ar Days
                        All</a>
                    <span class="d-block text-muted pt-2 mb-1">Kirim Report AR Days ke semua user dengan module ardays pada
                        table
                        emails di 17.</span>
                </div>
                <div>
                    <a href="{{ route('report.arday.mailself') }}" class="btn btn-warning mb-1" target="_blank">Send Ar Days
                        Self</a>
                    <span class="d-block text-muted pt-2 mb-1">Kirim Report AR Days ke email yang telah
                        di-hardcode. Gunakan ini untuk testing.</span>
                </div>
            </div>
        </div>
        <div class="col-5 mt-5">
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

        });
    </script>
@endsection
