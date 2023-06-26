@extends('layout.default')

@section('title', 'DSR')

@section('styles')
<style>
	.total {
		font-weight: 500;
		background: #2691E9;
		color: white;
	}

	.value {
		text-align: right;
	}

</style>

@endsection

@section('content')

@include('reports.dsr.layouts.header')

<form action="{{ route('report.dsr.mail') }}" method="POST">
	@csrf

	<button type="submit" class="btn btn-primary mb-2"> Send Email </button>
</form>

<div class="card card-custom">
	<div class="card-header flex-wrap border-0 pt-6 pb-0">
		<div class="card-title">
			<h3>
				{{ __('app.reports.dsr.channel_bisnis') }}
				<span class="d-block text-muted pt-2 font-size-sm">Sorting & pagination remote datasource</span>
			</h3>
		</div>
	</div>
	<div class="card-body">
		@include('reports.dsr.layouts.channel')
	</div>
</div>

<div class="card card-custom">
	<div class="card-header flex-wrap border-0 pt-6 pb-0">
		<div class="card-title">
			<h3>
				{{ __('app.reports.dsr.dsr') }}
				<span class="d-block text-muted pt-2 font-size-sm">Sorting & pagination remote datasource</span>
			</h3>
		</div>
	</div>
	<div class="card-body">
		@include('reports.dsr.layouts.branch')
	</div>
</div>
@endsection
