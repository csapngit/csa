@extends('layout.default')

@section('title', 'Claim Customers Import')

@section('content')

<!-- Success alert -->
<x-alerts.alert condition="success" />

<!-- Warning alert -->
<x-alerts.alert condition="warning" />

<div class="card card-custom">
	<div class="card-header flex-wrap border-0 pt-6 pb-0">
		<div class="card-title">
			<h3>
				{{ __('Claim Customers Import') }}
				<span class="d-block text-muted pt-2 font-size-sm">Sorting & pagination remote datasource</span>
			</h3>
		</div>
	</div>
	<div class="card-body">
		<form action="{{ route('customers.import.claim') }}" method="POST" enctype="multipart/form-data">
			@csrf
			<div class="form-group">
				<label for="">
					Input Code Rebate
				</label>
				<span class="text-danger"> * </span>
				<input type="text" name="rebate_code" id="" class="form-control">
			</div>

			<div class="form-group" x-data="{ fileName: '' }">
				<label for="">
					Choose File
				</label>
				<span class="text-danger"> * </span>
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

			<x-buttons.submit />
		</form>
	</div>
</div>
@endsection

@section('scripts')

<script src="//unpkg.com/alpinejs" defer></script>

@endsection
