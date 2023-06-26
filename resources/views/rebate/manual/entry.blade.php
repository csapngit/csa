@extends('layout.default')

@section('styles')
@endsection
@section('content')
    <div class="card card-custom">
        <div class="card-header">
            <h3 class="card-title">
                Entry Potongan Manual
            </h3>
        </div>
        {!! Form::open([
            'route' => ['rebate', isset($edit) ? 'method=update&id=' . $edit->id : 'method=save'],
            'id' => 'myForm',
            'class' => 'form',
            'files' => true,
        ]) !!}
        <div class="card-body">
            <div class="form-group row">
                <div class="col-lg-6">
                    {!! Form::label('nomor', 'No. Pengajuan') !!}
                    {!! Form::text('nomor', isset($edit) ? $edit->nomor : old('nomor'), [
                        'id' => 'nomor',
                        'class' => 'form-control',
                        'disabled',
                    ]) !!}
                    <span class="form-text text-muted">Generate Otomatis oleh sistem.</span>
                </div>
                <div class="col-lg-6">
                    {!! Form::label('nokwitansi', 'No. Kwitansi') !!}
                    {!! Form::text('nokwitansi', isset($edit) ? $edit->nomorkwitansi : old('nokwitansi'), [
                        'id' => 'nokwitansi',
                        'class' => 'form-control',
                    ]) !!}
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-6">
                    {!! Form::label('custid', 'Customer') !!}
                    <select class="form-control select2" name="custid" id="custid">
                        <option label="Label"></option>
                    </select>
                </div>
                <div class="col-lg-6">
                    {!! Form::label('jenispotongan', 'Jenis Potongan') !!}
                    <select class="form-control" id="jenispotongan" name="jenispotongan">
                        <option {{ isset($edit) ? ($edit->jenispotongan === 'Display' ? 'selected' : '') : '' }}>Display
                        </option>
                        <option {{ isset($edit) ? ($edit->jenispotongan === 'TPR' ? 'selected' : '') : '' }}>TPR</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-6">
                    {!! Form::label('catatan', 'Catatan') !!}
                    {!! Form::text('catatan', isset($edit) ? $edit->catatan : old('catatan'), [
                        'id' => 'catatan',
                        'class' => 'form-control',
                    ]) !!}
                </div>
                <div class="col-lg-6">
                    {!! Form::label('total', 'Total Potongan') !!}
                    {!! Form::text('totaltemp', isset($edit) ? $edit->totaltemp : old('totaltemp'), [
                        'id' => 'totaltemp',
                        'class' => 'form-control',
                    ]) !!}
                    <span class="form-text text-muted">Diisi jika jenis potongan display.</span>
                </div>
            </div>
            <div class="card card-custom">
                <div class="card-header card-header-tabs-line">
                    <div class="card-toolbar">
                        <ul class="nav nav-tabs nav-bold nav-tabs-line">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tab_sku">
                                    <span class="nav-icon"><i class="flaticon2-chat-1"></i></span>
                                    <span class="nav-text">Detail SKU</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tab_sku" role="tabpanel"
                            aria-labelledby="kt_tab_pane_1_4">
                            <table class="table" id="myTable">
                                <thead>
                                    <tr>
                                        <th>SKU</th>
                                        <th>Amount</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="line">
                                    @if (isset($edit))
                                        @foreach ($detail as $key => $value)
                                            <tr id="line-{{ $key + 1 }}">
                                                <td>
                                                    <select class="form-control select2" name="arrSKU[]"
                                                        id="invtid-{{ $key + 1 }}">
                                                        <option label="Label"></option>
                                                    </select>
                                                </td>
                                                <td class="col-lg-2">
                                                    {!! Form::text('arrAmount[]', number_format($value->amount), [
                                                        'id' => 'qty-' . $key + 1,
                                                        'class' => 'form-control',
                                                        'placeholder' => 'Jml. Potongan',
                                                        'onclick' => 'this.select();',
                                                    ]) !!}
                                                </td>
                                                <td class="col-sm-2 text-center">
                                                    <button type="button"
                                                        class="btn btn-sm font-weight-bolder btn-light-primary"
                                                        id="btnAdd-{{ $key + 1 }}"><i
                                                            class="la la-plus"></i>Add</button>
                                                    <button type="button"
                                                        class="btn btn-sm font-weight-bolder btn-light-danger"
                                                        id="btnDelete"><i class="la la-trash-o"></i>Delete</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr id="line-1">
                                            <td>
                                                <select class="form-control select2" name="arrSKU[]" id="invtid-1">
                                                    <option label="Label"></option>
                                                </select>
                                            </td>
                                            <td class="col-lg-2">
                                                {!! Form::text('arrAmount[]', null, [
                                                    'id' => 'qty-1',
                                                    'class' => 'form-control',
                                                    'placeholder' => 'Jml. Potongan',
                                                    'onclick' => 'this.select();',
                                                ]) !!}
                                            </td>
                                            <td class="col-sm-2 text-center">
                                                <button type="button"
                                                    class="btn btn-sm font-weight-bolder btn-light-primary"
                                                    id="btnAdd-1"><i class="la la-plus"></i>Add</button>
                                                <button type="button"
                                                    class="btn btn-sm font-weight-bolder btn-light-danger" id="btnDelete"><i
                                                        class="la la-trash-o"></i>Delete</button>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-right">
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-success mr-2">Simpan</button>
                    <button type="button" class="btn btn-warning mr-2">Finish</button>
                    <a href="{{ url()->previous() }}" class="btn btn-danger">Batal</a>
                </div>
            </div>
        </div>

        {!! Form::hidden('editmode', isset($edit) ? 1 : 0, ['id' => 'editmode']) !!}
        {!! Form::hidden('header', isset($edit) ? $edit->id : 0, ['id' => 'header']) !!}
        {!! Form::hidden('customer', isset($edit) ? $edit->custid : null, ['id' => 'customer']) !!}
        {!! Form::hidden('customername', isset($edit) ? $edit->name : null, ['id' => 'customername']) !!}
        {!! Form::hidden('invtid', isset($edit) ? $edit->area : null, ['id' => 'invtid']) !!}
        {!! Form::hidden('qty', isset($edit) ? $edit->role : null, ['id' => 'qty']) !!}
        {!! Form::hidden('userid', Auth::user()->id, ['id' => 'userid']) !!}
        {!! Form::hidden('total', 0, ['id' => 'total']) !!}
        {!! Form::close() !!}
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/rebate/numeral/numeral.min.js') }}"></script>
    <script src="{{ asset('js/rebate/manual/potongan-manual.js') }}"></script>
@endsection
