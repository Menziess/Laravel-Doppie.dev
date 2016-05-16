@extends('layouts.app')

@section('content')

<div class="container">

	@if($subject && $subject->profile)


		@include('content.user.partials.picture')

		@include('content.user.partials.profile')

		@include('content.user.partials.password')

	@endif



	@if(Auth::user()->is_admin && Auth::user()->getKey() != $subject->getKey())

		@include('content.admin.partials.userpanel')

	@else

		@include('content.user.partials.delete')

	@endif

</div>

@endsection
