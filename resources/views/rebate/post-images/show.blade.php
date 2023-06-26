@extends('layout.default')

@section('title', __('app.programs.images.pages.show'))

@section('content')

<!-- Button Back -->
<a href="{{ route('program.images.index') }}" class="btn btn-secondary font-weight-bold mb-2">
	<img src="{{ asset('media/svg/icons/Navigation/Left-2.svg') }}" />
	{{ __('app.button.back') }}
</a>

<div class="card card-custom">
	<div class="card-header">
		<div class="card-title">
			<h3>
				{{ $programImage->program->program_detail->sku_group->name }}
				<span class="d-block text-muted pt-2 font-size-sm">{{ __('app.programs.pages.show') }}</span>
			</h3>
		</div>
	</div>

	<div class="card-body">
		<div class="row">
			<label for="" class="col-md-3 col-form-label">{{ __('app.programs.name') }}</label>
			<label for="" class="col col-form-label">: {{ $programImage->program->name }}</label>
		</div>

		{{-- <div class="row">
			<label for="" class="col-md-3 col-form-label">{{ __('app.programs.sku_group') }}</label>
			<label for="" class="col col-form-label">: {{ $programImage->program->program_detail->sku_group->name }}</label>
		</div> --}}

		<div class="row">
			<label for="" class="col-md-3 col-form-label">{{ __('app.programs.customer_list') }}</label>
			<label for="" class="col col-form-label">: {{ trim($programImage->master_customers[0]['Name']) }}</label>
		</div>

		<div class="row">
			<label for="" class="col-md-3 col-form-label">{{ __('app.programs.inventory') }}</label>
			<label for="" class="col col-form-label">: {{ trim($programImage->master_inventories[0]['InvtID']) }} - {{ trim($programImage->master_inventories[0]['Descr']) }}</label>
		</div>

		<div class="row">
			<label for="" class="col-md-3 col-form-label">{{ __('app.programs.promo') }}</label>
			<label for="" class="col col-form-label">: {{ $programImage->promo ? 'YA' : 'TIDAK' }}</label>
		</div>

		<div class="row">
			<label for="" class="col-md-3 col-form-label">{{ __('app.programs.normal_price') }}</label>
			<label for="" class="col col-form-label">: {{ __('app.operators.rupiah') }}
				{{ number_format($programImage->normal_price) }}</label>
		</div>

		<div class="row">
			<label for="" class="col-md-3 col-form-label">{{ __('app.programs.promo') }}</label>
			<label for="" class="col col-form-label">: {{ __('app.operators.rupiah') }}
				{{ number_format($programImage->promo_price) }}</label>
		</div>

		<div class="row">
			<label for="" class="col-md-3 col-form-label">{{ __('app.programs.depth') }}</label>
			<label for="" class="col col-form-label">:
				{{ round($programImage->depth) }}{{ __('app.operators.percentage') }}</label>
		</div>

		<div class="row">
			<label for="" class="col-md-3 col-form-label">{{ __('app.programs.cut_price') }}</label>
			<label for="" class="col col-form-label">: {{ __('app.operators.rupiah') }}
				{{ number_format($programImage->normal_price - $programImage->promo_price) }}</label>
		</div>

		<div class="row">
			<label for="" class="col-md-3 col-form-label">{{ __('app.programs.images.image') }}</label>
			<label for="" class="col col-form-label">
				<img src="/storage/{{ $programImage->text }}" width="30%" alt="">
			</label>
		</div>

	</div>
</div>

@endsection
