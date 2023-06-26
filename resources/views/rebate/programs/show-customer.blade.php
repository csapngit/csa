@extends('layout.default')

@section('title', __('app.programs.pages.show'))

@section('styles')

{{-- Datatables --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

@endsection

@section('content')

<h3 style="text-align: center">Total Customer = {{ $program->customers_count }}</h3>

<!-- Success alert -->
<x-alerts.alert condition="success" />

<!-- Warning alert -->
<x-alerts.alert condition="warning" />

<div class="card card-custom">
	<div class="card-header">
		<div class="card-title">
			<h1>{{ __('app.customers.pages.index') }} {{ $program->program_detail->sku_group->name }}</h1>
		</div>
	</div>
	<div class="card-body">
		<x-forms.form :action="route('customers.import.tsp', $program->id)" back-route-name="programs.index">

			<div class="form-group" x-data="{ fileName: '' }">
				<div class="input-group shadow">
					<span class="input-group-text px-3 text-muted">
						<i class="fas fa-file fa-lg"></i>
					</span>

					<input type="file" name="customerFile" x-ref="file" @change="fileName = $refs.file.files[0].name"
						class="d-none">

					<input type="text" class="form-control @error('customerFile') is-invalid @enderror"
						placeholder="Upload File Here" x-model="fileName">

					<button class="browse btn btn-primary px-4" type="button" x-on:click.prevent="$refs.file.click()"><i
							class="fas fa-file"></i> {{ __('app.button.browse') }}
					</button>
				</div>

				@error('customerFile')
				<div class="text-danger mt-2">
					{{ $message }}
				</div>
				@enderror

			</div>

		</x-forms.form>

		<hr>

		<h3>
			{{ __('app.customers.texts.customer_does_not_exist') }}
		</h3>

		<div class="card">
			<div class="card-body">
				<table id="example" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>{{ __('app.tables.number') }}</th>
							<th>{{ __('app.customers.customer_id') }}</th>
							<th>{{ __('app.tables.date') }}</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($failedImports as $failed)
						<tr>
							<td>{{ $loop->iteration }}</td>
							<td>{{ $failed->customer_id }}</td>
							<td>{{ date('Y-m', strtotime($failed->created_at))}}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

@endsection

@section('scripts')

{{-- Datatables --}}
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script>
	$(document).ready(function () {
		$('#example').DataTable();
	});

</script>

<script src="//unpkg.com/alpinejs" defer></script>

@endsection
