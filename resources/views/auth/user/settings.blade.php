@extends('layouts.app')

@section('content')

<div class="container">

	<div class"row row-centered">


		@if($user && $user->profile)


			@include('auth.user.partials.picture')

			@include('auth.user.partials.profile')

			@include('auth.user.partials.password')

		@endif



		@if(Auth::user()->is_admin && Auth::user()->getKey() != $user->getKey())

			@include('auth.admin.panel')

		@else

			@include('auth.user.partials.delete')

		@endif


	</div>
</div>

@endsection
