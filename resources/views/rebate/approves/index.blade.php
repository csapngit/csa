@extends('layout.default')

@section('title', 'Approve')

@section('content')
<div class="card card-custom">
	<div class="card-body">

		<x-alerts.alert condition="success" />

		<x-alerts.alert condition="warning" />

		<form action="{{ route('approves.store') }}" method="POST" enctype="multipart/form-data">
			@csrf
			<!-- Select and status -->
			<livewire:status-approve />
		</form>
	</div>
</div>
@endsection
