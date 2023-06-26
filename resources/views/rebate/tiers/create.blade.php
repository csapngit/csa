@extends('layout.default')

@section('title', __('app.tiers.pages.create'))

@section('content')
<div class="card">
	<div class="card-header flex-wrap border-0 pt-6 pb-0">
		<div class="card-title">
			<h3>{{ __('app.tiers.pages.create') }} {{ $program->name }}</h3>
		</div>
	</div>

	<div class="card-body">
		<!-- Page create display program -->
		@if ($program->type->id == App\Enums\ProgramTypeEnum::REGULAR)
		@include('rebate.tiers.layouts.create.display')
		@endif

		<!-- Page create sessional program -->
		@if ($program->type->id == App\Enums\ProgramTypeEnum::SESSIONAL)
		@include('rebate.tiers.layouts.create.sessional')
		@endif
	</div>
</div>
@endsection
