@extends('layout.default')

@section('title', __('app.generates.pages.index'))

@section('styles')

<script src="//unpkg.com/alpinejs" defer></script>

@endsection

@section('content')

<x-alerts.alert condition="success" />
<x-alerts.alert condition="warning" />

<div class="card card-custom mb-3">
	<div class="card-body">
		<form action="{{ route('generates.generate') }}" id="formAction" method="post" enctype="multipart/form-data">
			@csrf

			<!-- Livewire dynamic select -->
			<livewire:dynamic-select />

			<!-- nav -->
			<ul class="nav nav-tabs nav-justified mb-5" id="myTab" role="tablist">
				<!-- Generate nav -->
				<li class="nav-item">
					<a class="nav-link active" id="generate-tab" data-toggle="tab" href="#generate" aria-controls="generate">
						<span class="nav-icon">
							<i class="flaticon2-layers-1"></i>
						</span>
						<span class="nav-text">{{ __('app.generates.pages.index') }}</span>
					</a>
				</li>
				<!-- Export nav -->
				<li class="nav-item">
					<a class="nav-link" id="export-tab" data-toggle="tab" href="#export" aria-controls="export">
						<span class="nav-icon">
							<i class="flaticon2-layers-1"></i>
						</span>
						<span class="nav-text">{{ __('app.generates.texts.export') }}</span>
					</a>
				</li>
			</ul>

			<!-- // -->
			<div class="tab-content" id="myTabContent">
				<!-- Generate tab -->
				<div class="tab-pane fade show active" id="generate" role="tabpanel" aria-labelledby="generate-tab">
					<div class="form-group">
						<div class="alert alert-custom alert-default" role="alert">
							<div class="alert-icon"><i class="flaticon-exclamation-1 text-primary"></i></div>
							<div class="alert-text">
								The example form below demonstrates common HTML form elements that receive updated styles from
								Bootstrap
								with
								additional classes.
							</div>
						</div>
					</div>
				</div>
				<!-- Select Key -->
				<div class="tab-pane fade" id="export" role="tabpanel" aria-labelledby="export-tab">
					<div class="form-group">
						<label for="">
							{{ __('app.generates.key_id') }}
							<span class="text-danger">*</span>
						</label>

						<select name="key_id" id="" class="form-control select2 @error('key_id') is-invalid @enderror"
							style="width: 100%;">
							<option selected disabled value=""> {{ __('app.generates.placeholder.key_id') }} </option>
							@foreach ($keys as $key)
							<option value="{{ $key->id }}">
								{{ $key->name }}
							</option>
							@endforeach
						</select>

						@error('key_id')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
						@enderror
					</div>
				</div>
			</div>

			<button type="submit" class="btn btn-primary">
				{{ __('app.button.submit') }}
			</button>
		</form>
	</div>
</div>
@endsection

@section('scripts')
<script>
	$('#import-tab').click(function () {
		$('#formAction').attr('action', '{{ route('generates.import') }}');
		console.log($('#formAction').attr('action'));
	});

	$('#export-tab').click(function () {
		$('#formAction').attr('action', '{{ route('generates.export') }}');
		console.log($('#formAction').attr('action'));
	});

	$('#generate-tab').click(function () {
		$('#formAction').attr('action', '{{ route('generates.generate') }}');
		console.log($('#formAction').attr('action'));
	});

</script>
@endsection
