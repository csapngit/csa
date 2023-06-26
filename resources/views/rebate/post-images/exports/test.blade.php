<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
</head>
<body>

	<table>
		<thead>
			<tr>
				<th>Brand</th>
				<th>Image</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($programImages as $program)
			<tr>
				<td>{{ $program->brand_name }}</td>
				<td>{{ $program->text }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>

</body>
</html>
