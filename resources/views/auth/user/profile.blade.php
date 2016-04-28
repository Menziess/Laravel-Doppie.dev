@extends('layouts.app')

@section('content')
<div class="container">

	<div class"row row-centered">

		<div class="card card-block">
			<h4 class="card-title">Picture</h4>
			@include('auth.user.upload')

			<div class="row margin-bottom-20">
				<div class="col-md-3">
				@if($user && $user->profile->resource)
				<img src="{{ asset('images/largeprofile/' . $user->getKey()) }}" class="img-circle profile-picture-small" width="400"  alt="" >
				@else
				<img src="{{ asset('img/placeholder.jpg') }}" class="img-circle width-200 profile-picture-small" alt="" >
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
				<a data-toggle="modal" data-target="#modal" href="#" class="btn btn-primary">Don't press!</a>
				</div>
				</div>
			@endif
		</div>
	</div>
</div>
@endsection

