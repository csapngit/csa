@extends('layout.default')

@section('title', __('app.programs.images.pages.create'))

@section('content')

<x-alerts.alert condition="success" />

<div class="card card-custom mb-2">
	<div class="card-header flex-wrap border-0 pt-6 pb-0">
		<div class="card-title">
			<h3>
				Post images
				<span class="d-block text-muted pt-2 font-size-sm">Sorting & pagination remote datasource</span>
			</h3>
		</div>
	</div>
	<div class="card-body">
		<!-- Export -->
		<form action="{{ route('programs.export.image') }}" method="POST" id="export" enctype="multipart/form-data">
			@csrf
		</form>

		<!-- Program Image -->
		<form action="{{ route('program.images.store') }}" method="post" enctype="multipart/form-data">
			@csrf
			<div class="form-group">
				<input type="text" name="latlong" id="Latlong" value="" class="form-control" readonly>
			</div>

			<!-- Program ID -->
			<div class="form-group">
				<label for="">{{ __('app.programs.images.program_id') }}</label>
				<span class="text-danger"> * </span>
				<select name="program_id" id="program_id"
					class="form-control select2 @error('program_id') is-invalid @enderror">
					<option selected disabled value="">Select Program</option>
					@foreach ($programs as $program)
					<option value="{{ $program->id }}">{{ $program->name }} {{ $program->program_detail->sku_group->name ?? '' }} - {{ date('d m Y', strtotime($program->valid_from)) }}
					</option>
					@endforeach
				</select>
				@error('program_id')
				<div class="invalid-feedback">
					{{ $message }}
				</div>
				@enderror
			</div>

			<!-- Customer ID -->
			<div class="form-group">
				<label for="">{{ __('app.customers.pages.index') }}</label>
				<span class="text-danger"> * </span>
				<select name="customer_id" id="customer_id"
					class="form-control select2 @error('customer_id') is-invalid @enderror"></select>
				@error('customer_id')
				<div class="invalid-feedback">
					{{ $message }}
				</div>
				@enderror
			</div>

			<!-- Product id -->
			<div class="form-group">
				<label class="">
					{{ __('app.products.sku') }}
				</label>
				<span class="text-danger"> * </span>
				<select name="inventory_id" id="inventory_id"
					class="form-control select2 @error('inventory_id') is-invalid @enderror"></select>
				@error('inventory_id')
				<div class="invalid-feedback">
					{{ $message }}
				</div>
				@enderror
			</div>

			<!-- Normal Price -->
			<div class="form-group">
				<label for="">
					{{ __('app.programs.normal_price') }}
				</label>
				<span class="text-danger"> * </span>
				<input type="text" name="normal_price" id="normal_price"
					class="form-control @error('normal_price') is-invalid @enderror">
				@error('normal_price')
				<div class="invalid-feedback">
					{{ $message }}
				</div>
				@enderror
			</div>

			<!-- Promo Price -->
			<div class="form-group">
				<label for="">
					{{ __('app.programs.promo_price') }}
				</label>
				<span class="text-danger"> * </span>
				<input type="text" name="promo_price" id="promo_price"
					class="form-control @error('promo_price') is-invalid @enderror" onkeyup="calculateCutPrice()">
				@error('promo_price')
				<div class="invalid-feedback">
					{{ $message }}
				</div>
				@enderror
			</div>

			<!-- Depth -->
			<div class="form-group">
				<label for="">
					{{ __('app.programs.depth') }}
				</label>
				<input type="text" name="depth" id="depth" class="form-control" readonly>
				<div class="" id="invalid"></div>
			</div>

			<!-- Cut Price -->
			<x-forms.input name="cut_price" trans="programs" :readonly="true" />

			<!-- Upload Image -->
			<div class="form-group">
				<label class="file">
					<label for="formFile" class="form-label">Upload Image</label>
					<span class="text-danger"> * </span>
					<input class="form-control @error('image') is-invalid @enderror" name="image" type="file" id="formFile" accept="image/*" capture>
				</label>
				@error('image')
				<div class="invalid-feedback">
					{{ $message }}
				</div>
				@enderror
			</div>

			<button type="submit" class="btn btn-primary">{{ __('app.button.submit') }}</button>

			<a href="{{ route('program.images.index') }}" class="btn btn-secondary">{{ __('app.button.back') }}</a>
		</form>
	</div>
