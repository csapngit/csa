@extends('layout.default')

@section('title', 'Targets')

@section('content')

<div class="card card-custom mb-2">
	<div class="card-header flex-wrap border-0 pt-6 pb-0">
		<div class="card-title">
			<h3>
				Target DSR
				<span class="d-block text-muted pt-2 font-size-sm">Sorting & pagination remote datasource</span>
			</h3>
		</div>
	</div>
	<div class="card-body">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Branch</th>
					<th>Mapping</th>
					<th>Target</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($targetDsrs as $targetDsr)
				<tr>
					<td>{{ $targetDsr->branch }}</td>
					<td>{{ $targetDsr->mapping }}</td>
					<td style="font-weight: 700">{{ __('app.operators.rupiah') }} {{ number_format($targetDsr->target_sales) }}
					</td>
					<td>
						<!-- Button trigger modal-->
						<button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
							data-target="#exampleModal{{ $targetDsr->id }}">
							<i class="fas fa-pencil-alt"></i>
						</button>
					</td>

					<!-- Modal-->
					<form action="{{ route('report.target-dsrs.update', $targetDsr->id) }}" method="post">
						@csrf
						@method('PUT')
						<div class="modal fade" id="exampleModal{{ $targetDsr->id }}" tabindex="-1" role="dialog"
							aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Modal Title</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<i aria-hidden="true" class="ki ki-close"></i>
										</button>
									</div>
									<div class="modal-body">
										<input type="text" name="target_sales" class="form-control" id=""
											value="{{ $targetDsr->target_sales }}">
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-light-primary font-weight-bold"
											data-dismiss="modal">Close</button>
										<button type="submit" class="btn btn-primary font-weight-bold">Save changes</button>
									</div>
								</div>
							</div>
						</div>
					</form>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

<input type="hidden" name="" id="asdf" value="{{ session('success') }}">
@endsection

@if (session('success'))
@section('scripts')
<script>
	var message = document.getElementById('asdf').value;

	toastr.options = {
		"closeButton": false,
		"debug": false,
		"newestOnTop": false,
		"progressBar": false,
		"positionClass": "toast-top-right",
		"preventDuplicates": false,
		"onclick": null,
		"showDuration": "300",
		"hideDuration": "1000",
		"timeOut": "7000",
		"extendedTimeOut": "1000",
		"showEasing": "swing",
		"hideEasing": "linear",
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"
	};

	toastr.success(message);

</script>
@endsection
@endif
