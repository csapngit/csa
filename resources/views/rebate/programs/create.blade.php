{{-- Extends layout --}}
@extends('layout.default')

@section('title', __('app.programs.pages.create'))

{{-- Content --}}
@section('content')
<div class="card card-custom">
	<div class="card-header flex-wrap border-0 pt-6 pb-0">
		<div class="card-title">
			<h3 class="card-label">
				{{ __('app.programs.pages.create') }}
			</h3>
		</div>
	</div>

	<div class="card-body">
		<form action="{{ route('programs.store') }}" method="POST" enctype="multipart/form-data">
			@csrf
			<!-- Area -->
			<div class="form-group">
				<label for="area">
					{{ __('app.programs.area') }}
				</label>
				<span class="text-danger"> * </span>
				<select name="area" id="area" class="form-control select2_hide_search @error('area') is-invalid @enderror">
					@foreach ($areas as $area)
					<option value="{{ $area }}">
						{{ $area }}
					</option>
					@endforeach
				</select>
				@error('area')
				<div class="text-danger">
					{{ $message }}
				</div>
				@enderror
			</div>

			<!-- Name -->
			<x-forms.input name="name" trans="programs" :required="true" />

			<!-- Program Type -->
			<div class="form-group">
				<label class="">
					{{ __('app.programs.program_type_id') }}
				</label>
				<span class="text-danger"> * </span>
				<select name="program_type_id" id="typeId" class="form-control @error('program_type_id') is-invalid @enderror"
					onclick="changeDisplayType()">
					@foreach ($types as $type)
					<option value="{{ $type->id }}" {{ old('program_type_id') == $type->id ? ' selected' : '' }}>{{ $type->name }}
					</option>
					@endforeach
				</select>
				@error('program_type_id')
				<div class="invalid-feedback">
					{{ $message }}
				</div>
				@enderror
			</div>

			<!-- Display Type -->
			<div class="form-group" id="selectDisplayType" style="display: none">
				<label class="">
					{{ __('app.programs.display_id') }}
				</label>
				<span class="text-danger"> * </span>
				<select name="program_display_type_id" id=""
					class="form-control select2 @error('program_display_type_id') is-invalid @enderror" style="width: 100%">
					<option selected disabled value="">Select Display Type</option>
					@foreach ($displayTypes as $display)
					<option value="{{ $display->id }}" {{ old('program_display_type_id') == $display->id ? ' selected' : '' }}>
						{{ $display->name }}</option>
					@endforeach
				</select>
				@error('program_display_type_id')
				<div class="invalid-feedback">
					{{ $message }}
				</div>
				@enderror
			</div>

			<!-- Brand -->
			<div class="form-group">
				<label class="">
					{{ __('app.programs.brand') }}
				</label>
				<span class="text-danger"> * </span>
				<select name="master_brand_id" class="form-control select2 @error('master_brand_id') is-invalid @enderror">
					<option selected disabled value="">Select Brand</option>
					@foreach ($brands as $brand)
					<option value="{{ $brand->id }}" {{ old('master_brand_id') == $brand->id ? ' selected' : '' }}>
						{{ $brand->name }}</option>
					@endforeach
				</select>
				@error('master_brand_id')
				<div class="invalid-feedback">
					{{ $message }}
				</div>
				@enderror
			</div>

			<!-- SKU Group -->
			<div class="form-group" id="form_sku_group">
				<label class="">
					{{ __('app.programs.sku_group') }}
				</label>
				<span class="text-danger"> * </span>
				<select name="sku_group_id" class="form-control select2 @error('sku_group_id') is-invalid @enderror">
					<option selected disabled value="">Select SKU</option>
					@foreach ($skuGroups as $sku)
					<option value="{{ $sku->id }}" {{ old('sku_group_id') == $sku->id ? ' selected' : '' }}>{{ $sku->name }}
					</option>
					@endforeach
				</select>
				@error('sku_group_id')
				<div class="invalid-feedback">
					{{ $message }}
				</div>
				@enderror
			</div>

			<!-- checkbox -->
			{{-- <div class="form-group">
				<div class="form-label">
					<div class="checkbox-inline">
						<label class="checkbox checkbox-outline checkbox-outline-2x checkbox-primary">
							<input type="checkbox" name="checkbox" id="checkSKU" {{ old('checkbox') == 'on' ? ' checked' : '' }} />
							<span></span>
							Choose SKU ?
						</label>
					</div>
					<span class="form-text text-muted">Ceklis apabila Program Type menggunakan SKU</span>
				</div>
			</div> --}}

			{{-- @dd( old('program_type') ) --}}

			<!-- Inventaries / SKU id id -->
			<div class="form-group" id="form_inventories">
				<label class="">
					{{ __('app.products.sku') }}
				</label>
				<span class="text-danger"> * </span>
				<select name="inventoryIds[]" class="form-control select2_hide_search @error('inventoryIds') is-invalid @enderror" style="width: 100%" multiple="multiple">
					@foreach ($inventories as $inventory)
					<option value="{{ trim($inventory->InvtID) }}"
						{{ collect(old('inventoryIds'))->contains($inventory->InvtID) ? 'selected' : '' }}>
						{{ trim($inventory->InvtID) }} - {{ trim($inventory->Descr) }}
					</option>
					@endforeach
				</select>
				@error('inventoryIds')
				<div class="text-danger">
					{{ $message }}
				</div>
				@enderror
			</div>

			<div class="form-row">
				<!-- Valid From -->
				<div class="col">
					<x-forms.date name="valid_from" trans="programs" :required="true" />
				</div>

				<!-- Until From -->
				<div class="col">
					<x-forms.date name="valid_until" trans="programs" :required="true" />
				</div>
			</div>

			<hr class="mb-5" style="border: 1px solid black">

			<!-- Promo / Tidak -->
			<div class="form-group" id="form_promo">
				<label>{{ __('app.programs.promo') }}</label>
				<span class="text-danger"> * </span>
				<div class="radio-list">
					<label class="radio">
						<input type="radio" name="promo" value="1" checked />
						<span></span>
						Ya
					</label>
					<label class="radio">
						<input type="radio" name="promo" value="0" />
						<span></span>
						Tidak
					</label>
				</div>
				@error('promo')
				<div class="text-danger">
					{{ $message }}
				</div>
				@enderror
			</div>

			<!-- Depth -->
			<x-forms.input id2="form_depth" name="depth" trans="programs" :required="true" />

			<!-- Cut Price -->
			<x-forms.input id2="form_price" name="cut_price" trans="programs" :required="true" />

			<button type="submit" class="btn btn-primary mr-2">{{ __('app.button.submit') }}</button>

			<x-buttons.reset />

			<a href="{{ route('programs.index') }}" class="btn btn-secondary">
				{{ __('app.button.back') }}
			</a>
		</form>
	</div>
