@extends('layout.default')

@section('title', __('app.tiers.pages.edit'))

@section('content')

<div class="card card-custom">
	<div class="card-header">
		<div class="card-title">
			<h3>{{ __('app.tiers.pages.edit') }}</h3>
		</div>
	</div>

	<div class="card-body">
		@if ($programTier->program->type_id == App\Enums\ProgramTypeEnum::REGULAR)
		@include('rebate.tiers.layouts.edit.display-edit')
		@endif

		@if ($programTier->program->type_id == App\Enums\ProgramTypeEnum::SESSIONAL)
		@include('rebate.tiers.layouts.edit.volume-edit')
		@endif
	</div>
</div>

@endsection
