{{-- Extends layout --}}
@extends('layout.default')

@section('styles')
@endsection

@section('content')
    <div class="card card-custom">
        <div class="card-header">
            <h3 class="card-title">
                List of Menu
            </h3>
        </div>
        <div class="card-body">
            <div class="mb-7">
                <div class="row align-items-center">
                    <div class="col-lg-9 col-xl-8">
                        <div class="row align-items-center">
                            <div class="col-md-6 my-2 my-md-0">
                                <div class="input-icon">
                                    <input type="text" class="form-control" placeholder="Search..." id="kt_datatable_search_query" />
                                    <span><i class="flaticon2-search-1 text-muted"></i></span>
                                </div>
                            </div>
                            <div class="col-md-3 my-2 my-md-0">
                                <button type="button" class="btn btn-success mr-3" id="btnReload">Reload</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="treeview" class="tree-demo"></div>
        </div>
        <div class="card-footer">
            <div class="row">
                {{-- <div class="col-2"></div>
                <div class="col-10">
                    <button type="submit" class="btn btn-success mr-2">Submit</button>
                    <button type="reset" class="btn btn-secondary">Cancel</button>
                </div> --}}
            </div>
        </div>

    </div>
@endsection

@section('scripts')
<script src="{{ asset('plugins/custom/jstree/jstree.bundle.js') }}"></script>
<script src="{{ asset('js/csapps/admin/menu.js') }}"></script>
@endsection
