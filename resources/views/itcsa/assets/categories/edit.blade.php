@extends('layout.default')

@section('title', __('app.categories.pages.create'))

@section('content')

<div class="card card-custom">
	<div class="card-header flex-wrap border-0 pt-6 pb-0">
		<div class="card-title">
			<h3>
				{{ __('app.categories.pages.create') }}
				<span class="d-block text-muted pt-2 font-size-sm">Sorting & pagination remote datasource</span>
			</h3>
		</div>
	</div>
	<div class="card-body">
		<form action="{{ route('itcsa.asset.categories.update', $assetCategory->id) }}" method="post" enctype="multipart/form-data">
			@csrf
			@method('PUT')
			<!-- Nama Peminjam -->
			<x-forms.input name="name" :model="$assetCategory" trans="categories" :required="true" />

			<!-- Submit -->
			<x-buttons.submit />

			<!-- Back -->
			<x-buttons.back routeName="itcsa.asset.categories" />

		</form>
	</div>
</div>

@endsection
