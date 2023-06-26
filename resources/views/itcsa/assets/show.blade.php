@extends('layout.default')

@section('title', __('app.assets.barcode'))

@section('content')

<div class="row">
	<div class="col">
		<div class="card card-custom mb-2">
			<div class="card-header flex-wrap border-0 pt-6 pb-0">
				<div class="card-title">
					<h3>
						{{ __('app.assets.barcode') }}
						<span class="d-block text-muted pt-2 font-size-sm">Sorting & pagination remote datasource</span>
					</h3>
				</div>
			</div>
			<div class="card-body">
				<div class="mb-5" style="margin-left: 7.5%">
					{!! DNS1D::getBarcodeSVG($asset->barcode, 'CODABAR', 1.5, 60) !!}
				</div>
				<hr>
				<div class="form-group row">
					<label class="col-md-4 col-form-label">{{ __('app.assets.barcode') }}</label>
					<label class="col-md col-form-label">: {{ $asset->barcode }}</label>
				</div>
				<div class="form-group row">
					<label class="col-md-4 col-form-label">{{ __('app.assets.category_id') }}</label>
					<label class="col-md col-form-label">: {{ $asset->category['name'] }}</label>
				</div>
				<div class="form-group row">
					<label class="col-md-4 col-form-label">{{ __('app.assets.brand') }}</label>
					<label class="col-md col-form-label">: {{ $asset->brand }}</label>
				</div>
				<div class="form-group row">
					<label class="col-md-4 col-form-label">{{ __('app.assets.serial_number') }}</label>
					<label class="col-md col-form-label">: {{ $asset->serial_number }}</label>
				</div>
				<div class="form-group row">
					<label class="col-md-4 col-form-label">{{ __('app.assets.purchase_date') }}</label>
					<label class="col-md col-form-label">: {{ $asset->purchase_date->format('d-m-Y') }}</label>
				</div>
				<div class="form-group row">
					<label class="col-md-4 col-form-label">{{ __('app.assets.name') }}</label>
					<label class="col-md col-form-label">: {{ $asset->name }}</label>
				</div>
				<div class="form-group row">
					<label class="col-md-4 col-form-label">{{ __('app.assets.division_id') }}</label>
					<label class="col-md col-form-label">: {{ $asset->division->name }}</label>
				</div>
				<div class="form-group row">
					<label class="col-md-4 col-form-label">{{ __('app.assets.branch_id') }}</label>
					<label class="col-md col-form-label">: {{ $asset->branch->BranchName }}</label>
				</div>
				<div class="form-group row">
					<label class="col-md-4 col-form-label">{{ __('app.assets.lend_date') }}</label>
					<label class="col-md col-form-label">: {{ $asset->lend_date->format('d-m-Y') }}</label>
				</div>
				<div class="form-group row">
					<label class="col-md-4 col-form-label">{{ __('app.assets.return_date') }}</label>
					<label class="col-md col-form-label">: {{ optional($asset->return_date)->format('d-m-Y') }}</label>
				</div>
				<div class="form-group row">
					<label class="col-md-4 col-form-label">{{ __('app.assets.description') }}</label>
					<label class="col-md col-form-label">: {{ $asset->description }}</label>
				</div>
			</div>
		</div>
	</div>
	<div class="col">
		<div class="card card-custom" style="height: 900px" id="kt_page_stretched_card">
			<div class="card-header flex-wrap border-0 pt-6 pb-0">
				<div class="card-title">
					<h3>
						{{ __('app.services.pages.index') }}
						<span class="d-block text-muted pt-2 font-size-sm">Sorting & pagination remote datasource</span>
					</h3>
				</div>
			</div>
			<div class="card-body">
				<div class="card-scroll">
					@forelse ($asset->services as $service)
					<div class="form-group row">
						<label class="col-md-4 col-form-label">{{ __('app.services.service_date') }}</label>
						<label class="col-md col-form-label">: {{ $service->service_date->format('d-m-Y') }}</label>
					</div>
					<div class="form-group row">
						<label class="col-md-4 col-form-label">{{ __('app.services.description') }}</label>
						<label class="col-md col-form-label">: {{ $service->description }}</label>
					</div>
					<div class="form-group row">
						<label class="col-md-4 col-form-label">{{ __('app.services.return_date') }}</label>
						<label class="col-md col-form-label">: {{ optional($service->return_date)->format('d-m-Y') }}</label>
					</div>
					<div class="form-group row">
						<label class="col-md-4 col-form-label">{{ __('app.services.status') }}</label>
						<label class="col-md col-form-label">: {{ $service->return_date ? 'Complete' : 'On service' }}</label>
					</div>
					<hr style="border: 1px solid black">
					@empty
					<div style="text-align: center">
						There is no service for this asset
					</div>
					@endforelse
				</div>
			</div>
		</div>
	</div>
</div>

<x-buttons.back routeName="itcsa.assets.index" />

@endsection

@section('scripts')

<script>
	var KTLayoutStretchedCard = function () {
		// Private properties
		var _element;

		// Private functions
		var _init = function () {
			var scroll = KTUtil.find(_element, '.card-scroll');
			var cardBody = KTUtil.find(_element, '.card-body');
			var cardHeader = KTUtil.find(_element, '.card-header');

			var height = 650;

			console.log(height);

			// height = height - parseInt(KTUtil.actualHeight(cardHeader));

			// height = height - parseInt(KTUtil.css(_element, 'marginTop')) - parseInt(KTUtil.css(_element, 'marginBottom'));
			// height = height - parseInt(KTUtil.css(_element, 'paddingTop')) - parseInt(KTUtil.css(_element,
			// 	'paddingBottom'));

			// height = height - parseInt(KTUtil.css(cardBody, 'paddingTop')) - parseInt(KTUtil.css(cardBody,
			// 	'paddingBottom'));
			// height = height - parseInt(KTUtil.css(cardBody, 'marginTop')) - parseInt(KTUtil.css(cardBody, 'marginBottom'));

			// height = height - 3;

			KTUtil.css(scroll, 'height', height + 'px');
		}

		// Public methods
		return {
			init: function (id) {
				_element = KTUtil.getById(id);

				if (!_element) {
					return;
				}

				// Initialize
				_init();

				// Re-calculate on window resize
				KTUtil.addResizeHandler(function () {
					_init();
				});
			},

			update: function () {
				_init();
			}
		};
	}();

	// Webpack support
	if (typeof module !== 'undefined') {
		module.exports = KTLayoutStretchedCard;
	}

</script>

@endsection
