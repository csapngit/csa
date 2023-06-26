@extends('layout.default')

@section('content')

<div class="card card-custom mb-2">
	<div class="card-header flex-wrap border-0 pt-6 pb-0">
		<div class="card-title">
			<h3>
				Incentive Import
				<span class="d-block text-muted pt-2 font-size-sm">Sorting & pagination remote datasource</span>
			</h3>
		</div>
	</div>
	<div class="card-body">
		<form action="{{ route('incentives.import') }}" method="POST" enctype="multipart/form-data">
			@csrf
			<div class="form-group">
				<label for="">{{ __('app.generals.files') }}</label>
				<span class="text-danger"> * </span>
				<input type="file" name="incentive" id="" class="form-control">
			</div>
			<button type="submit" class="btn btn-primary">{{ __('app.button.submit') }}</button>
		</form>
	</div>
</div>

@endsection
