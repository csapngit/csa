{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
    <div class="card card-custom">
        <div class="card-header">
            <h3 class="card-title">
                Base Controls
            </h3>
            <div class="card-toolbar">
                <div class="example-tools justify-content-center">
                    <span class="example-toggle" data-toggle="tooltip" title="View code"></span>
                    <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
                </div>
            </div>
        </div>
        <!--begin::Form-->
        <form>
            <div class="card-body">
                <div class="form-group">
                    <label>Name <span class="text-danger">*</span></label>
                    <input type="email" class="form-control"  placeholder="Enter email"/>
                    <span class="form-text text-muted">We'll never share your email with anyone else.</span>
                </div>

                <div class="image-input image-input-outline" id="kt_image_1">
                    <div class="image-input-wrapper" style="background-image: url(assets/media/users/100_1.jpg)"></div>

                    <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                        <i class="fa fa-pen icon-sm text-muted"></i>
                        <input type="file" name="profile_avatar" accept=".png, .jpg, .jpeg"/>
                        <input type="hidden" name="profile_avatar_remove"/>
                    </label>

                    <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
		<i class="ki ki-bold-close icon-xs text-muted"></i>
	</span>
                </div>
            </div>

            <div class="card-footer">
                <button type="reset" class="btn btn-primary mr-2">Submit</button>
                <button type="reset" class="btn btn-secondary">Cancel</button>
            </div>
        </form>
        <!--end::Form-->
    </div>
@endsection

{{-- Scripts Section --}}
@section('scripts')
    {{--    <script src="{{ asset('js/pages/widgets.js') }}" type="text/javascript"></script>--}}
@endsection
