@extends('layout.default')

@section('title', __('app.assets.pages.create'))

@section('content')

<x-alerts.alert condition="warning" />

<div class="card card-custom">
	<div class="card-header flex-wrap border-0 pt-6 pb-0">
		<div class="card-title">
			<h3>
				{{ __('app.assets.pages.create') }}
				<span class="d-block text-muted pt-2 font-size-sm">Sorting & pagination remote datasource</span>
			</h3>
		</div>
	</div>
	<div class="card-body">
		<form action="{{ route('itcsa.assets.store') }}" method="post" enctype="multipart/form-data">
			@csrf
			<!-- Select Category -->
			<div class="form-group">
				<label for="">{{ __('app.assets.category_id') }}</label>
				<span class="text-danger"> * </span>
				<select name="category_id" class="form-control select2 @error('category_id') is-invalid @enderror">
					<option selected disabled value="">{{ __('app.assets.placeholder.category_id') }}</option>
					@foreach ($assetCategories as $category)
					<option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
					@endforeach
				</select>
				@error('category_id')
				<div class="invalid-feedback">
					{{ $message }}
				</div>
				@enderror
			</div>

			<!-- Merek HP -->
			<x-forms.input name="brand" trans="assets" :required="true" />

			<!-- IMEI / Serial Number -->
			<x-forms.input name="serial_number" trans="assets" :required="true" />

			<!-- Tanggal Pembelian -->
			<div class="form-group">
				<label class="">{{ __('app.assets.purchase_date') }}</label>
				<span class="text-danger"> * </span>
				<div class="input-group date">
					<input type="text" name="purchase_date" class="form-control @error('purchase_date') is-invalid @enderror"
						readonly value="{{ old('purchase_date') }}" id="kt_datepicker_3" />
					<div class="input-group-append">
						<span class="input-group-text">
							<i class="la la-calendar"></i>
						</span>
					</div>
					@error('purchase_date')
					<div class="invalid-feedback">
						{{ $message }}
					</div>
					@enderror
				</div>
				<span class="form-text text-muted">Enable clear and today helper buttons</span>
			</div>

			<!-- Nama Peminjam -->
			<x-forms.input name="name" trans="assets" :required="true" />

			<!-- Divisi -->
			<x-forms.select :items="$divisions" name="division_id" trans="assets" :required="true" />

			<!-- Cabang -->
			<div class="form-group">
				<label for="">{{ __('app.assets.branch_id') }}</label>
				<span class="text-danger"> * </span>
				<select name="branch_id" id="" class="form-control select2 @error('branch_id') is-invalid @enderror">
					<option selected disabled value="">{{ __('app.assets.placeholder.branch_id') }}</option>
					@foreach ($branches as $branch)
					<option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->Branch }} - {{ $branch->BranchName }}</option>
					@endforeach
				</select>
				@error('branch_id')
				<div class="invalid-feedback">
					{{ $message }}
				</div>
				@enderror
			</div>

			<!-- Tanggal Pinjam -->
			<div class="form-group">
				<label class="">{{ __('app.assets.lend_date') }}</label>
				<span class="text-danger"> * </span>
				<div class="input-group date">
					<input type="text" name="lend_date" class="form-control @error('lend_date') is-invalid @enderror"
						readonly value="{{ old('lend_date') }}" id="kt_datepicker_3" />
					<div class="input-group-append">
						<span class="input-group-text">
							<i class="la la-calendar"></i>
						</span>
					</div>
					@error('lend_date')
					<div class="invalid-feedback">
						{{ $message }}
					</div>
					@enderror
				</div>
				<span class="form-text text-muted">Enable clear and today helper buttons</span>
			</div>

			<!-- Description -->
			<div class="form-group">
				<label for="">{{ __('app.assets.description') }}</label>
				<textarea name="description" id="" cols="30" rows="3" class="form-control">{{ old('description') }}</textarea>
			</div>

			<!-- Submit -->
			<x-buttons.submit />

			<!-- Back -->
			<x-buttons.back routeName="itcsa.assets.index" />

		</form>
	</div>
</div>
@endsection

@section('scripts')
<!-- Datepicker -->
<script>
	var KTBootstrapDatepicker = function () {

		var arrows;
		if (KTUtil.isRTL()) {
			arrows = {
				leftArrow: '<i class="la la-angle-right"></i>',
				rightArrow: '<i class="la la-angle-left"></i>'
			}
		} else {
			arrows = {
				leftArrow: '<i class="la la-angle-left"></i>',
				rightArrow: '<i class="la la-angle-right"></i>'
			}
		}

		// Private functions
		var demos = function () {
			// enable clear button
			$('#kt_datepicker_3, #kt_datepicker_3_validate').datepicker({
				rtl: KTUtil.isRTL(),
				todayBtn: "linked",
				clearBtn: true,
				todayHighlight: true,
				templates: arrows
			});
		}

		return {
			// public functions
			init: function () {
				demos();
			}
		};
	}();

	jQuery(document).ready(function () {
		KTBootstrapDatepicker.init();
	});

</script>
@endsection
