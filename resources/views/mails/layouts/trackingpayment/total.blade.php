<table style="width: 100%; border: 1px solid black; border-collapse: collapse;">
    <thead>
        <tr>
            {{-- <th rowspan="2" class="text-center" style="vertical-align: middle">Area</th>
			<th rowspan="2" class="text-center" style="vertical-align: middle">Cabang</th> --}}
            <th colspan="3" style="background-color: #ACACAC; text-align:center; border:1px solid black;">Total</th>
        </tr>
        <tr>
            <th style="border:1px solid black;">Target Collection</th>
            <th style="border:1px solid black;">Realisasi Collection</th>
            <th style="border:1px solid black;">Percentage</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($trackingpayments['total'] as $area => $total_payments)
            {{-- @php
			$branch_total = count($total_payments)
		@endphp

		<tr>
			<td rowspan="{{ $branch_total + 1 }}">{{ $area }}</td>
		</tr> --}}

            @foreach ($total_payments as $branch => $total_payment)
                <tr>
                    @if ($branch == 'TOTAL')
                        {{-- <td style="font-weight: 600; background-color: yellow">{{ $branch }}</td> --}}
                        <td style="font-weight: 600; background-color: yellow; border:1px solid black;">
                            {{ __('app.operators.rupiah') }}
                            {{ number_format($total_payment['target'] ?? 0) }}</td>
                        <td style="font-weight: 600; background-color: yellow; border:1px solid black;">
                            {{ __('app.operators.rupiah') }}
                            {{ number_format($total_payment['realisasi_payment'] ?? 0) }}</td>
                        <td style="font-weight: 600; background-color: yellow; border:1px solid black;">
                            {{ round($total_payment['index'], 2) }}{{ __('app.operators.percentage') }}</td>
                    @else
                        {{-- <td>{{ $branch }}</td> --}}
                        <td style="border:1px solid black;">{{ __('app.operators.rupiah') }}
                            {{ number_format($total_payment['target'] ?? 0) }}</td>
                        <td style="border:1px solid black;">{{ __('app.operators.rupiah') }}
                            {{ number_format($total_payment['realisasi_payment'] ?? 0) }}</td>
                        <td style="border:1px solid black;">
                            {{ round($total_payment['index'] ?? 0, 2) }}{{ __('app.operators.percentage') }}</td>
                    @endif
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
