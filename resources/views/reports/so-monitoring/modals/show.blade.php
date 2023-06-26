<div class="modal fade" id="modal{{ $soDetail['id'] }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel">{{ $soDetail['name'] }}</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<i aria-hidden="true" class="ki ki-close"></i>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<label for="" class="col col-form-label">{{ __('app.reports.so-monitorings.inventory_id') }}</label>
					<label for="" class="col col-form-label">{{ __('app.reports.so-monitorings.qty_so') }}</label>
					<label for="" class="col col-form-label">{{ __('app.reports.so-monitorings.total_so') }}</label>
				</div>
				@foreach ($soDetail['details'] as $detail)
				<div class="row">
					<div class="col font-weight-bolder">
						<ul>
							<li>{{ $detail['inventory_id'] }}</li>
						</ul>
					</div>
					<div class="col font-weight-bolder">
						{{ $detail['qty_order'] }}
					</div>
					<div class="col font-weight-bolder">
						{{ __('app.operators.rupiah') }}{{ number_format($detail['total_order']) }}
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>
</div>
