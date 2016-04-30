@extends('layouts.app')

@section('content')

<div class="container">

	<div class"row row-centered">

		@if($user && $user->profile)
		<div class="card card-block">
			<h4 class="card-title">Profile {{ $user->id }} {{ $user->is_active ? 'active' : 'deactivated'}}</h4>
			<div class="row margin-bottom-20">
				<div class="col-md-6">
				<p class="card-text">Name: {{ $user->first_name . ' ' . $user->last_name ?: '#' }}</p>
				<p class="card-text">Email: {{ $user->email ?: '#' }}</p>
				<p class="card-text">Gender: {{ $user->profile->gender ?: '#' }}</p>
				<p class="card-text">Birthday: {{ $user->profile->date_of_birth ?: '#' }}</p>
				<p class="card-text">Location:
				@if($user->profile->latitude)
					<a href="https://www.google.nl/maps/@"{{ $user->profile->latitude }}","{{ $user->profile->longitude }}",15z?hl=en" target="blank">
						{{ $user->profile->latitude . ' ' . $user->profile->longitude }}
					</a>
				@else
				#
				@endif
				</p>
				</div>
			</div>
		</div>
		<div class="card card-block">
			<h4 class="card-title">Picture</h4>

			<div class="row margin-bottom-20">
				<div class="col-md-3">
				@if($user && $user->profile->resource)
				<img src="{{ asset('images/profile/' . $user->getKey()) }}" class="img-circle profile-picture-small" width="400"  alt="" >
				@else
				<img src="{{ asset('img/placeholder.jpg') }}" class="img-circle width-200 profile-picture-small" alt="" >
				@endif
				</div>
			</div>
		</div>


		<div class="card card-block">
			<h4 class="card-title">Account</h4>
			<div id="modal" class="modal fade">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
							<h4 class="modal-title">Delete account</h4>
						</div>
						<div class="modal-body">
							<p>
								Deleting this account will also remove all associated private data.
							</p>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<a href="{{ url('/user/delete/' . $user->getKey()) }}" class="btn btn-danger" role="button">Delete</a>
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->

			<a href="{{ url('/user/activate/' . $user->getKey()) }}" class="btn btn-secondary-outline" role="button">Activate</a>
			<a href="{{ url('/user/deactivate/' . $user->getKey()) }}" class="btn btn-warning-outline" role="button">Deactivate</a>
			<a data-toggle="modal" data-target="#modal" href="#" class="btn btn-danger">Delete</a>
		</div>

		@endif

	</div>

</div>

@endsection
