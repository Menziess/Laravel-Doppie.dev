@extends('layouts.app')

@section('content')


	@if($user && $user->profile)

		<div class="card">
			<!-- <img class="card-img-top" data-src="..." alt="Card image cap"> -->
			<div class="card-block">
				<h4 class="card-title">Welcome to your profile</h4>
				<p class="card-body">
					This page is exactely what other people will see about you.
				</p>
			</div>
		</div>

	@endif


@endsection
