<form action="{{ route('tiers.update', $programTier->id) }}" method="post">
	@method('PUT')
	@csrf
	<!-- Program id -->
	<input type="hidden" name="program_id" value="{{ $programTier->program->id }}">

	<!-- Type -->
	<input type="hidden" name="type_id" value="{{ App\Enums\ProgramTypeEnum::SESSIONAL }}">

	<!-- Tier Name -->
	<x-forms.input :model="$programTier" name="name" trans="tiers" :required="true" />

	<!-- Minimum Pcs -->
	<x-forms.input :model="$programTier" name="minimum_pcs" trans="tiers" />

	<!-- Maximum Pcs -->
	{{-- <x-forms.input :model="$programTier" name="maximum_pcs" trans="tiers" /> --}}

	<!-- Minimum Offtake -->
	<x-forms.input :model="$programTier" name="minimum_purchase" trans="tiers" />

	<!-- Maximum Offtake -->
	{{-- <x-forms.input :model="$programTier" name="maximum_purchase" trans="tiers" /> --}}

	<!-- Cashback -->
	<div class="form-group">
		<label for="">
			{{ __('app.tiers.cashback') }}
		</label>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<select name="incentive_type_id" class="form-control kt_select2_hiding" id="">
					@foreach ($incentiveTypes as $incentive)
					<option value="{{ $incentive->id }}"
						{{ $programTier->incentiveType->id == $incentive->id ? 'selected' : '' }}>
						{{ $incentive->name }} </option>
					@endforeach
				</select>
			</div>
			<input type="text" name="cashback" value="{{ $programTier->cashback }}"
				class="form-control @error('cashback') is-invalid @enderror">
			@error('cashback')
			<div class="invalid-feedback">
				{{ $message }}
			</div>
			@enderror
		</div>
	</div>

	<!-- Session warning for input display incentive -->
	<x-alerts.alert condition="warning" />

	<!-- Volume incentive -->
	<x-forms.input :model="$programTier" name="monthly_volume" trans="tiers" :required="true" />

	<x-buttons.submit />

	<a href="{{ route('programs.show', $programTier->program->id) }}" class="btn btn-secondary">{{ __('app.button.back') }}</a>
</form>
