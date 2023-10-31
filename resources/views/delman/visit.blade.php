@extends('layout.default')

@section('styles')
@endsection
@section('content')
    <div class="card card-custom">
        <div class="card-header card-header-tabs-line nav-tabs-line-3x">
            <div class="card-toolbar">
                <ul class="nav nav-tabs nav-bold nav-tabs-line nav-tabs-line-3x">
                    <li class="nav-item mr-3">
                        <a class="nav-link active" data-toggle="tab" href="#kt_user_edit_tab_1">
                            <span class="nav-icon">
                                <span class="svg-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <path
                                                d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z"
                                                fill="#000000" fill-rule="nonzero" />
                                            <path
                                                d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z"
                                                fill="#000000" opacity="0.3" />
                                        </g>
                                    </svg>
                                </span>
                            </span>
                            <span class="nav-text font-size-lg">Tagging</span>
                        </a>
                    </li>
                    <li class="nav-item mr-3">
                        <a class="nav-link" data-toggle="tab" href="#kt_user_edit_tab_2">
                            <span class="nav-icon">
                                <span class="svg-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <path
                                                d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z"
                                                fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                            <path
                                                d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z"
                                                fill="#000000" fill-rule="nonzero" />
                                        </g>
                                    </svg>
                                </span>
                            </span>
                            <span class="nav-text font-size-lg">Transaksi</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        {!! Form::open([
            'route' => ['delman-routes', 'route=' . $route->id],
            'class' => 'form',
            'id' => 'myForm',
            'files' => true,
            'enctype' => 'multipart/form-data',
        ]) !!}

        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane show active px-7" id="kt_user_edit_tab_1" role="tabpanel">
                    <div class="form-group">
                        {!! Form::label('CardCode', 'Nama Toko', ['class' => 'form-label']) !!}
                        {!! Form::text('CardCode', $route->card_code . ' - ' . $route->card_name, [
                            'class' => 'form-control',
                            'disabled',
                        ]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('address', 'Alamat Toko', ['class' => 'form-label']) !!}
                        {!! Form::text('address', $route->address, ['class' => 'form-control', 'disabled']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('latlong', 'Koordinat Toko', ['class' => 'form-label']) !!}
                        {!! Form::text('latlong', $route->latitude . ' ' . $route->longitude, ['class' => 'form-control', 'disabled']) !!}
                    </div>

                    <div id="myMap" class="gmaps" style="height:300px;"></div>

                    <div class="form-group">
                        {!! Form::label('actual-latlong', 'Koordinat Aktual', ['class' => 'form-label']) !!}
                        {!! Form::text('actual-latlong', null, ['id' => 'Latlong', 'class' => 'form-control', 'disabled']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('actual-latlong', 'Status Pengiriman', ['class' => 'form-label']) !!}
                        <select class="form-control" id="reason" name="reason">
                            @foreach ($reason as $value)
                                <option value="{{ $value->id }}">{{ $value->status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        {!! Form::label('note', 'Catatan Pengiriman', ['class' => 'form-label']) !!}
                        {!! Form::text('note', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {{-- {!! Form::label('storePicture','Foto Toko', ['class' => 'form-label']) !!} --}}
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="storePicture"
                                accept="image/png, image/jpeg, image/gif" capture />
                            <label class="custom-file-label" for="invoicePicture">Foto Toko</label>
                        </div>
                    </div>
                    <div class="form-group">
                        {{-- {!! Form::label('invoicePicture','Foto Invoice', ['class' => 'form-label']) !!} --}}
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="invoicePicture"
                                accept="image/png, image/jpeg, image/gif" capture />
                            <label class="custom-file-label" for="invoicePicture">Foto Invoice</label>
                        </div>
                    </div>


                </div>

                <div class="tab-pane px-7" id="kt_user_edit_tab_2" role="tabpanel">
                    <div id="kt_repeater_1">
                        <div class="form-group row">
                            <div data-repeater-list="" class="col-lg-12">
                                <div data-repeater-item="" class="form-group row">
                                    <div class="col-lg-12">
                                        <div class="input-group">
                                            <select class="form-control select2 skuid" name="sku">
                                                <option label="Label"></option>
                                            </select>
                                            <!-- <input type="text" name="qty" class="form-control col-lg-1" placeholder="Qty" /> -->
                                            {!! Form::text('qty', null, ['id' => 'qty', 'class' => 'form-control col-lg-1']) !!}
                                            <input type="text" class="form-control col-lg-1" placeholder="Price"
                                                disabled />
                                            <a href="javascript:;" data-repeater-delete=""
                                                class="btn font-weight-bold btn-danger btn-icon">
                                                <i class="la la-remove"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12"></div>
                            <div data-repeater-create="" class="btn font-weight-bold btn-primary" id="repeater-button">
                                <i class="la la-plus"></i>Add
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-10">
                    <button type="submit" class="btn btn-success mr-2">Simpan</button>
                </div>
            </div>
        </div>
        {!! Form::hidden('store_latitude', $route->latitude, ['id' => 'store_latitude']) !!}
        {!! Form::hidden('store_longitude', $route->longitude, ['id' => 'store_longitude']) !!}
        {!! Form::hidden('actual_latitude', null, ['id' => 'actual_latitude']) !!}
        {!! Form::hidden('actual_longitude', null, ['id' => 'actual_longitude']) !!}
        {!! Form::hidden('toko', $route->card_name, ['id' => 'toko']) !!}
        {!! Form::close() !!}

    </div>
@endsection

@section('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}"></script>
    <script src="{{ asset('plugins/custom/gmaps/gmaps.js') }}"></script>
    <script src="{{ asset('js/delman/call.js') }}"></script>
@endsection