</div>
@endsection

@section('scripts')
<script>
	$(document).ready(function () {
		var selectType = document.getElementById('typeId');
		var selectDisplayType = document.getElementById('selectDisplayType');
		var form_sku_group = document.getElementById('form_sku_group');
		var form_inventories = document.getElementById('form_inventories');
		var form_promo = document.getElementById('form_promo');
		var form_depth = document.getElementById('form_depth');
		var form_price = document.getElementById('form_price');

		$('#typeId').on('change', function () {
			if (selectType.value == 3) {
				selectDisplayType.style.display = 'block';
				form_sku_group.style.display = 'none';
				form_inventories.style.display = 'none';
				form_promo.style.display = 'none';
				form_depth.style.display = 'none';
				form_price.style.display = 'none';
			} else {
				selectDisplayType.style.display = 'none';
				form_sku_group.style.display = 'block';
				form_inventories.style.display = 'block';
				form_promo.style.display = 'block';
				form_depth.style.display = 'block';
				form_price.style.display = 'block';
			}
		}).select2();
	});

</script>

<!-- Checked SKU -->
{{-- <script>
	const checkSKU = document.getElementById('checkSKU');
	const form_inventories = document.getElementById('form_inventories');

	function changeSkuType() {
		if (checkSKU.checked) {
			form_inventories.style.display = 'block';
		} else {
			form_inventories.style.display = 'none';
		}
	}

</script> --}}

{{-- <script>
	$("input[name=checkbox]").change(function (e) {
		$("#form_inventories").toggle();
	});

</script> --}}
@endsection
