@extends('layouts.app')

@section('content')

<div class="container">

	<div class"row row-centered">


		<div class="card card-block">
			<h4 class="card-title">Picture</h4>

			<div id="modal" class="modal fade">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
							<h4 class="modal-title">Upload</h4>
						</div>
						<div class="modal-body">
							<p> // </p>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary-outline" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary-outline">Save</button>
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->

			<div class="row margin-bottom-20">
				<div class="col-md-3">
				@if($user && $user->profile->resource)
				<img src="{{ asset('storage/images/' . $user->profile->resource->original_name . $user->profile->resource->original_extension) }}" data-toggle="modal" data-target="#modal" class="img-circle profile-picture-small" width="400"  alt="" >
				<!-- <img src="{{ asset('images/profile/' . $user->getKey()) }}" data-toggle="modal" data-target="#modal" class="img-circle profile-picture-small" width="400"  alt="" > -->
				@else
				<img src="{{ asset('img/placeholder.jpg') }}" data-toggle="modal" data-target="#modal" class="img-circle width-200 profile-picture-small" alt="" >
				@endif
				</div>
			</div>
		</div>

		<div class="card card-block">
			@if($user && $user->profile)
			<h4 class="card-title">Profile</h4>
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
			@endif
		</div>


	</div>

</div>

@endsection

