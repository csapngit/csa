@extends('layout.default')

@section('styles')
{{-- <style src="{{ asset('js/rebate/budget/mapping-budget.css') }}"></style> --}}
@endsection
@section('content')
    <div class="card card-custom">
        <div class="card-header">
            <h3 class="card-title">
                Mapping Budget Potongan Manual
            </h3>
        </div>
        {!! Form::open([
            'route' => ['mapping-budget', isset($edit) ? 'method=update&id=' . $edit->id : 'method=save'],
            'id' => 'myForm',
            'class' => 'form',
            'files' => true,
        ]) !!}
        <div class="card-body" id="kt_blockui_card">
            <div class="form-group row">
                <div class="col-lg-6">
                    {!! Form::label('nomor', 'No. Pengajuan') !!}
                    <select class="form-control select2" name="nopengajuan" id="nopengajuan">
                        <option label="Label"></option>
                    </select>
                </div>
                <div class="col-lg-6">
                    {!! Form::label('nokwitansi', 'No. Kwitansi') !!}
                    {!! Form::text('nokwitansi', isset($edit) ? $edit->nokwitansi : old('nokwitansi'), [
                        'id' => 'nokwitansi',
                        'class' => 'form-control',
                        'disabled',
                    ]) !!}
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-6">
                    {!! Form::label('custid', 'Customer') !!}
                    {!! Form::text('custid', isset($edit) ? $edit->nomor : old('nomor'), [
                        'id' => 'custid',
                        'class' => 'form-control',
                        'disabled',
                    ]) !!}
                </div>
                <div class="col-lg-6">
                    {!! Form::label('jenispotongan', 'Jenis Potongan') !!}
                    {!! Form::text('jenispotongan', isset($edit) ? $edit->nokwitansi : old('nokwitansi'), [
                        'id' => 'jenispotongan',
                        'class' => 'form-control',
                        'disabled',
                    ]) !!}
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-6">
                    {!! Form::label('catatan', 'Catatan') !!}
                    {!! Form::text('catatan', isset($edit) ? $edit->catatan : old('catatan'), [
                        'id' => 'catatan',
                        'class' => 'form-control',
                        'disabled',
                    ]) !!}
                </div>
                <div class="col-lg-6">
                    {!! Form::label('total', 'Total Potongan') !!}
                    {!! Form::text('total', isset($edit) ? $edit->total : old('total'), [
                        'id' => 'total',
                        'class' => 'form-control',
                        'disabled',
                    ]) !!}
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
                                        <th class="text-center">SKU</th>
                                        <th class="text-center col-sm-2">Amount</th>
                                        <th class="text-center">Budget</th>
                                    </tr>
                                </thead>
                                <tbody id="line"></tbody>
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
                    <a href="{{ url()->previous() }}" class="btn btn-danger">Batal</a>
                </div>
            </div>
        </div>


        <div class="modal fade" id="frmICG" data-backdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="staticBackdrop" aria-hidden="true">
            <div class="modal-dialog  modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Table ICG</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered table-hover" id="tblICG">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Category</th>
                                    <th>SubCategory</th>
                                    <th>IMCode</th>
                                    <th>SKU</th>
                                    <th>Lotsell</th>
                                    <th>Channel</th>
                                    <th>Remarks</th>
                                    <th>Descr</th>
                                    <th>FundName</th>
                                    <th>PopCode</th>
                                    <th>SID</th>
                                    <th>IO</th>
                                    <th>CE</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="icgline">
                              @foreach ($icg as $key => $value)
                                <tr>
                                  <td>{{ ($key+1) }}</td>
                                  <td>{{ $value->Category }}</td>
                                  <td>{{ $value->SubCategory }}</td>
                                  <td>{{ $value->IMCode }}</td>
                                  <td>{{ $value->SKU }}</td>
                                  <td>{{ $value->Lotsell }}</td>
                                  <td>{{ $value->Channel }}</td>
                                  <td>{{ $value->Remarks }}</td>
                                  <td>{{ $value->Descr }}</td>
                                  <td>{{ $value->FundName }}</td>
                                  <td>{{ $value->PopCode }}</td>
                                  <td>{{ $value->SID }}</td>
                                  <td>{{ $value->IO }}</td>
                                  <td>{{ $value->CE }}</td>
                                  <td><button id="btn-icg-{{ $value->id }}" type="button" onclick="btnICG(this.id)">Pilih</button></td>
                                </tr>
                              @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold"
                            data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::hidden('btnTemp', null, ['id' => 'btnTemp']) !!}
        {!! Form::hidden('icgtemp', null, ['id' => 'icgtemp']) !!}
        {!! Form::hidden('userid', Auth::user()->id, ['id' => 'userid']) !!}
        {!! Form::close() !!}
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/rebate/numeral/numeral.min.js') }}"></script>
    <script src="{{ asset('js/rebate/budget/mapping-budget.js') }}"></script>
@endsection
