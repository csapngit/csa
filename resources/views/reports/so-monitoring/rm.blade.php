<!-- So Header -->
@include('reports.so-monitoring.layouts.header')

<div class="form-group">
	<div class="card">
		<div class="card-body">
			<form action="{{ route('report.report.so-monitoring') }}" method="GET" enctype="multipart/form-data">
				@csrf
				<div class="row align-items-center">
					<div class="col-lg-9 col-xl-8">
						<div class="row align-items-center">

							<div class="col-md-4 my-2 my-md-0">
								<div class="d-flex align-items-center">
									<label class="mr-4 mb-0 d-none d-md-block">{{ __('app.area.area') }}:</label>
									<select class="form-control" name="area">
										<option value="all">All</option>
										@foreach ($regions as $region)
										<option value="{{ $region }}" {{ request()->area == $region ? ' selected' : '' }}>{{ $region }}
										</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="col-md-4 my-2 my-md-0">
								<div class="d-flex align-items-center">
									<label class="mr-4 mb-0 d-none d-md-block">Status:</label>
									<select class="form-control" name="status">
										<option selected value="all">All</option>
										@foreach ($statuses as $key => $status)
										<option value="{{ $key }}" {{ request()->status == $key ? ' selected' : '' }}>{{ $status }}</option>
										@endforeach
									</select>
								</div>
							</div>

							<!-- Refresh Button -->
							<button type="submit" class="btn btn-success mr-3">Refresh</button>
							<!-- Sync Button -->
							<button type="button" class="btn btn-warning mr-3 flaticon-refresh" title="Run Sync"></button>
							<!-- Download Button -->
							<button type="button" class="btn btn-primary mr-3 flaticon-download" title="Download"></button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- So Header Total -->
@include('reports.so-monitoring.layouts.total')

<div class="card card-custom mb-2">
	<div class="card-header flex-wrap border-0 pt-6 pb-0">
		<div class="card-title">
			<h3>
				SO Monitoring Detail
				<span class="d-block text-muted pt-2 font-size-sm">Sorting & pagination remote datasource</span>
			</h3>
		</div>
	</div>
	<div class="card-body">
		<table class="table table-striped" id="example">
			<thead>
				<tr>
					<th>Customer ID</th>
					<th>Cabang</th>
					<th>Name</th>
					<th>Order Number</th>
					<th>Qty Order</th>
					<th>Total Order (Rp.)</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($dataSoDetail as $soDetail)
				<tr>
					<td>
						<a href="#" data-toggle="modal" data-target="#modal{{ $soDetail['id'] }}">
							{{ $soDetail['customer_id'] }}
						</a>
					</td>
					<td>{{ $soDetail['cabang'] }}</td>
					<td>{{ $soDetail['name'] }}</td>
					<td>{{ $soDetail['order_number'] }}</td>
					<td>{{ $soDetail['qty_order'] }}</td>
					<td>{{ __('app.operators.rupiah') }}{{ number_format($soDetail['total_order']) }}</td>
				</tr>

				<!-- Modal-->
				@include('reports.so-monitoring.modals.show')

				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<th>Customer ID</th>
					<th>Cabang</th>
					<th>Name</th>
					<th>Order Number</th>
					<th>Qty Order</th>
					<th>Total Order (Rp.)</th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
