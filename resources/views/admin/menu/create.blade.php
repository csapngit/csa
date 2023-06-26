{{-- Extends layout --}}
@extends('layout.default')

@section('styles')
@endsection
{{-- Content --}}
@section('content')
    <div class="card card-custom">
        <div class="card-header">
            <h3 class="card-title">
                Create New Menu
            </h3>
        </div>
        <!--begin::Form-->
        {!! Form::open(['route' => ['menu', isset($edit) ? 'method=update&id=' . $edit->id : 'method=save'], 'id' => 'myForm']) !!}
            <div class="card-body">
                <div class="form-group row">
                    <label for="example-search-input" class="col-2 col-form-label">Title</label>
                    <div class="col-10">
                        {!! Form::text('title', isset($edit) ? $edit->title : old('title'), ['id' => 'title', 'class' => 'form-control'] ) !!}
                    </div>
                </div>
                <div class="form-group row">
                    {!! Form::label('page','Page', ['class' => 'col-2 col-form-label']) !!}
                    <div class="col-10">
                        {!! Form::text('page', isset($edit) ? $edit->penerima : old('penerima'), ['id' => 'page', 'class' => 'form-control'] ) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <label  class="col-2 col-form-label">Icon</label>
                    <div class="col-4">
                        <select class="form-control select2" id="icon" name="icon">
                            <option label="Label"></option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label  class="col-2 col-form-label">Header</label>
                    <div class="col-4">
                        <select class="form-control select2" id="header" name="header">
                            <option label="Label"></option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    {!! Form::label('bullet','Bullet', ['class' => 'col-2 col-form-label']) !!}
                    <div class="col-10 col-form-label">
                        <div class="radio-inline">
                            <label class="radio radio-success">
                                <input type="radio" name="bullet" value="1" checked="checked" />
                                <span></span>
                                Ya
                            </label>
                            <label class="radio radio-danger">
                                <input type="radio" name="bullet" value="0"/>
                                <span></span>
                                Tidak
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    {!! Form::label('root','Root', ['class' => 'col-2 col-form-label']) !!}
                    <div class="col-10 col-form-label">
                        <div class="radio-inline">
                            <label class="radio radio-success">
                                <input type="radio" name="root" value="1" checked="checked" />
                                <span></span>
                                Ya
                            </label>
                            <label class="radio radio-danger">
                                <input type="radio" name="root" value="0"/>
                                <span></span>
                                Tidak
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    {!! Form::label('newtab','New Tab', ['class' => 'col-2 col-form-label']) !!}
                    <div class="col-10 col-form-label">
                        <div class="radio-inline">
                            <label class="radio radio-success">
                                <input type="radio" name="newtab" value="1" />
                                <span></span>
                                Ya
                            </label>
                            <label class="radio radio-danger">
                                <input type="radio" name="newtab" value="0" checked="checked" />
                                <span></span>
                                Tidak
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-2">
                    </div>
                    <div class="col-10">
                        <button type="submit" class="btn btn-success mr-2">Submit</button>
                        <button type="reset" class="btn btn-secondary">Cancel</button>
                    </div>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
@endsection

{{-- Scripts Section --}}
@section('scripts')
<script>
    $(function(){
        $('#icon').select2({
            allowClear: true,
            placeholder: 'masukan nama icon',
            ajax: {
                dataType: 'json',
                url: '/api/icons',
                delay: 800,
                data: function(params) {
                    return {
                        search: params.term
                    }
                },
                processResults: function (data, page) {
                    return {
                        results: data
                    };
                }
            }
        });
        $('#header').select2({
            allowClear: true,
            placeholder: 'masukan nama header',
            ajax: {
                dataType: 'json',
                url: '/api/menu/headers',
                delay: 800,
                data: function(params) {
                    return {
                        search: params.term
                    }
                },
                processResults: function (data, page) {
                    return {
                        results: data
                    };
                }
            }
        });
    });

    // Class definition
    var KTFormControls = function () {
        // Private functions
        var _initDemo1 = function () {
            FormValidation.formValidation(
                    document.getElementById('myForm'),
                    {
                        fields: {
                            title: {
                                validators: {
                                    notEmpty: {
                                        message: 'Title is required'
                                    },
                                }
                            }
                        },

                        plugins: { //Learn more: https://formvalidation.io/guide/plugins
                            trigger: new FormValidation.plugins.Trigger(),
                            // Bootstrap Framework Integration
                            bootstrap: new FormValidation.plugins.Bootstrap(),
                            // Validate fields when clicking the Submit button
                            submitButton: new FormValidation.plugins.SubmitButton(),
                            // Submit the form when all fields are valid
                            defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
                        }
                    }
            );
        };

        return {
            // public functions
            init: function() {
                _initDemo1();
            }
        };
    }();

    jQuery(document).ready(function() {
        KTFormControls.init();
    });
</script>


@endsection
