<table>
	<thead>
		<tr>number</tr>
		<tr>billname</tr>
	</thead>
	<tbody>
		@foreach ($soMonitorings as $asd)
		<tr>
			<td>{{ $loop->iteration }}</td>
			<td>{{ $asd->billname }}</td>
		</tr>
		@endforeach
	</tbody>
</table>
