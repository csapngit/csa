<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
	<style type="text/css">
		* {
			box-sizing: border-box;
		}

		.total {
			font-weight: 700;
			background: #9999b9;
		}

		@media only screen and (max-width: 479px) {

			.right_column,
			.left_column {
				width: 100% !important;
				text-align: center;
				margin: 0 auto !important;
			}

			.deviceWidth {
				width: 300px !important;
				padding: 0;
			}
		}

	</style>
</head>

<body>
	<h3 style="text-align: center">DSR REPORT</h3>

	@include('mails.layouts.dsr.header-timegone')

	<br />
	<br />

	@include('mails.layouts.dsr.channel')

	<br />
	<br />
	<br />

	@include('mails.layouts.dsr.branch')

</body>

</html>
