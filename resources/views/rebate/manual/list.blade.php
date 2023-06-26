{{-- Extends layout --}}
@extends('layout.default')

@section('styles')
@endsection
{{-- Content --}}
@section('content')
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">
                    Remote Datasource
                    <span class="d-block text-muted pt-2 font-size-sm">Sorting & pagination remote datasource</span>
                </h3>
            </div>
        </div>
        <div class="card-body">
            <!--begin: Search Form-->
            <!--begin::Search Form-->
            <div class="mb-7">
                <div class="row align-items-center">
                    <div class="col-lg-9 col-xl-8">
                        <div class="row align-items-center">
                            <div class="col-md-3 my-2 my-md-0">
                                <div class="input-icon">
                                    <input type="text" class="form-control" placeholder="Search..."
                                        id="kt_datatable_search_query" />
                                    <span><i class="flaticon2-search-1 text-muted"></i></span>
                                </div>
                            </div>

                            <div class="col-md-3 my-2 my-md-0">
                                <div class="d-flex align-items-center">
                                    <label class="mr-3 mb-0 d-none d-md-block">Status:</label>
                                    <select class="form-control" id="kt_datatable_search_status">
                                        <option value="">All</option>
                                        <option value="A">Aktif</option>
                                        <option value="I">Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable"></div>
            @if (Session::has('status'))
                {!! Form::hidden('status', Session::get('status'), ['id' => 'status']) !!}
                {!! Form::hidden('pesan', Session::get('pesan'), ['id' => 'pesan']) !!}
            @else
                {!! Form::hidden('status', null, ['id' => 'status']) !!}
                {!! Form::hidden('pesan', null, ['id' => 'pesan']) !!}
            @endif
            {!! Form::hidden('userid', Auth::user()->id, ['id' => 'userid']) !!}
        </div>
        <div class="card-footer text-right">
            <div class="row">
                <div class="col-12">
                    <a href="{{ route('rebate.create') }}"><button class="btn btn-sm btn-success">Entri
                            Potongan</button></a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/rebate/numeral/numeral.min.js') }}"></script>
    <script src="{{ asset('js/rebate/manual/list.js') }}"></script>
@endsection
