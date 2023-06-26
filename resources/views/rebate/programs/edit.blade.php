{{-- Extends layout --}}
@extends('layout.default')

@section('title', __('app.programs.pages.edit'))

{{-- Content --}}
@section('content')
<div class="card card-custom">
	<div class="card-header flex-wrap border-0 pt-6 pb-0">
		<div class="card-title">
			<h3 class="card-label">
				{{ __('app.programs.pages.edit') }}
			</h3>
		</div>
	</div>

	<div class="card-body">
		<x-forms.form :action="route('programs.update', $program->id)" back-route-name="programs.index">

			<!-- Select Area -->
			<div class="form-group">
				<label for="area">
					{{ __('app.programs.area') }}
				</label>
				<span class="text-danger"> * </span>

				<select name="area" id="area" class="form-control kt_select2_hiding @error('area') is-invalid @enderror">
					@foreach ($areas as $area)
					<option value="{{ $area }}" {{ $program->area == $area ? ' selected' : '' }}>
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
			<x-forms.input name="name" trans="programs" :model="$program" :required="true" />

			<!-- Type -->
			<div class="form-group">
				<label class="">
					{{ __('app.programs.program_type_id') }}
				</label>
				<span class="text-danger"> * </span>
				<select name="type_id" id="typeId" class="form-control @error('type_id') is-invalid @enderror"
					onclick="changeType()">
					@foreach ($types as $type)
					<option value="{{ $type->id }}" {{ $program->program_type_id == $type->id ? 'selected' : '' }}>
						{{ $type->name }}</option>
					@endforeach
				</select>
				@error('type_id')
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
				<select name="program_display_type_id" id="" class="form-control">
					<option selected disabled value="">Select Display Type</option>
					@foreach ($displayTypes as $display)
					<option value="{{ $display->id }}" {{ $program->program_display_type_id == $display->id ? 'selected' : '' }}>
						{{ $display->name }}</option>
					@endforeach
				</select>
			</div>

			<!-- Brand -->
			<div class="form-group">
				<label class="">
					{{ __('app.programs.brand') }}
				</label>
				<span class="text-danger"> * </span>
				<select name="master_brand_id" class="form-control select2 @error('brand') is-invalid @enderror">
					<option selected disabled value="">Select Brand</option>
					@foreach ($brands as $brand)
					<option value="{{ $brand->id }}"
						{{ $program->program_detail->master_brand_id == $brand->id ? 'selected' : '' }}>
						{{ $brand->name }}</option>
					@endforeach
				</select>
				@error('brand')
				<div class="invalid-feedback">
					{{ $message }}
				</div>
				@enderror
			</div>

			<!-- SKU Group -->
			<div class="form-group">
				<label class="">
					{{ __('app.programs.sku_group') }}
				</label>
				<select name="sku_group_id" class="form-control select2">
					<option selected disabled value="">Select SKU</option>
					@foreach ($skuGroups as $sku)
					<option value="{{ $sku->id }}" {{ $program->program_detail->sku_group_id == $sku->id ? 'selected' : '' }}>
						{{ $sku->name }}</option>
					@endforeach
				</select>
			</div>

			<!-- checkbox -->
			<div class="form-group">
				<div class="form-label">
					<div class="checkbox-inline">
						<label class="checkbox checkbox-outline checkbox-outline-2x checkbox-primary">
							<input type="checkbox" id="checkSKU" {{ $countedProduct > 0 ? ' checked' : '' }}
								onclick="changeSkuType()" />
							<span></span>
							Choose SKU ?
						</label>
					</div>
					<span class="form-text text-muted">Ceklis apabila Program Type menggunakan SKU</span>
				</div>
			</div>

			<!-- Inventaries / SKU id -->
			<div class="form-group" id="multiSelectProducts" style="display: {{ $countedProduct > 0 ? 'block' : 'none' }}">
				<label class="">
					{{ __('app.products.sku') }}
				</label>
				<select name="inventoryIds[]" class="form-control select2_hide_search" style="width: 100%" multiple="multiple">
					@foreach ($inventories as $inventory)
					<option value="{{ trim($inventory->InvtID) }}"
						{{ in_array(trim($inventory->InvtID), $programProducts) ? 'selected' : '' }}>
						{{ $inventory->InvtID }} - {{ $inventory->Descr }}
					</option>
					@endforeach
				</select>
			</div>

			<div class="form-row">
				<!-- Valid From -->
				<div class="col">
					<x-forms.date name="valid_from" trans="programs" :model="$program" :required="true" />
				</div>

				<!-- Until From -->
				<div class="col">
					<x-forms.date name="valid_until" trans="programs" :model="$program" :required="true" />
				</div>
			</div>

			<hr class="mb-5" style="border: 1px solid black">

			<!-- Promo / Tidak -->
			<div class="form-group">
				<label>{{ __('app.programs.promo') }}</label>
				<div class="radio-list">
					<label class="radio">
						<input type="radio" name="promo" value="1" {{ $program->program_detail->promo = true ? 'checked' : '' }} />
						<span></span>
						Ya
					</label>
					<label class="radio">
						<input type="radio" name="promo" value="0" {{ $program->program_detail->promo = false ? 'checked' : '' }} />
						<span></span>
						Tidak
					</label>
				</div>
			</div>

			<!-- Depth -->
			<x-forms.input :model="$program->program_detail" name="depth" trans="programs" />

			<!-- Normal Price -->
			<x-forms.input :model="$program->program_detail" name="cut_price" trans="programs" />

		</x-forms.form>
	</div>
</div>
@endsection

@section('scripts')
<!-- Select Display Type -->
<script>
	var selectType = document.getElementById('typeId');
	var selectDisplayType = document.getElementById('selectDisplayType');

	function changeDisplayType() {
		// Select type display
		if (selectType.value == 3) {
			selectDisplayType.style.display = 'block';
		} else {
			selectDisplayType.style.display = 'none';
		}

	}

</script>

<!-- Checked SKU -->
<script>
	const checkSKU = document.getElementById('checkSKU');
	const multiSelectProducts = document.getElementById('multiSelectProducts');

	function changeSkuType() {
		if (checkSKU.checked) {
			multiSelectProducts.style.display = 'block';
		} else {
			multiSelectProducts.style.display = 'none';
		}
	}

</script>
@endsection
