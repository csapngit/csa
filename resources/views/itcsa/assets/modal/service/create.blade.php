<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
	{{ __('app.services.pages.create') }}
</button>

<!-- Modal Service-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">{{ __('app.services.pages.create') }}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<i aria-hidden="true" class="ki ki-close"></i>
				</button>
			</div>
			<form action="{{ route('itcsa.asset-services.store') }}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="modal-body">
					<!-- Asset barcode -->
					<div class="form-group">
						<label for="">{{ __('app.services.asset_id') }}</label>
						<select name="asset_id" class="form-control select2 @error('asset_id') is-invalid @enderror"
							style="width: 100%">
							@foreach ($assetForServices as $assetService)
							<option></option>
							<option value="{{ $assetService->id }}"
								{{ $assetService->service_date && $assetService->return_date == null ? ' disabled' : '' }}>
								{{ $assetService->barcode }} - {{ $assetService->brand }}</option>
							@endforeach
						</select>
						@error('asset_id')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
						@enderror
					</div>
					<!-- Service date -->
					<div class="form-group">
						<label for="">{{ __('app.services.service_date') }}</label>
						<input type="date" name="service_date" id=""
							class="form-control @error('service_date') is-invalid @enderror">
						@error('service_date')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
						@enderror
					</div>
					<!-- Description -->
					<div class="form-group">
						<label for="">{{ __('app.services.description') }}</label>
						<textarea name="description" id="" cols="30" rows="3"
							class="form-control @error('service_date') is-invalid @enderror"></textarea>
						@error('description')
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