</div>

@endsection

@section('scripts')
<script>
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(showPosition);
	} else {
		document.getElementById("demo").innerHTML =
			"Geolocation is not supported by this browser.";
	}

	function showPosition(position) {
		document.getElementById("Latlong").value = position.coords.latitude + ', ' + position.coords.longitude;
	}

</script>

<script>
	$(document).ready(function () {
		$('#program_id').on('change', function () {
			var programId = this.value;
			// Get customer by program id
			$("#customer_id").html('');
			$.ajax({
				url: "{{ route('customers.program') }}",
				type: "POST",
				data: {
					program_id: programId,
					_token: '{{ csrf_token() }}'
				},
				dataType: 'json',
				success: function (result) {
					// console.log(result);
					$('#customer_id').html('<option value=""> Select Customers </option>');
					$.each(result, function (key, value) {
						// console.log('here');
						$("#customer_id").append('<option value="' + value
							.customer_id + '">' + value.Name + '</option>');
					});
				}
			});

			// Get inventory by program id
			$("#inventory_id").html('');
			$.ajax({
				url: "{{ route('inventories.program') }}",
				type: "POST",
				data: {
					program_id: programId,
					_token: '{{ csrf_token() }}'
				},
				dataType: 'json',
				success: function (result) {
					// console.log(result);
					$('#inventory_id').html('<option value=""> Select SKU </option>');
					$.each(result, function (key, value) {
						// console.log('here');
						$("#inventory_id").append('<option value="' + $.trim(value.InvtID) + '">' + value.InvtID +
							' - ' + value.Descr + '</option>');
					});
				}
			});
		});
	});

</script>

<script>
	$(document).ready(function () {
		$('#program_id').on('change', function () {
			var programId = this.value;
			// console.log(programId);
			$.ajax({
				url: "{{ route('programs.depth') }}",
				type: "POST",
				data: {
					program_id: programId,
					_token: '{{ csrf_token() }}'
				},
				dataType: 'json',
				success: function (result) {
					console.log(result.depth);
					localStorage.setItem("result.depth", result.depth);
				}
			});
		});
	});

	function calculateCutPrice() {
		var normal_price = document.getElementById('normal_price');
		var promo_price = document.getElementById('promo_price');
		var cut_price = document.getElementById('cut_price');
		var depth = document.getElementById('depth');
		var validation = document.getElementById('invalid');

		// console.log(depth.className);

		if (isNaN(normal_price.value)) {
			normal_price.value = 0;
		}

		if (isNaN(promo_price.value)) {
			promo_price.value = 0;
		}

		cut_price.value = parseFloat(normal_price.value) - parseFloat(promo_price.value);

		depth.value = cut_price.value / normal_price.value * 100;

		depth.value = Math.round(depth.value);

		// depth.value = new Intl.NumberFormat('default', {
		// 	style: 'percent',
		// 	minimumFractionDigits: 0,
		// 	maximumFractionDigits: 0,
		// }).format(depth.value / 100);

		var masterDepth = localStorage.getItem("result.depth");

		console.log(depth.value);

		if (depth.value == masterDepth) {
			// console.log('true');

			depth.className = "form-control is-valid";

			validation.className = "valid-feedback";

			validation.innerHTML = "Depth sesuai dengan master promo";
		} else {
			// console.log('false');

			depth.className = "form-control is-invalid";

			validation.className = "invalid-feedback";

			validation.innerHTML = "Depth tidak sama dengan master promo";
		}
	}

</script>

@endsection
