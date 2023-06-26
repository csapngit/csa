@extends('layout.default')

@section('title', __('app.assets.pages.edit'))

@section('content')

<x-alerts.alert condition="warning" />

<div class="card card-custom">
	<div class="card-header flex-wrap border-0 pt-6 pb-0">
		<div class="card-title">
			<h3>
				{{ __('app.assets.pages.edit') }}
				<span class="d-block text-muted pt-2 font-size-sm">Sorting & pagination remote datasource</span>
			</h3>
		</div>
	</div>
	<div class="card-body">
		<form action="{{ route('itcsa.assets.update', $asset['id']) }}" method="post" enctype="multipart/form-data">
			@csrf
			@method('PUT')
			<!-- Barcode -->
			<div class="form-group">
				<label for="">
					{{ __('app.assets.barcode') }}
					<span class="text-danger"> * </span>
				</label>
				<input type="text" name="barcode" value="{{ $asset['barcode'] }}" id="" class="form-control" readonly>
			</div>

			<!-- Select Category -->
			<div class="form-group">
				<label for="">{{ __('app.assets.category_id') }}</label>
				<span class="text-danger"> * </span>
				<select name="category_id" id="" class="form-control select2 @error('category') is-invalid @enderror">
					<option selected disabled value="">{{ __('app.assets.placeholder.category_id') }}</option>
					@foreach ($assetCategories as $category)
					<option value="{{ $category['id'] }}" {{ $asset['category_id'] == $category['id'] ? ' selected' : '' }}>
						{{ $category['name'] }}</option>
					@endforeach
				</select>
				@error('category')
				<div class="invalid-feedback">
					{{ $message }}
				</div>
				@enderror
			</div>

			<!-- Merek HP -->
			<div class="form-group">
				<label for="">
					{{ __('app.assets.brand') }}
					<span class="text-danger"> * </span>
				</label>
				<input type="text" name="brand" value="{{ $asset['brand'] }}" id="" class="form-control">
			</div>

			<!-- IMEI / Serial Number -->
			<div class="form-group">
				<label for="">
					{{ __('app.assets.serial_number') }}
					<span class="text-danger"> * </span>
				</label>
				<input type="text" name="serial_number" value="{{ $asset['serial_number'] }}" id="" class="form-control">
			</div>

			<!-- Tanggal Pembelian -->
			<div class="form-group">
				<label class="">{{ __('app.assets.purchase_date') }}</label>
				<span class="text-danger"> * </span>
				<div class="input-group date">
					<input type="text" name="purchase_date" value="{{ date('m/d/Y', strtotime($asset['purchase_date'])) }}"
						class="form-control @error('purchase_date') is-invalid @enderror" readonly value="" id="kt_datepicker_3" />
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
			<div class="form-group">
				<label for="">
					{{ __('app.assets.name') }}
					<span class="text-danger"> * </span>
				</label>
				<input type="text" name="name" value="{{ $asset['name'] }}" id="" class="form-control">
			</div>

			<!-- Divisi -->
			<div class="form-group">
				<label for="">{{ __('app.assets.division_id') }}</label>
				<span class="text-danger"> * </span>
				<select name="division_id" id="" class="form-control select2_hide_search @error('division_id') is-invalid @enderror">
					@foreach ($divisions as $division)
					<option value="{{ $division['id'] }}" {{ $asset['division_id'] == $division['id'] ? ' selected' : '' }}>
						{{ $division['name'] }}</option>
					@endforeach
				</select>
				@error('division_id')
				<div class="invalid-feedback">
					{{ $message }}
				</div>
				@enderror
			</div>

			<!-- Cabang -->
			<div class="form-group">
				<label for="">{{ __('app.assets.branch_id') }}</label>
				<span class="text-danger"> * </span>
				<select name="branch_id" id="" class="form-control select2">
					@foreach ($branches as $branch)
					<option value="{{ $branch['id'] }}" {{ $asset['branch_id'] == $branch['id'] ? ' selected' : '' }}>
						{{ $branch['Branch'] }} - {{ $branch['BranchName'] }}</option>
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
					<input type="text" name="lend_date" value="{{ date('m/d/Y', strtotime($asset['lend_date'])) }}"
						class="form-control @error('lend_date') is-invalid @enderror" readonly value="" id="kt_datepicker_3" />
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

			<!-- checkbox -->
			<div class="form-group">
				<div class="form-label">
					<div class="checkbox-inline">
						<label class="checkbox checkbox-outline checkbox-outline-2x checkbox-primary">
							<input type="checkbox" id="checkReturnDate"
								{{ $asset['return_date'] ? ' checked' : '' }} onclick="changeType()" />
							<span></span>
							{{ __('app.assets.return_date') }}
						</label>
					</div>
					<span class="form-text text-muted">Ceklis apabila user telah mengembalikan barang</span>
				</div>
			</div>

			<!-- Tanggal Kembali -->
			<div class="form-group" id="formReturnDate" style="display: {{ $asset['return_date'] ? 'block' : 'none' }}">
				<label class="">{{ __('app.assets.return_date') }}</label>
				<span class="text-danger"> * </span>
				<div class="input-group date">
					<input type="text" name="return_date"
						value="{{ $asset['return_date'] ? date('m/d/Y', strtotime($asset['return_date'])) : '' }}"
						class="form-control" readonly value="" id="kt_datepicker_3" />
					<div class="input-group-append">
						<span class="input-group-text">
							<i class="la la-calendar"></i>
						</span>
					</div>
				</div>
				<span class="form-text text-muted">Enable clear and today helper buttons</span>
			</div>

			<!-- Description -->
			<div class="form-group">
				<label for="">{{ __('app.assets.description') }}</label>
				<textarea name="description" id="" cols="30" rows="3"
					class="form-control">{{ $asset['description'] }}</textarea>
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

<!-- Checked Return Date -->
<script>
	const checkReturnDate = document.getElementById('checkReturnDate');
	const formReturnDate = document.getElementById('formReturnDate');

	function changeType() {
		if (checkReturnDate.checked) {
			formReturnDate.style.display = 'block';
		} else {
			formReturnDate.style.display = 'none';
		}
	}

</script>
@endsection
