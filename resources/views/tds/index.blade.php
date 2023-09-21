@extends('layout.default')

@section('title', 'API')

@section('content')
    <div class="row justify-content-center">
        <div class="col-11  card">
            <div class="card-header border-0 pb-0">
                <div class="card-title">
                    <h3>Post API SFA</h3>
                    <span class="d-block text-muted pt-2">Post API untuk data di SFA</span>
                </div>
            </div>
            <div class="card-body pt-0">
                <form action="#" method="GET" id="form_tds">
                    @csrf

                    <div class="form-group">
                        <div class="row">
                            <div class="col-1">
                                <label for="" class="col col-form-label">API</label>
                            </div>
                            <div class="col">
                                <select name="" id="api_select" class="form-control select2" style="width: 100%">
                                    <option selected disabled value="">Select Api</option>
                                    @foreach ($apis as $api)
                                        <option value="{{ $api->route }}">{{ $api->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn btn-primary" formtarget="_blank">POST</button>
                </form>
            </div>
        </div>
    </div>
    <div class="row justify-content-around mt-6">
        <div class="col-5 card">
            <div class="card-header border-0 pb-0">
                <div class="card-title">
                    <h3>Hit Order SFA</h3>
                    <span class="d-block text-muted pt-2">Tarik data Order dari SFA yang akan masuk ke table tds_orderdata
                        di 24.</span>
                </div>
            </div>
            <div class="card-body pt-0">
                <a href="{{ route('tds.hitorder') }}" class="btn btn-primary">Hit Data Order</a>
            </div>
        </div>
        <div class="col-5 card">
            <div class="card-header border-0 pb-0">
                <div class="card-title">
                    <h3>CSV Order SFA</h3>
                    <span class="d-block text-muted pt-2">Buat data CSV dari order SFA yang telah dihit dan masuk ke dalam
                        tds_orderdata di 24</span>
                </div>
            </div>
            <div class="card-body pt-0">
                <a href="{{ route('tds.csvorder') }}" class="btn btn-success">Make CSV</a>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-6">
        <div class="col-11 card">
            <div class="card-header border-0 pb-0">
                <div class="card-title">
                    <h3>CSV Manual</h3>
                    <span class="d-block text-muted pt-2">Gunakan ini jika ingin membuat ulang CSV.</span>
                    <span class="d-block text-muted pt-2">Misal saat ada error saat sync CSV atau data telah dihit di web
                        TDS
                        juga sudah masuk di 24 namun tidak ada di CSV sebelumnya.</span>
                </div>
            </div>
            <div class="card-body pt-0">
                <form action="{{ route('tds.csvmanual') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-2">
                            <label for="" class="col col-form-label">List Order Number</label>
                        </div>
                        <div class="col">
                            <select class="form-control orderno col" name="orderno[]" multiple="multiple">
                                @foreach ($ordernumbers as $ordernumber)
                                    <option value="{{ $ordernumber->OrderNo }}">{{ $ordernumber->OrderNo }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success mt-3" formtarget="_blank">Make CSV Manually</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#api_select').on('change', function() {
                var route = this.value;
                $('#form_tds').attr('action', route);
                console.log($('#form_tds').attr('action'));
            });

            $('.orderno').select2();
        });
    </script>
@endsection
