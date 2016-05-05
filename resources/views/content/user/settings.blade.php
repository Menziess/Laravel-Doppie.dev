@extends('layouts.app')

@section('content')


	@if($user && $user->profile)


		@include('content.user.partials.picture')

		@include('content.user.partials.profile')

		@include('content.user.partials.password')

	@endif



	@if(Auth::user()->is_admin && Auth::user()->getKey() != $user->getKey())

		@include('content.admin.partials.userpanel')

	@else

		@include('content.user.partials.delete')

	@endif


@endsection
