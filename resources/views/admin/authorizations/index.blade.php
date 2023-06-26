@extends('layout.default')

@section('title', 'Auth')

@section('styles')
<style>
	/* body {
		font-family: 'Arial', sans-serif;
		padding: 0px;
	} */

	.slider {
		width: 100%;
		/* text-align: center; */
		overflow: hidden;
	}

	.slides {
		display: flex;
		overflow-x: auto;
		scroll-snap-type: x mandatory;
		scroll-behavior: smooth;
		padding-bottom: 5px;
		-webkit-overflow-scrolling: touch;
	}

	.slides::-webkit-scrollbar {
		width: 3px;
		height: 8px;
	}

	.slides::-webkit-scrollbar-thumb {
		background: rgb(171, 171, 171);
		border-radius: 5px;
	}

	.slides::-webkit-scrollbar-track {
		background: transparent;
	}

	.slides>div {
		scroll-snap-align: start;
		flex-shrink: 0;
		width: 220px;
		height: 350px;
		margin: 0 10px 0 10px;
		border-radius: 7px;
		background: #fff;
		transform-origin: center center;
		transform: scale(1);
		transition: transform 0.5s;
		position: relative;
		border: 1px solid #555;
		/* display: flex; */
		justify-content: center;
		align-items: center;
		overflow: hidden;
		font-size: 100%;
	}

</style>

@section('content')

<div class="card">
	<div class="card-body">
		<form action="#" method="POST" enctype="multipart/form-data">
			@csrf
			<div class="form-group">
				<label for="">{{ __('app.users.username') }}</label>
				<label for="" class="text-danger"> * </label>
				<select name="user_id" class="form-control" id="">
					@foreach ($users as $user)
					<option value="{{ $user->id }}">{{ $user->username }}</option>
					@endforeach
				</select>
			</div>

			<div class="form-group">
				<label for="">Auth</label>
				<div class="slider">
					<div class="slides">
						@foreach ($group_menus as $key => $menus)
						<div>
							<table class="table">
								<thead class="text-center">
									<tr>
										<th>{{ $key }}</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($menus as $menu)
									<tr>
										<td>
											<label class="checkbox">
												<input type="checkbox" name="menu_ids[]" value="{{ $menu->id }}"/>
												<span class="mr-3"></span>
												{{ $menu->title }}
										</label>
											</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

@endsection
