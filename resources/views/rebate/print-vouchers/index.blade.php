@extends('layout.default')

@section('title', __('app.print_vouchers.pages.index'))

@section('content')

<div class="card card-custom mb-3">
	<div class="card-header">
		<div class="card-title">
			<h3>
				{{ __('app.print_vouchers.pages.index') }}
			</h3>
		</div>
	</div>
	<div class="card-body">

		<form action="{{ route('reports.printVoucher') }}" method="POST" enctype="multipart/form-data">
			@csrf
			<div class="form-group">
				<label for="">
					{{ __('app.print_vouchers.name') }}
				</label>
				<span class="text-danger"> * </span>
				<select name="branch" id="" class="form-control select2">
					<option selected disabled value="">{{ __('app.print_vouchers.placeholder.name') }}</option>
					@foreach ($branches as $branch)
					<option value="{{ $branch->id }}">
						{{ $branch->BranchName }}
					</option>
					@endforeach
				</select>
			</div>
			<button type="submit" class="btn btn-primary" formtarget="_blank">{{ __('app.button.print') }} </button>
		</form>
	</div>
</div>
@endsection
