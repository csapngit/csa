<x-forms.form :action="route('tiers.update', $programTier->id)" back-route-name="programs.index">

	<!-- Program id -->
	<input type="hidden" name="program_id" value="{{ $programTier->program->id }}">

	<!-- Type -->
	<input type="hidden" name="type_id" value="{{ App\Enums\ProgramTypeEnum::REGULAR }}" id="">

	<!-- Tier Name -->
	<x-forms.input name="name" trans="tiers" :model="$programTier" :required="true" />

	<!-- Display psku -->
	<x-forms.input name="display" :model="$programTier" trans="tiers" :required="true" />

	<!-- Display incentive -->
	<div class="form-group">
		<label for="">
			<strong>{{ __('app.tiers.monthly_display') }}</strong>
		</label>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<select name="incentive_type_id" class="form-control kt_select2_hiding" id="">
					@foreach ($incentiveTypes as $incentive)
					<option value="{{ $incentive->id }}"
						{{ $programTier->incentiveType->id == $incentive->id ? 'selected' : '' }}>
						{{ $incentive->name }}
					</option>
					@endforeach
				</select>
			</div>
			<input type="text" name="monthly_display" value="{{ $programTier->monthly_display }}" class="form-control">
		</div>
	</div>

	<!-- Session warning for input display incentive -->
	<x-alerts.alert condition="warning" />

	<!-- Monthly volume incentive -->
	<x-forms.input name="monthly_volume" :model="$programTier" trans="tiers" :required="true" />

</x-forms.form>
