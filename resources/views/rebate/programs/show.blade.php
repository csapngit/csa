@extends('layout.default')

@section('title', __('app.programs.pages.show'))

@section('styles')

{{-- Datatables --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

@endsection

@section('content')

<a href="{{ route('programs.index') }}" class="btn btn-secondary font-weight-bold mb-2">
	<img src="{{ asset('media/svg/icons/Navigation/Left-2.svg') }}" />
	{{ __('app.button.back') }}
</a>

<!-- Alert Success -->
{{-- <x-alerts.alert condition="success" /> --}}

<div class="card card-custom">
	<div class="card-header">
		<div class="card-title">
			<h3>
				{{ $program->name }}
				<span class="d-block text-muted pt-2 font-size-sm">{{ __('app.programs.pages.show') }}</span>
			</h3>
		</div>
	</div>

	<div class="card-body">
		<!-- Page show display program -->
		{{-- @if ($program->type->id == App\Enums\ProgramTypeEnum::REGULAR)
    @include('rebate.programs.layouts.show.display')
    @endif --}}

		<!-- Page show volume program -->
		{{-- @if ($program->type->id == App\Enums\ProgramTypeEnum::SESSIONAL)
    @include('rebate.programs.layouts.show.volume')
    @endif --}}

		<div class="row">
			<label for="" class="col-md-3 col-form-label">{{ __('app.programs.area') }}</label>
			<label for="" class="col col-form-label">: {{ $program->area }}</label>
		</div>

		<div class="row">
			<label for="" class="col-md-3 col-form-label">{{ __('app.programs.name') }}</label>
			<label for="" class="col col-form-label">: {{ $program->name }}</label>
		</div>

		<div class="row">
			<label for="" class="col-md-3 col-form-label">{{ __('app.programs.program_type_id') }}</label>
			<label for="" class="col col-form-label">: {{ $program->program_type->name }}</label>
		</div>

		<div class="row">
			<label for="" class="col-md-3 col-form-label">{{ __('app.programs.display_id') }}</label>
			<label for="" class="col col-form-label">:
				{{ $program->program_detail->program_display_type->name ?? '-' }}</label>
		</div>

		<div class="row">
			<label for="" class="col-md-3 col-form-label">{{ __('app.programs.brand') }}</label>
			<label for="" class="col col-form-label">: {{ $program->program_detail->master_brand->name ?? '-' }}</label>
		</div>

		<div class="row">
			<label for="" class="col-md-3 col-form-label">{{ __('app.programs.sku_group') }}</label>
			<label for="" class="col col-form-label">: {{ $program->program_detail->sku_group->name ?? '-' }}</label>
		</div>

		<div class="row">
			<label for="" class="col-md-3 col-form-label">{{ __('app.programs.valid') }}</label>
			<label for="" class="col col-form-label">: {{ $program->valid_from->format('d F Y') }} -
				{{ $program->valid_until->format('d F Y') }}</label>
		</div>

		<div class="row">
			<label for="" class="col-md-3 col-form-label">{{ __('app.programs.promo') }}</label>
			<label for="" class="col col-form-label">: {{ $program->program_detail->promo ? 'YA' : 'TIDAK' }}</label>
		</div>

		<div class="row">
			<label for="" class="col-md-3 col-form-label">{{ __('app.programs.depth') }}</label>
			<label for="" class="col col-form-label">:
				{{ round($program->program_detail->depth) }}{{ __('app.operators.percentage') }}</label>
		</div>

		<div class="row">
			<label for="" class="col-md-3 col-form-label">{{ __('app.programs.cut_price') }}</label>
			<label for="" class="col col-form-label">: {{ __('app.operators.rupiah') }}
				{{ number_format($program->program_detail->cut_price) }}</label>
		</div>

		<div class="row">
			<label for="" class="col-md-3 col-form-label">{{ __('app.programs.customer_list') }}</label>
			<label for="" class="col col-form-label">: {{ $program->customers_count }}</label>
		</div>

		<hr>

		<div class="row">
			<label for="" class="col-md-3 col-form-label">{{ __('app.programs.inventory') }}</label>
			<div class="col">
				@forelse ($inventories->chunk(2) as $chunk)
				<div class="row">
					@foreach ($chunk as $inventory)
					{{-- <div class="col-md-6">{{ $inventory->inventory_id }} - {{ trim($inventory->Descr) }}</div> --}}
				<label for="" class="col-md-6 col-form-label"> {{ $inventory->inventory_id }} -
					{{ trim($inventory->Descr) }}</label>
				@endforeach
			</div>
			@empty
			: No SKU Attachment
			@endforelse
		</div>
	</div>
</div>
</div>

@endsection
