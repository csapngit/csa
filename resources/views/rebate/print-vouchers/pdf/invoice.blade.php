<!DOCTYPE html>
<html>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
		* {
			box-sizing: border-box;
		}

		/* Create two equal columns that floats next to each other */
		.column {
			float: left;
			width: 40%;
			padding-right: 20px;
			margin-right: 5px;
			margin-bottom: 10px;
			height: 500px;
			font-size: 10px;
			align-content: center;
			/* Should be removed. Only for demonstration */
		}

		/* Clear floats after the columns */
		.row:after {
			content: "";
			display: table;
			clear: both;
		}

		.page-break {
			page-break-after: always;
		}

		img {
			position: relative;
			left: 50px;
			top: 5px;
			width: 50%;
			margin-bottom: 15px;
		}

		.notes {
			position: relative;
			bottom: 10px;
			margin-left: 5px;
			margin-right: 2px;
			font-size: 8px;
		}

	</style>
</head>

<body>

	@foreach ($generateData->chunk(2) as $chunk)
	<div class="row">
		@foreach ($chunk as $generate)
		<div class="column" style="border: 1px solid black">
			{{-- <img src="{{ asset('media/catur_sentosa.jpg') }}" alt=""> --}}
			<h3 style="text-align: center">PT. Catur Sentosa Adiprana Tbk.</h3>
			<table style="margin: auto">
				<thead>
					<tr>
						<th colspan="3">{{ $generate['voucher'] }}</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>{{ __('app.invoices.customer_id') }}</td>
						<td>:</td>
						<td>{{ $generate['customer_id'] }}</td>
					</tr>
					<tr>
						<td>{{ __('app.invoices.client') }}</td>
						<td>:</td>
						<td>{{ $generate['name'] }}</td>
					</tr>
					<tr>
						<td>{{ __('app.invoices.invoice') }}</td>
						<td>:</td>
						<td>{{ $generate['invoice_number'] }}</td>
					</tr>
					<tr>
						<td>{{ __('app.invoices.sales_person') }}</td>
						<td>:</td>
						<td>{{ $generate['sales_person'] }}</td>
					</tr>
					<tr>
						<td>{{ __('app.invoices.total') }}</td>
						<td>:</td>
						<td style="font-weight: 500">{{__('app.operators.rupiah')}} {{ number_format($generate['total_invoice']) }}
						</td>
					</tr>
					<tr>
						<td colspan="3">
							<hr>
						</td>
					</tr>
					@foreach ($generate['programs'] as $program)
					<!-- Program Regular Display and Volume -->
					@if (in_array('program_display', array_keys($program)))
					<tr>
						<td>{{ $program['program_display'] }}</td>
						<td>:</td>
						<td>{{__('app.operators.rupiah')}} {{ number_format($program['amount_display']) }}</td>
					</tr>
					<tr>
						<td>{{ $program['program_volume'] }}</td>
						<td>:</td>
						<td>{{__('app.operators.rupiah')}} {{ number_format($program['amount_volume']) }}</td>
					</tr>
					@endif
					<!-- Program Sessional -->
					@if (in_array('program_sessional', array_keys($program)))
					<tr>
						<td>{{ $program['program_sessional'] }}</td>
						<td>:</td>
						<td>{{__('app.operators.rupiah')}} {{ number_format($program['amount_sessional']) }}</td>
					</tr>
					@endif
					@endforeach
					<tr>
						<td colspan="3">
							<hr>
						</td>
					</tr>
					<tr>
						<td>{{ (__('app.invoices.paid')) }}</td>
						<td>:</td>
						<td style="font-weight: 500">{{ __('app.operators.rupiah') }} {{ number_format($generate['payment']) }}</td>
					</tr>
				</tbody>
			</table>
			<table style="text-align: center; width: 100%; margin-top: 10px;">
				<tr>
					<td>Pelanggan</td>
					<td>Sales Manager</td>
				</tr>
				<tr>
					<td style="height: 40px">(..............)</td>
					<td>(..............)</td>
				</tr>
			</table>
			<div class="notes">
				<p>* Potongan dianggap sah apabila ada tanda tangan pelanggan atau cap/stempel toko.</p>
				<p>* Mohon mencantumkan nama jelas pada kolom tanda tangan.</p>
			</div>
		</div>
		@endforeach
	</div>
	{{-- <div class="page-break"></div> --}}
	@endforeach


</body>

</html>
