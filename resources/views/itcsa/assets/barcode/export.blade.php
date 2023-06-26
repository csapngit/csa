<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
	<style>
		* {
			box-sizing: border-box;
		}

		/* Create two equal columns that floats next to each other */
		.column {
			float: left;
			width: 33%;
			height: auto;
			margin-right: 5px;
			margin-bottom: 5px;
			border: 1px solid black;
			text-align: center;
			/* Should be removed. Only for demonstration */
		}

		/* Clear floats after the columns */
		.row:after {
			content: "";
			display: table;
			clear: both;
		}

		.barcode {
			margin: auto;
		}

		.number {
			letter-spacing: 5px;
		}

	</style>
</head>

<body>
	@foreach (collect($assets)->chunk(3) as $chunk)
	<div class="row">
		@foreach ($chunk as $asset)
		<div class="column">
			<div style="font-size: 12px">
				Asset milik PT. Catur Sentosa Adiprana
			</div>
			<table class="barcode">
				{!! DNS1D::getBarcodeHTML($asset->barcode, 'CODABAR', 2.3, 40) !!}
			</table>
			<div class="number">
				{{ $asset->barcode }}
			</div>
		</div>
		@endforeach
	</div>
	@endforeach
</body>

</html>
