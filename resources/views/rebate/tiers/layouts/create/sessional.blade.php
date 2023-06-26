<form action="{{ route('tiers.store') }}" method="post">
	@csrf
	<!-- Program id -->
	<input type="hidden" name="program_id" value="{{ $program->id }}">

	<!-- Type -->
	<input type="hidden" name="type_id" value="{{ App\Enums\ProgramTypeEnum::SESSIONAL }}">

	<!-- Tier Name -->
	<x-forms.input name="name" trans="tiers" :required="true" />

	<!-- Minimum Pcs -->
	<x-forms.input name="minimum_pcs" trans="tiers" />

	<!-- Maximum Pcs -->
	{{-- <x-forms.input name="maximum_pcs" trans="tiers" /> --}}

	<!-- Minimum Offtake -->
	<x-forms.input name="minimum_purchase" trans="tiers" />

	<!-- Maximum Offtake -->
	{{-- <x-forms.input name="maximum_purchase" trans="tiers" /> --}}

	<!-- Cashback -->
	<div class="form-group">
		<label for="">
			{{ __('app.tiers.cashback') }}
		</label>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<select name="incentive_type_id" class="form-control select2_hide_search" id="">
					@foreach ($incentiveTypes as $incentive)
					<option value="{{ $incentive->id }}" {{ old('incentive_type_id') == $incentive->id ? 'selected' : '' }}>
						{{ $incentive->name }} </option>
					@endforeach
				</select>
			</div>
			<input type="text" name="cashback" value="{{ old('cashback') }}"
				class="form-control @error('cashback') is-invalid @enderror">
			@error('cashback')
			<div class="invalid-feedback">
				{{ $message }}
			</div>
			@enderror
		</div>
	</div>

	<!-- Volume incentive -->
	<x-forms.input name="monthly_volume" trans="tiers" :required="true" />

	<x-buttons.submit />

	<a href="{{ route('programs.show', $program->id) }}" class="btn btn-secondary">{{ __('app.button.back') }}</a>
</form>
