<div class="form-group">
	<label for="" class="h4">
		<strong>Products</strong>
	</label>
	<div class="row">
		@foreach ($products as $product)
		<div class="col-md font-weight-bolder">
			<ul>
				<li>{{ $product->InvtId }} - {{ $product->Descr }}</li>
			</ul>
		</div>
		@endforeach
	</div>
</div>

<hr>

<div class="mb-2">
	<!-- Add Tier Button -->
	<a href="{{ route('tiers.create', $program->id) }}" class="btn btn-primary">{{ __('app.tiers.pages.create') }}</a>
	<!-- Back Button -->
	<x-buttons.back routeName="programs.index" />
</div>

<table id="example" class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>{{ __('app.tables.number') }}</th>
			<th>{{ __('app.tables.name') }}</th>
			<th>{{ __('app.tiers.minimum_pcs') }}</th>
			{{-- <th>{{ __('app.tiers.maximum_pcs') }}</th> --}}
			<th>{{ __('app.tiers.minimum_purchase') }}</th>
			{{-- <th>{{ __('app.tiers.maximum_purchase') }}</th> --}}
			<th>{{ __('app.tiers.cashback') }}</th>
			<th>{{ __('app.tiers.monthly_volume') }}</th>
			<th>{{ __('app.tables.action') }}</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($program->programTiers as $tier)
		<tr>
			<td>{{ $loop->iteration }}</td>
			<td>{{ $tier->name }}</td>
			<td>{{ $tier->minimum_pcs }}</td>
			{{-- <td>{{ $tier->maximum_pcs }}</td> --}}
			<td>{{ __('app.operators.rupiah') }}{{ number_format($tier->minimum_purchase) }}</td>
			{{-- <td>{{ __('app.operators.rupiah') }}{{ number_format($tier->maximum_purchase) }}</td> --}}
			<td>{{ $tier->formatted_cashback }}</td>
			<td>{{ $tier->monthly_volume }}{{ __('app.operators.percentage') }} </td>
			<td>
				<!-- Edit Button -->
				<x-buttons.edit routeName="tiers" :id="$tier->id" />
				<!-- Delete Button -->
				<x-buttons.delete routeName="tiers" :id="$tier->id" />
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
