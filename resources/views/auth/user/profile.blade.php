@extends('layouts.app')

@section('content')
<div class="container">

	<div class"row row-centered">

		<div class="card card-block">
			@if($user && $user->profile)
			<h4 class="card-title">Profile</h4>
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
				<a href="#" class="btn btn-primary">Don't press!</a>
			@endif
		</div>
	</div>

</div>
@endsection

