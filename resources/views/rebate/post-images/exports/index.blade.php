@extends('layout.default')

@section('title', 'Report')

@section('content')

<div class="card card-custom mb-2">
	<div class="card-header flex-wrap border-0 pt-6 pb-0">
		<div class="card-title">
			<h3>
				{{ __('Report Image') }}
				<span class="d-block text-muted pt-2 font-size-sm">Sorting & pagination remote datasource</span>
			</h3>
		</div>
	</div>
	<form action="{{ route('programs.export.image') }}" method="POST" enctype="multipart/form-data">
		@csrf
		<div class="card-body">
			<div class="form-group">
				<label class="form-label">Date</label>
				<span class="text-danger"> * </span>
				{{-- <input type="month" name="periode" class="form-control date"/> --}}
				<input type="text" name="periode" class="form-control date" id="kt_date_input"/>
				<span class="form-text text-muted">Custom date format: <code>dd/yyyy</code></span>
			</div>

			<div class="form-group">
				<label class="form-label">Store</label>
				<span class="text-danger"> * </span>
				<select name="store_id" class="form-control select2" id="">
					@foreach ($stores as $store)
					<option value="{{ $store->code }}">{{ $store->name }}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="card-footer">
			<button type="submit" class="btn btn-success">{{ __('app.button.export') }}</button>
			<a href="{{ route('program.images.index') }}" class="btn btn-secondary">{{ __('app.button.back') }}</a>
		</div>
	</form>
</div>
@endsection

@section('scripts')

<script>
	"use strict";
	// Class definition

	var KTMaskDemo = function () {

		// private functions
		var demos = function () {
			$('#kt_date_input').mask('00/0000', {
				placeholder: "mm/yyyy"
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
		KTMaskDemo.init();
	});

</script>

@endsection
