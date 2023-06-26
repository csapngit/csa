@extends('layout.default')

@section('title', __('app.publishes.pages.index'))

@section('styles')

<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

@endsection

@section('content')

<x-alerts.alert condition='success' />

<x-alerts.alert condition='danger' />

<!-- Widget Status -->
<livewire:status-widget-approve />

<div class="card">
	<div class="card-header">
		<div class="card-title">
			<h3>{{ __('app.publishes.pages.index') }}</h3>
		</div>
	</div>

	<div class="card-body" id="">
		<form action="{{ route('publishes.store') }}" method="POST" enctype="multipart/form-data" class="d-inline">
			@csrf
			<!-- Select Date -->
			<div class="row mb-3">
				<div class="col">
					<div class="form-group">
						<label for="">
							{{ __('app.publishes.start_date') }}
						</label>
						<input type="date" name="start_date" id="start_date"
							class="form-control @error('start_date') is-invalid @enderror">
						@error('start_date')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
						@enderror
					</div>
				</div>

				<div class="col">
					<div class="form-group">
						<label for="">
							{{ __('app.publishes.end_date') }}
						</label>
						<input type="date" name="end_date" id="end_date"
							class="form-control @error('end_date') is-invalid @enderror">
						@error('end_date')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
						@enderror
					</div>
				</div>
			</div>

			<!-- Table -->
			<livewire:table />

			<!-- Submit Button -->
			<button type="submit" name="action" value="submit" class="btn btn-primary">{{ __('app.button.submit') }}</button>

			<!-- Publish All Button -->
			<button type="submit" name="action" value="publish_all" class="btn btn-primary">Publish All</button>
		</form>
	</div>
</div>

@endsection

@section('scripts')

{{-- <script src="{{ asset('js/rebate/voucher/voucher_publish.js') }}"></script> --}}

<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script>
	$(document).ready(function () {
		$('#myTable').DataTable();
	});

</script>

<script>
	$('.checked_all').on('change', function (e) {
		e.preventDefault()
		$('.check_customer_id').prop('checked', this.checked)
	})

</script>

@endsection
