@extends('layout.default')

@section('title', 'API')

@section('content')

<form action="#" method="GET" id="form_tds">
	@csrf

	<div class="form-group">
		<div class="row">
			<div class="col-sm-1">
				<label for="" class="col col-form-label">Api</label>
			</div>
			<div class="col">
				<select name="" id="api_select" class="form-control select2" style="width: 100%">
					<option selected disabled value="">Select Api</option>
					@foreach ($apis as $api)
					<option value="{{ $api->route }}">{{ $api->name }}</option>
					@endforeach
				</select>
			</div>
		</div>
	</div>
	<button type="submit" class="btn btn-sm btn-primary" formtarget="_blank">POST</button>
</form>
@endsection

@section('scripts')
<script>
	$(document).ready(function () {
		$('#api_select').on('change', function () {
			var route = this.value;
			$('#form_tds').attr('action', route);
			console.log($('#form_tds').attr('action'));
		});
	});

</script>
@endsection
