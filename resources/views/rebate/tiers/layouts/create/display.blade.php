<x-forms.form :action="route('tiers.store')" back-route-name="programs.index">

	<!-- Program id -->
	<input type="hidden" name="program_id" value="{{ $program->id }}">

	<!-- Type -->
	<input type="hidden" name="type_id" value="{{ App\Enums\ProgramTypeEnum::REGULAR }}">

	<!-- Tier Name -->
	<x-forms.input name="name" trans="tiers" :required="true" />

	<!-- Display psku -->
	<x-forms.input name="display" trans="tiers" :required="true" />

	<!-- Display incentive -->
	<div class="form-group">
		<label for="">
			{{ __('app.tiers.monthly_display') }}
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
			<input type="text" name="monthly_display" value="{{ old('monthly_display') }}"
				class="form-control @error('monthly_display') is-invalid @enderror">
			@error('monthly_display')
			<div class="invalid-feedback">
				{{ $message }}
			</div>
			@enderror
		</div>
	</div>

	<!-- Session warning for input display incentive -->
	<x-alerts.alert condition="warning" />

	<!-- Volume incentive -->
	<x-forms.input name="monthly_volume" trans="tiers" :required="true" />

</x-forms.form>
