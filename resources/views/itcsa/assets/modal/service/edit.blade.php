<button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#exampleModal{{ $service->id }}">
	{{ __('app.button.edit') }}
</button>

<!-- Modal edit service -->
<div class="modal fade" id="exampleModal{{ $service->id }}" tabindex="-1" role="dialog"
	aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">{{ __('app.services.pages.edit') }}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<i aria-hidden="true" class="ki ki-close"></i>
				</button>
			</div>

			<form action="{{ route('itcsa.asset-services.update', $service->id) }}" method="POST"
				enctype="multipart/form-data">
				@csrf
				@method('PUT')
				<div class="modal-body">
					<!-- Asset barcode -->
					<div class="form-group">
						<label for="">{{ __('app.services.asset_id') }}</label>
						<select name="asset_id" id="" class="form-control js-example-basic-single" style="width: 100%">
							<option selected disabled value="">{{ __('app.services.placeholder.asset_id') }}</option>
							@foreach ($assets as $asset)
							<option value="{{ $asset->id }}" {{ $service->asset_id == $asset->id ? ' selected' : ' ' }}>
								{{ $asset->barcode }} - {{ $asset->brand }}</option>
							@endforeach
						</select>
					</div>
					<!-- Service date -->
					<div class="form-group">
						<label for="">{{ __('app.services.service_date') }}</label>
						<input type="date" name="service_date" id="" value="{{ $service->service_date->format('Y-m-d') }}"
							class="form-control">
					</div>
					<!-- Description -->
					<div class="form-group">
						<label for="">{{ __('app.services.description') }}</label>
						<textarea name="description" id="" cols="30" rows="3"
							class="form-control">{{ $service->description }}</textarea>
					</div>
					<!-- Tanggal Kembali -->
					<div class="form-group">
						<label class="">{{ __('app.services.return_date') }}</label>
						<input type="date" name="return_date" value="{{ optional($service->return_date)->format('Y-m-d') ?? '' }}"
							class="form-control" />
						@error('return_date')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
						@enderror
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary font-weight-bold">Save changes</button>
				</div>
			</form>
		</div>
	</div>
</div>
